<?php
namespace Automattic_Unit\Human_Testable;

require_once( __DIR__ . DIRECTORY_SEPARATOR . 'test_class.base_test.php' );
require_once( TESTED_LIBRARY_PATH . DIRECTORY_SEPARATOR . 'class.test-distributor.php' );
use Automattic\Human_Testable\Test_Distributor;

class Test_Test_Distributor extends Base_Test {
	/**
	 * Just a really bad test to get the ball rolling
	 */
	// public function test_simple_get_tests() {
	// 	$test_distributor = $this->get_test_distributor();
	// 	$this->assertLessThan( count( $test_distributor->get_tests( array() ) ), 0 );
	// }

	public function test_browser_filter() {
		$test_distributor = $this->get_test_distributor();
		$env = array();
		$this->assertArrayNotHasKey( '1', $test_distributor->get_tests( 1, $env ) );
		$env = array( 'browser' => 'firefox' );
		$this->assertArrayNotHasKey( '1', $test_distributor->get_tests( 1, $env ) );
		$env = array( 'browser' => 'ie' );
		$this->assertArrayHasKey( '1', $test_distributor->get_tests( 1, $env ) );
	}

	public function test_host_filter() {
		$test_distributor = $this->get_test_distributor();
		$env = array();
		$this->assertArrayNotHasKey( '2', $test_distributor->get_tests( 1, $env ) );
		$env = array( 'host' => 'dreamhost' );
		$this->assertArrayNotHasKey( '2', $test_distributor->get_tests( 1, $env ) );
		$env = array( 'host' => 'flywheel' );
		$this->assertArrayHasKey( '2', $test_distributor->get_tests( 1, $env ) );
	}

	public function test_wp_version_filter() {
		$test_distributor = $this->get_test_distributor();
		$env = array();
		$this->assertArrayNotHasKey( '3', $test_distributor->get_tests( 1, $env ) );
		$env = array( 'wp_version' => '2.9.9' );
		$this->assertArrayNotHasKey( '3', $test_distributor->get_tests( 1, $env ) );
		$env = array( 'wp_version' => '3.1' );
		$this->assertArrayHasKey( '3', $test_distributor->get_tests( 1, $env ) );
		$env = array( 'wp_version' => '3.1.1' );
		$this->assertArrayHasKey( '3', $test_distributor->get_tests( 1, $env ) );
		$env = array( 'wp_version' => '3.9.0-beta3' );
		$this->assertArrayHasKey( '3', $test_distributor->get_tests( 1, $env ) );
		$env = array( 'wp_version' => '3.9.1-beta3' );
		$this->assertArrayNotHasKey( '3', $test_distributor->get_tests( 1, $env ) );
		$env = array( 'wp_version' => '3.9.1' );
		$this->assertArrayNotHasKey( '3', $test_distributor->get_tests( 1, $env ) );
	}

	protected function get_test_distributor( $data_source = null ) {
		if ( ! isset( $data_source ) ) {
			$data_source = $this->get_test_data_source();
		}
		return new Test_Distributor( $data_source );
	}
}
