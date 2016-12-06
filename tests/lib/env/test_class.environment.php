<?php
namespace Automattic_Unit\Human_Testable\Env;

require_once( dirname( __DIR__ ) . DIRECTORY_SEPARATOR . 'test_class.base-test.php' );
require_once( TESTED_LIBRARY_PATH . DIRECTORY_SEPARATOR . 'env' . DIRECTORY_SEPARATOR . 'class.environment.php' );

use Automattic\Human_Testable\Env\Environment;
use Automattic_Unit\Human_Testable\Base_Test;

class Test_Environment extends Base_Test {
	public function test_offset_get() {
		$env = new Environment( array( 'fish' => 'salmon', 'pie' => 'apple' ) );
		$this->assertEquals( $env['fish'], 'salmon' );
		$this->assertEquals( $env['pie'], 'apple' );
		$this->assertNull( $env['country'] );
	}

	public function test_offset_exists() {
		$env = new Environment( array( 'fish' => 'salmon', 'pie' => 'apple' ) );
		$this->assertTrue( isset( $env['fish'] ) );
		$this->assertTrue( isset( $env['pie'] ) );
		$this->assertFalse( isset( $env['country'] ) );
	}


	public function test_offset_set() {
		$this->expectException( \Exception::class );
		$env = new Environment( array( 'fish' => 'salmon', 'pie' => 'apple' ) );
		$env['country'] = 'Canada';
	}

	public function test_offset_unset() {
		$this->expectException( \Exception::class );
		$env = new Environment( array( 'fish' => 'salmon', 'pie' => 'apple' ) );
		unset( $env['fish'] );
	}

	public function test_equals() {
		$env_a = new Environment( array( 'fish' => 'salmon', 'pie' => 'apple' ) );
		$env_b = new Environment( array( 'fish' => 'salmon', 'pie' => 'apple', 'moon' => 'base' ) );
		$this->assertTrue( $env_a->equals( $env_a ) );
		$this->assertFalse( $env_b->equals( $env_a ) );
		$this->assertTrue( $env_b->equals( $env_a, array( 'fish', 'pie' ) ) );
		$this->assertFalse( $env_b->equals( $env_a, array( 'moon', 'pie' ) ) );
	}
}
