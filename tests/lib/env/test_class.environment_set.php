<?php
namespace Automattic_Unit\Human_Testable\Env;

require_once( dirname( __DIR__ ) . DIRECTORY_SEPARATOR . 'test_class.base-test.php' );
require_once( TESTED_LIBRARY_PATH . DIRECTORY_SEPARATOR . 'env' . DIRECTORY_SEPARATOR . 'class.environment.php' );
require_once( TESTED_LIBRARY_PATH . DIRECTORY_SEPARATOR . 'env' . DIRECTORY_SEPARATOR . 'class.environment-set.php' );

use Automattic\Human_Testable\Env\Environment;
use Automattic\Human_Testable\Env\Environment_Set;
use Automattic_Unit\Human_Testable\Base_Test;

class Test_Environment_Set extends Base_Test {
	public function test_get_current_environment() {
		$env = new Environment( array( 'fish' => 'salmon', 'pie' => 'apple' ) );
		$env_set = new Environment_Set( $env );
		$this->assertEquals( $env, $env_set->get_current_environment() );
	}

	public function test_load_get_completed_tests() {
		$env = new Environment( array( 'fish' => 'salmon', 'pie' => 'apple' ) );
		$env_b = new Environment( array( 'fish' => 'trout', 'pie' => 'walnut' ) );
		$env_set = new Environment_Set( $env );

		$this->assertEmpty( $env_set->get_completed_tests( 1 ) );
		$env_set->load_completed_test( 1, $env_b );
		$tests = $env_set->get_completed_tests( 1 );

		$this->assertArrayHasKey( $env_b->get_hash(), $tests );
		$this->assertEmpty( $env_set->get_completed_tests( 2 ) );

	}
}
