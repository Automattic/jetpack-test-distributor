<?php
namespace Automattic\Human_Testable\Data_Sources;

require_once( __DIR__ . DIRECTORY_SEPARATOR . 'class.data-source.php' );
require_once( dirname( __DIR__ ) . DIRECTORY_SEPARATOR . 'test-items' . DIRECTORY_SEPARATOR . 'class.jetpack-test-item.php' );
require_once( dirname( __DIR__ ) . DIRECTORY_SEPARATOR . 'env' . DIRECTORY_SEPARATOR . 'class.environment.php' );
require_once( dirname( __DIR__ ) . DIRECTORY_SEPARATOR . 'env' . DIRECTORY_SEPARATOR . 'class.environment-set.php' );
require_once( dirname( __DIR__ ) . DIRECTORY_SEPARATOR . 'utils' . DIRECTORY_SEPARATOR . 'class.semver-helper.php' );

use PDO;
use Automattic\Human_Testable\Test_Items\Jetpack_Test_Item;
use Automattic\Human_Testable\Utils\Semver_Helper;
use Automattic\Human_Testable\Env\Environment;
use Automattic\Human_Testable\Env\Environment_Set;

/**
 * Jetpack PDO class for a data source
 */
class PDO_Jetpack_Data_Source extends Data_Source {
	/**
	 * PDO connection
	 *
	 * @var \PDO
	 */
	private $pdo;

	/**
	 * Constructor
	 *
	 * @param string $dsn      DSN string for DBO connection.
	 * @param string $username Username for the connection.
	 * @param string $password Password for the connection.
	 * @param array  $options DBO connection options.
	 */
	public function __construct( $dsn, $username, $password, $options = array() ) {
		$this->pdo = new PDO( $dsn, $username, $password, $options );
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_environment_set( $site_id, array $environment ) {
		$environment = $this->generate_environment( $environment );
		return $this->load_completed_tests( $site_id, new Environment_Set( $environment ) );
	}

	/**
	 * Get an array of versions and their modified modules.
	 *
	 * @return array Associative array with version => (array) of modules
	 */
	public function get_version_modules() {
		static $version_modules;
		if ( ! isset( $version_modules ) ) {
			$version_modules = $this->load_version_modules();
		}
		return $version_modules;
	}

	/**
	 * Load the versions and modules from the database.
	 *
	 * @return array Associative array with version => (array) of modules
	 */
	public function load_version_modules() {
		$jti_query = $this->pdo->prepare( 'SELECT `jv`.* FROM `jetpack_versions` `jv`' );
		$jti_query->execute();
		$versions = array();
		while ( $row = $jti_query->fetch( PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT ) ) {
			$versions[ $row['version'] ] = json_decode( $row['touched_modules'], true );
		}
		return $versions;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_tests() {
		$jti_query = $this->pdo->prepare( 'SELECT `jti`.* FROM `jetpack_test_items` `jti` WHERE `jti`.`active`=1' );
		$jti_query->execute();
		$tests = array();
		while ( $row = $jti_query->fetch( PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT ) ) {
			$test_item = $this->prepare( $row );
			$tests[ $test_item->get_id() ] = $test_item;
		}
		return $tests;
	}

	/**
	 * Loads the environment set
	 *
	 * @param  int             $site_id         Current site ID
	 * @param  Environment_Set $environment_set Loaded current environment set
	 * @return Environment_Set Same environment set
	 */
	public function load_completed_tests( $site_id, Environment_Set $environment_set ) {
		$current_environment = $environment_set->get_current_environment();
		$query_params = array( ':site_id' => $site_id );
		$query_str = 'SELECT `jtic`.* FROM `jetpack_test_items_completed` `jtic` WHERE `jtic`.`site_id`=:site_id';
		if ( isset( $current_environment['wp_version'] ) ) {
			$query_str .= ' AND `jtic`.`wp_version`=:wp_version';
			$query_params['wp_version'] = $current_environment['wp_version'];
		}
		if ( isset( $current_environment['php_version'] ) ) {
			$query_str .= ' AND `jtic`.`php_version`=:php_version';
			$query_params['php_version'] = $current_environment['php_version'];
		}
		if ( isset( $current_environment['jp_major_version'] ) ) {
			$query_str .= ' AND `jtic`.`jp_version` LIKE :jp_major_version_search';
			$query_params['jp_major_version_search'] = $current_environment['jp_major_version'] . '%';
		}
		$jtic_query = $this->pdo->prepare( $query_str );
		$jtic_query->execute( $query_params );
		$tests = $jtic_query->fetchAll();
		if ( false === $tests ) {
			return $environment_set;
		}
		foreach ( $tests as $test ) {
			$environment_set->load_completed_test( (int) $test['jetpack_test_item_id'], $this->generate_environment( $test ) );
		}
		return $environment_set;
	}

	/**
	 * {@inheritdoc}
	 */
	public function generate_environment( array $environment ) {
		$env = array();
		$env['jp_version'] = isset( $environment['jp_version'] ) ? $environment['jp_version'] : null;
		$env['jp_major_version_search'] = Semver_Helper::get_major_version( $env['jp_version'] );
		$env['php_version'] = isset( $environment['php_version'] ) ? $environment['php_version'] : null;
		$env['wp_version'] = isset( $environment['wp_version'] ) ? $environment['wp_version'] : null;
		$env['browser'] = isset( $environment['browser'] ) ? $environment['browser'] : null;
		$env['host'] = isset( $environment['host'] ) ? $environment['host'] : null;

		return new Environment( $env );
	}

	/**
	 * {@inheritdoc}
	 */
	public function save_completed_test( $site_id, $test_id, Environment $environment ) {
		$insert_sql = 'INSERT INTO `jetpack_test_items_completed` (`site_id`, `jetpack_test_item_id`, `browser`, `host`, `jp_version`, `wp_version`, `php_version`) VALUES (:site_id, :jetpack_test_item_id, :browser, :host, :jp_version, :wp_version, :php_version)';
		$insert_params = array(
			':site_id' => $site_id,
			':jetpack_test_item_id' => $test_id,
			':browser' => $environment['browser'],
			':host' => $environment['host'],
			':jp_version' => $environment['jp_version'],
			':wp_version' => $environment['wp_version'],
			':php_version' => $environment['php_version'],
		);
		$jtic_insert_query = $this->pdo->prepare( $insert_sql );
		return $jtic_insert_query->execute( $insert_params );
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_test_item_class() {
		return Jetpack_Test_Item::class;
	}
}
