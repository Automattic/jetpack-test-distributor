<?php
namespace Automattic_Unit\Human_Testable_Helpers\Fakes;

require_once( TESTED_LIBRARY_PATH . DIRECTORY_SEPARATOR . 'data-sources' . DIRECTORY_SEPARATOR . 'class.data-source.php' );
require_once( TESTED_LIBRARY_PATH . DIRECTORY_SEPARATOR . 'test-items' . DIRECTORY_SEPARATOR . 'class.jetpack-test-item.php' );
require_once( TESTED_LIBRARY_PATH . DIRECTORY_SEPARATOR . 'env' . DIRECTORY_SEPARATOR . 'class.environment.php' );
require_once( TESTED_LIBRARY_PATH . DIRECTORY_SEPARATOR . 'env' . DIRECTORY_SEPARATOR . 'class.environment-set.php' );
require_once( TESTED_LIBRARY_PATH . DIRECTORY_SEPARATOR . 'utils' . DIRECTORY_SEPARATOR . 'class.semver-helper.php' );

use Automattic\Human_Testable\Test_Items\Jetpack_Test_Item;
use Automattic\Human_Testable\Data_Sources\Data_Source;
use Automattic\Human_Testable\Env\Environment;
use Automattic\Human_Testable\Env\Environment_Set;
use Automattic\Human_Testable\Utils\Semver_Helper;

define( 'FAKE_DATA_DIR', __DIR__ . DIRECTORY_SEPARATOR . 'data' );

/**
 * Test data source
 */
class Test_Data_Source extends Data_Source {
	private $memory_tables = array();

	/**
	 * Constructor
	 */
	public function __construct() {
		$tables = array( 'jetpack_test_items_completed', 'jetpack_test_items', 'jetpack_versions' );
		foreach ( $tables as $table ) {
			$this->memory_tables[ $table ] = array();
			$data_path = FAKE_DATA_DIR . DIRECTORY_SEPARATOR . $table . '.json';
			if ( file_exists( $data_path ) ) {
				$this->memory_tables[ $table ] = json_decode( file_get_contents( $data_path ), true );
			}
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_tests() {
		$tests = [];
		foreach ( $this->memory_tables['jetpack_test_items'] as $row ) {
			$test_item = $this->prepare( $row );
			$tests[ $test_item->get_id() ] = $test_item;
		}
		return $tests;
	}

	public function get_version_modules() {
		$versions = array();
		foreach ( $this->memory_tables['jetpack_versions'] as $row ) {
			$versions[ $row['version'] ] = json_decode( $row['touched_modules'], true );
		}
		return $versions;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_environment_set( $site_id, array $environment ) {
		$environment = $this->generate_environment( $environment );
		return $this->load_completed_tests( $site_id, new Environment_Set( $environment ) );
	}

	/**
	 * {@inheritdoc}
	 */
	public function load_completed_tests( $site_id, Environment_Set $environment_set ) {
		foreach ( $this->memory_tables['jetpack_test_items_completed'] as $test ) {
			if ( $test['site_id'] != $site_id ) { continue; }
			$environment_set->load_completed_test( (int) $test['jetpack_test_item_id'], $this->generate_environment( $test ) );
		}
		return $environment_set;
	}

	/**
	 * {@inheritdoc}
	 */
	public function save_completed_test( $site_id, $test_id, Environment $environment ) {
		$this->memory_tables['jetpack_test_items_completed'][] = array(
			'site_id' => (int)$site_id,
			'jetpack_test_item_id' => (int)$test_id,
			'browser' => $environment['browser'],
			'host' => $environment['host'],
			'jp_version' => $environment['jp_version'],
			'php_version' => $environment['php_version'],
			'wp_version' => $environment['wp_version'],

		);
		return true;
	}

	/**
	 * {@inheritdoc}
	 */
	public function generate_environment( array $environment ) {
		$env = array();
		$env['jp_version'] = isset( $environment['jp_version'] ) ? $environment['jp_version'] : null;
		$env['jp_major_version'] = Semver_Helper::get_major_version( $env['jp_version'] );
		$env['php_version'] = isset( $environment['php_version'] ) ? $environment['php_version'] : null;
		$env['wp_version'] = isset( $environment['wp_version'] ) ? $environment['wp_version'] : null;
		$env['browser'] = isset( $environment['browser'] ) ? $environment['browser'] : null;
		$env['host'] = isset( $environment['host'] ) ? $environment['host'] : null;

		return new Environment( $env );
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_test_item_class() {
		return Jetpack_Test_Item::class;
	}
}
