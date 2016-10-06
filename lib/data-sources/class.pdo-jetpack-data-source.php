<?php
namespace Automattic\Human_Testable\Data_Sources;

require_once( __DIR__ . DIRECTORY_SEPARATOR . 'class.data-source.php' );
require_once( dirname( __DIR__ ) . DIRECTORY_SEPARATOR . 'test-items' . DIRECTORY_SEPARATOR . 'class.jetpack-test-item.php' );

use PDO;
use Automattic\Human_Testable\Test_Items\Jetpack_Test_Item;

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
	public function __construct( $dsn, $username, $password, $options = [] ) {
		$this->pdo = new PDO( $dsn, $username, $password, $options );
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_environment_attributes() {
		return array(
			'browser',
			'host',
			'jp_version',
			'wp_version',
			'php_version',
		);
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
	 * {@inheritdoc}
	 */
	public function get_completed_tests( $site_id, $environment_hash ) {
		$jtic_query = $this->pdo->prepare( 'SELECT `jtic`.`jetpack_test_item_id` FROM `jetpack_test_items_completed` `jtic` WHERE `jtic`.`site_id`=:site_id AND `jtic`.`environment`=:environment' );
		$jtic_query->execute( array( ':site_id' => $site_id, ':environment' => $environment_hash ) );
		$tests = $jtic_query->fetchAll( PDO::FETCH_COLUMN );
		if ( false === $tests ) {
			return array();
		}
		foreach ( $tests as $index => $test_id ) {
			$tests[ $index ] = (int) $test_id;
		}
		return $tests;
	}

	/**
	 * {@inheritdoc}
	 */
	public function save_completed_test( $site_id, $test_id, $environment_hash ) {
		$insert_sql = 'INSERT INTO `jetpack_test_items_completed` (`site_id`, `jetpack_test_item_id`, `environment`) VALUES (:site_id, :jetpack_test_item_id, :environment)';
		$jtic_insert_query = $this->pdo->prepare( $insert_sql );
		return $jtic_insert_query->execute( array( ':site_id' => $site_id, ':jetpack_test_item_id' => $test_id, ':environment' => $environment_hash ) );
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_test_item_class() {
		return Jetpack_Test_Item::class;
	}
}
