<?php
namespace Automattic\Human_Testable\Test_Items;

require_once( __DIR__ . DIRECTORY_SEPARATOR . 'class.test-item.php' );

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
	public function get_module() {
		return $this->attributes['module'];
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_min_product_version() {
		return $this->attributes['min_jp_ver'];
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_max_product_version() {
		return $this->attributes['max_jp_ver'];
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_min_wordpress_version() {
		return $this->attributes['min_wp_ver'];
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_max_wordpress_version() {
		return $this->attributes['max_wp_ver'];
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_min_php_version() {
		return $this->attributes['min_php_ver'];
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_max_php_version() {
		return $this->attributes['max_php_ver'];
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
