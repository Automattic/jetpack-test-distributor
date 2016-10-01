<?php
namespace Automattic_Unit\Human_Testable;

require_once( __DIR__ . DIRECTORY_SEPARATOR . 'test_class.base_test.php' );
require_once( TESTED_LIBRARY_PATH . DIRECTORY_SEPARATOR . 'class.test-distributor.php' );

use Automattic\Human_Testable\Test_Distributor;

class Test_Test_Distributor extends Base_Test {
	/**
	 * Just a really bad test to get the ball rolling
	 */
	public function test_simple_get_tests() {
		$test_distributor = $this->get_test_distributor();
		$this->assertLessThan( count( $test_distributor->get_tests( array() ) ), 0 );
	}

	protected function get_test_distributor( $data_source = null ) {
		if ( ! isset( $data_source ) ) {
			$data_source = $this->get_test_data_source();
		}
		return new Test_Distributor( $data_source );
	}
}
