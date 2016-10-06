<?php
namespace Automattic_Unit\Human_Testable;

require_once( __DIR__ . DIRECTORY_SEPARATOR . 'test_class.base_test.php' );
require_once( TESTED_LIBRARY_PATH . DIRECTORY_SEPARATOR . 'class.environment.php' );
use Automattic\Human_Testable\Environment;

class Test_Environment extends Base_Test {
	public function test_get_hash() {
		$env = new Environment( array( 'fish' ), array( 'fish' => 'salmon', 'pie' => 'apple' ) );
		$this->assertEquals( $env->get_hash(), sha1( json_encode( array( 'fish' => 'salmon' ) ) ) );
	}

	public function test_offset_get() {
		$env = new Environment( array( 'fish' ), array( 'fish' => 'salmon', 'pie' => 'apple' ) );
		$this->assertEquals( $env['fish'], 'salmon' );
		$this->assertEquals( $env['pie'], 'apple' );
		$this->assertNull( $env['country'] );
	}

	public function test_offset_exists() {
		$env = new Environment( array( 'fish' ), array( 'fish' => 'salmon', 'pie' => 'apple' ) );
		$this->assertTrue( isset( $env['fish'] ) );
		$this->assertTrue( isset( $env['pie'] ) );
		$this->assertFalse( isset( $env['country'] ) );
	}


	public function test_offset_set() {
		$this->expectException(\Exception::class);
		$env = new Environment( array( 'fish' ), array( 'fish' => 'salmon', 'pie' => 'apple' ) );
		$env['country'] = 'Canada';
	}

	public function test_offset_unset() {
		$this->expectException(\Exception::class);
		$env = new Environment( array( 'fish' ), array( 'fish' => 'salmon', 'pie' => 'apple' ) );
		unset( $env['fish'] );
	}
}
