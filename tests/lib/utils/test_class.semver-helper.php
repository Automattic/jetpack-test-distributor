<?php
namespace Automattic_Unit\Human_Testable\Test_Items;

require_once( dirname( __DIR__ ) . DIRECTORY_SEPARATOR . 'test_class.base_test.php' );
require_once( TESTED_LIBRARY_PATH . DIRECTORY_SEPARATOR . 'utils' . DIRECTORY_SEPARATOR . 'class.semver-helper.php' );

use Automattic\Human_Testable\Utils\Semver_Helper;
use Automattic_Unit\Human_Testable\Base_Test;

class Test_Semver_Helper extends Base_Test {
	public function data_test_versions() {
		return array(
			array( true, '20.0', '1.0.0', '21.0' ),
			array( true, '2.0', '1.9.9', '2.0' ),
			array( true, '2.0.0', '1.9.9', '2.0' ),
			array( true, '2.0.0', '1.9.9', '2.0.1' ),
			array( true, '2.0.0', '2.0.0', '2.0.0' ),
			array( true, '2.0.0-beta1', '1.9.9', '2.0.0' ),
			array( true, '200.0.0', '1.0.0', '201.0.0' ),
			array( false, '2.1.0-beta1', '1.9.9', '2.0.0' ),
			array( false, '20.0', '1.0.0', '19.0' ),
			array( false, '-20.0', '1.0.0', '20.0.0' ),
			array( false, 'Bad (Build 1234)', '1.0.0', '100.0.0' ),
			array( false, 'This really is not a version number, is it?', '1.0.0', '100.0.0' ),
		);
	}

	/**
	* @dataProvider data_test_versions
	*/
	public function test_test_version( $result, $test_version, $min_version, $max_version ) {
		$this->assertEquals( $result, Semver_Helper::test_version( $test_version, $min_version, $max_version ) );
	}

	public function data_normalize_version() {
		return array(
			array( null, 'bad' ),
			array( '1.0.0', '1.0' ),
			array( '1.0.0-beta1', '1.0-beta1' ),
			array( '1.0.0', '1.0-beta1', true ),
			array( '1.0.1', '1.0.1-beta1', true ),
			array( null, 'Bad (Build 1234)', true ),
		);
	}

	/**
	* @dataProvider data_normalize_version
	*/
	public function test_normalize_version( $result, $version, $return_number = false ) {
		$this->assertEquals( $result, Semver_Helper::normalize_version( $version, $return_number ) );
	}

	public function data_expand_version_number() {
		return array(
			array( '1.0.0', '1.0' ),
			array( '1.0.0', '1.' ),
			array( '1.0.0', '1' ),
			array( '1.1.0', '1.1' ),
			array( '1.1.1', '1.1.1' ),
			array( '1000.1.0', '1000.1' ),
		);
	}

	/**
	* @dataProvider data_expand_version_number
	*/
	public function test_expand_version_number( $result, $version ) {
		$this->assertEquals( $result, Semver_Helper::expand_version_number( $version ) );
	}

	public function data_is_major_release() {
		return array(
			array( true, '1.0.0' ),
			array( true, '100.0' ),
			array( false, '1.0.1' ),
			array( false, '1.1.0' ),
			array( true, '1.0.0-beta1' ),
			array( false, '1.0.1-beta1' ),
		);
	}

	/**
	* @dataProvider data_is_major_release
	*/
	public function test_is_major_release( $result, $version ) {
		$this->assertEquals( $result, Semver_Helper::is_major_release( $version ) );
	}

	public function data_get_major_version() {
		return array(
			array( 1, '1.0.0' ),
			array( 100, '100.0' ),
			array( 1, '1.0.1' ),
			array( 1, '1.1.0' ),
			array( 1, '1.0.0-beta1' ),
			array( null, 'dev-ljlksdjflksdjflkdsjf' ),
		);
	}

	/**
	* @dataProvider data_get_major_version
	*/
	public function test_get_major_version( $result, $version ) {
		$this->assertEquals( $result, Semver_Helper::get_major_version( $version ), true );
	}
}
