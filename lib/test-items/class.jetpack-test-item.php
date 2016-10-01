<?php
namespace Automattic\Human_Testable\Test_Items;

require_once( __DIR__ . DIRECTORY_SEPARATOR . 'class.test-item.php' );
require_once( dirname( __DIR__ ) . DIRECTORY_SEPARATOR . 'utils' . DIRECTORY_SEPARATOR . 'class.semver-helper.php' );

use Automattic\Human_Testable\Utils\Semver_Helper;

/**
 * Class for a Jetpack test item
 */
class Jetpack_Test_Item extends Test_Item {
	/**
	 * {@inheritdoc}
	 */
	public function get_id() {
		return $this->attributes['jetpack_test_item_id'];
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_title() {
		return $this->attributes['title'];
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_instructions() {
		return $this->attributes['instructions'];
	}

	/**
	 * {@inheritdoc}
	 */
	public function test_environment( $environment ) {
		if ( isset( $this->attributes['host'] )
			&& $environment['host'] !== $this->attributes['host'] ) {
			return false;
		}
		if ( isset( $this->attributes['browser'] )
			&& $environment['browser'] !== $this->attributes['browser'] ) {
			return false;
		}
		if ( isset( $environment['jp_version'] )
			&& ! Semver_Helper::test_version( $environment['jp_version'], $this->attributes['min_jp_ver'], $this->attributes['max_jp_ver'] ) ) {
			return false;
		}
		if ( isset( $environment['wp_version'] )
			&& ! Semver_Helper::test_version( $environment['wp_version'], $this->attributes['min_wp_ver'], $this->attributes['max_wp_ver'] ) ) {
			return false;
		}
		if ( isset( $environment['php_version'] )
			&& ! Semver_Helper::test_version( $environment['php_version'], $this->attributes['min_php_ver'], $this->attributes['max_php_ver'] ) ) {
			return false;
		}
		return true;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_module() {
		return $this->attributes['module'];
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_importance() {
		return $this->attributes['importance'];
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_host() {
		return $this->attributes['host'];
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_browser() {
		return $this->attributes['browser'];
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_initial_path() {
		return $this->attributes['initial_path'];
	}
}
