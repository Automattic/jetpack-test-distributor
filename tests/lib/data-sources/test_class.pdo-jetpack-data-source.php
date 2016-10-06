<?php
namespace Automattic_Unit\Human_Testable\Data_Sources;

require_once( dirname( __DIR__ ) . DIRECTORY_SEPARATOR . 'test_class.base_test.php' );
require_once( TESTED_LIBRARY_PATH . DIRECTORY_SEPARATOR . 'data-sources' . DIRECTORY_SEPARATOR . 'class.pdo-jetpack-data-source.php' );
require_once( TESTED_LIBRARY_PATH . DIRECTORY_SEPARATOR . 'class.environment.php' );

use Automattic\Human_Testable\Environment;
use Automattic\Human_Testable\Data_Sources\PDO_Jetpack_Data_Source;
use Automattic_Unit\Human_Testable\Base_Test;

class Test_PDO_Jetpack_Data_Source extends Base_Test {
	public function test_get_tests() {
		$data_source = $this->get_pdo_jetpack_data_source();
		$this->assertArrayHasKey( '1', $data_source->get_tests() );
		$this->assertArrayNotHasKey( '2', $data_source->get_tests() );
	}

	public function test_get_completed_tests() {
			$data_source = $this->get_pdo_jetpack_data_source();
			$env = new Environment( $data_source->get_environment_attributes(), array() );
			$this->assertContains( '1', $data_source->get_completed_tests( 100, $env->get_hash() ) );
			$this->assertNotContains( '2', $data_source->get_completed_tests( 100, $env->get_hash() ) );
			$this->assertNotContains( '1', $data_source->get_completed_tests( 101, $env->get_hash() ) );
	}

	public function test_save_completed_test() {
			$data_source = $this->get_pdo_jetpack_data_source();
			$env = new Environment( $data_source->get_environment_attributes(), array() );
			$this->assertNotContains( '1', $data_source->get_completed_tests( 101, $env->get_hash() ) );
			$data_source->save_completed_test( '101', '1', $env->get_hash() );
			$data_source->save_completed_test( '101', '2', $env->get_hash() );
			$this->assertContains( '1', $data_source->get_completed_tests( 101, $env->get_hash() ) );
			$this->assertContains( '2', $data_source->get_completed_tests( 101, $env->get_hash() ) );
			$this->assertNotContains( '3', $data_source->get_completed_tests( 101, $env->get_hash() ) );
	}

	protected function get_pdo_jetpack_data_source() {
		$data_source = new PDO_Jetpack_Data_Source('sqlite::memory:', null, null);
		$reflection = new \ReflectionProperty(PDO_Jetpack_Data_Source::class, 'pdo');
		$reflection->setAccessible(true);
		$pdo = $reflection->getValue($data_source);
		$pdo->exec( "CREATE TABLE `jetpack_test_items` (
		  `jetpack_test_item_id` int(11) NOT NULL,
		  `active` tinyint(2) DEFAULT '0',
		  `date_added` timestamp DEFAULT NULL,
		  `importance` tinyint(3) DEFAULT '0',
		  `title` varchar(255) DEFAULT NULL,
		  `instructions` text,
		  `min_jp_ver` varchar(15) DEFAULT NULL,
		  `max_jp_ver` varchar(15) DEFAULT NULL,
		  `min_wp_ver` varchar(15) DEFAULT NULL,
		  `max_wp_ver` varchar(15) DEFAULT NULL,
		  `min_php_ver` varchar(15) DEFAULT NULL,
		  `max_php_ver` varchar(128) DEFAULT NULL,
		  `module` varchar(128) DEFAULT NULL,
		  `host` varchar(128) DEFAULT NULL,
		  `browser` varchar(128) DEFAULT NULL,
		  `initial_path` varchar(128) DEFAULT NULL,
		  `added_by` varchar(128) DEFAULT NULL
		);" );
		$pdo->exec( "CREATE TABLE `jetpack_test_items_completed` (
					  `jetpack_test_item_id` int(11) NOT NULL,
					  `site_id` int(11) NOT NULL,
					  `environment` varchar(40) NOT NULL,
					  `date_added` datetime DEFAULT NULL
					);"
		);
		$pdo->exec( "CREATE TABLE `jetpack_versions` (
			  `jetpack_version_id` int(11) NOT NULL,
			  `version` varchar(15) NOT NULL,
			  `touched_modules` text NOT NULL
			);"
		);
		$pdo->exec( "INSERT INTO `jetpack_versions` (`jetpack_version_id`, `version`, `touched_modules`) VALUES
		(1, '4.6.0', '[\"carousel\", \"comments\", \"publicize\"]'),
		(2, '4.5.9', '[\"shortcodes\", \"sso\"]');" );
		$pdo->exec( 'INSERT INTO `jetpack_test_items` (`jetpack_test_item_id`, `title`, `active`) VALUES (1, "Dogs are the best", 1)' );
		$pdo->exec( 'INSERT INTO `jetpack_test_items` (`jetpack_test_item_id`, `title`, `active`) VALUES (2, "Woops", 0)' );
		$pdo->exec( 'INSERT INTO `jetpack_test_items_completed` (`jetpack_test_item_id`, `site_id`, `environment`) VALUES (1, 100, "c8b1bd12db09dc829c0bae371ca20aed791fd86e")' );
		return $data_source;
	}
}
