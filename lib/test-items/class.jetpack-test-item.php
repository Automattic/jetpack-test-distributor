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
	public function get_version_tests() {
		return array(
			array(
				'env_attr' => 'jp_version',
				'min_attr' => 'min_jp_ver',
				'max_attr' => 'max_jp_ver',
			),
			array(
				'env_attr' => 'wp_version',
				'min_attr' => 'min_wp_ver',
				'max_attr' => 'max_wp_ver',
			),
			array(
				'env_attr' => 'php_version',
				'min_attr' => 'min_php_ver',
				'max_attr' => 'max_php_ver',
			),
		);
	}

	/**
	 * {@inheritdoc}
	 */
	public function test_environment( $environment ) {
		if ( ! parent::test_environment( $environment ) ) {
			return false;
		}
		if ( isset( $this->attributes['host'] )
			&& $environment['host'] !== $this->attributes['host'] ) {
			return false;
		}
		if ( isset( $this->attributes['browser'] )
			&& $environment['browser'] !== $this->attributes['browser'] ) {
			return false;
		}
		return true;
	}

	/**
	 * {@inheritdoc}
	 */
	protected function clean_attributes( $attributes = array() ) {
		$attributes = parent::clean_attributes( $attributes );
		$attributes['jetpack_test_item_id'] = (int) $attributes['jetpack_test_item_id'];
		$attributes['active'] = (int) $attributes['active'];
		$attributes['importance'] = (int) $attributes['importance'];
		return $attributes;
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
