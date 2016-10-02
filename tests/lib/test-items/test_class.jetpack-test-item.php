<?php
namespace Automattic_Unit\Human_Testable\Test_Items;

require_once( dirname( __DIR__ ) . DIRECTORY_SEPARATOR . 'test_class.base_test.php' );
require_once( TESTED_LIBRARY_PATH . DIRECTORY_SEPARATOR . 'test-items' . DIRECTORY_SEPARATOR . 'class.jetpack-test-item.php' );

use Automattic\Human_Testable\Test_Items\Jetpack_Test_Item;
use Automattic_Unit\Human_Testable\Base_Test;

class Test_Jetpack_Test_Item extends Base_Test {
	public function test_get_id() {
		$item = $this->get_jetpack_test_item( array( 'jetpack_test_item_id' => '123' ) );
		$this->assertEquals( $item->get_id(), 123 );
	}

	public function test_get_title() {
		$item = $this->get_jetpack_test_item( array( 'title' => 'Look for Sasquatch' ) );
		$this->assertEquals( $item->get_title(), 'Look for Sasquatch' );
	}

	public function test_get_instructions() {
		$item = $this->get_jetpack_test_item( array( 'instructions' => '1) Check the woods' ) );
		$this->assertEquals( $item->get_instructions(), '1) Check the woods' );
	}

	public function test_get_module() {
		$item = $this->get_jetpack_test_item( array( 'module' => 'woods' ) );
		$this->assertEquals( $item->get_module(), 'woods' );
	}

	public function test_get_importance() {
		$item = $this->get_jetpack_test_item( array( 'importance' => 10 ) );
		$this->assertEquals( $item->get_importance(), 10 );
	}

	public function test_get_host() {
		$item = $this->get_jetpack_test_item( array( 'host' => 'dreamhost' ) );
		$this->assertEquals( $item->get_host(), 'dreamhost' );
	}

	public function test_get_browser() {
		$item = $this->get_jetpack_test_item( array( 'browser' => 'firefox' ) );
		$this->assertEquals( $item->get_browser(), 'firefox' );
	}

	public function test_get_initial_path() {
		$item = $this->get_jetpack_test_item( array( 'initial_path' => '/sasquatch' ) );
		$this->assertEquals( $item->get_initial_path(), '/sasquatch' );
	}

	protected function get_fake_attributes( $attr = array() ) {
		return array_merge( array(
			'jetpack_test_item_id' => '1',
			'active' => '1',
			'date_added' => '2016-07-19 03:33:10',
			'importance' => '10',
			'title' => 'Do an IE Thing',
			'instructions' => '1) Do something cool.\r\n2) High five your friend.',
			'min_jp_ver' => '',
			'max_jp_ver' => '',
			'min_wp_ver' => '',
			'max_wp_ver' => '',
			'min_php_ver' => '',
			'max_php_ver' => '',
			'module' => 'publicize',
			'host' => '',
			'browser' => 'ie',
			'initial_path' => '/wp-admin/options-general.php?page=sharing',
			'added_by' => 'samhotchkiss',
		), $attr );
	}
	protected function get_jetpack_test_item( $attr = null ) {
		$attr = $this->get_fake_attributes( $attr );
		return new Jetpack_Test_Item( $attr );
	}
}
