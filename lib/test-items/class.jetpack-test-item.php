<?php
namespace Automattic\Human_Testable\Test_Items;

require_once( __DIR__ . DIRECTORY_SEPARATOR . 'class.test-item.php' );
require_once( dirname( __DIR__ ) . DIRECTORY_SEPARATOR . 'utils' . DIRECTORY_SEPARATOR . 'class.semver-helper.php' );
require_once( dirname( __DIR__ ) . DIRECTORY_SEPARATOR . 'env' . DIRECTORY_SEPARATOR . 'class.environment-set.php' );

use Automattic\Human_Testable\Env\Environment_Set;
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
	public function test_environment( Environment_Set $environment_set ) {
		if ( ! parent::test_environment( $environment_set ) ) {
			return false;
		}
		$environment = $environment_set->get_current_environment();
		if ( isset( $environment['jp_version'] ) && ! $this->test_importance( $environment_set ) ) {
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
	 * Check if a test item should be returned based on its importance
	 *
	 * @param  Environment $environment_set Current loaded environment.
	 * @return bool        Test result.
	 */
	protected function test_importance( Environment_Set $environment_set ) {
		$environment = $environment_set->get_current_environment();
		if ( ! isset( $this->attributes['importance'] ) || 10 === $this->attributes['importance'] ) {
			return true;
		}
		if ( $this->did_module_change( $environment_set ) ) {
			return true;
		}
		if ( 5 === $this->attributes['importance']
				&& Semver_Helper::is_major_release( $environment['jp_version'] ) ) {
			return true;
		}
		return false;
	}

	/**
	 * Check if a module changed in a version release
	 *
	 * @param  Environment_Set $environment_set Current loaded environment set.
	 * @return bool            Test result.
	 * @todo
	 */
	protected function did_module_change( Environment_Set $environment_set ) {
		$environment = $environment_set->get_current_environment();
		$version_modules = $this->data_source->get_version_modules();
		$module = $this->get_module();
		$version = Semver_Helper::normalize_version( $environment['jp_version'], true );
		if ( ! isset( $version )
				|| ! isset( $module )
				|| ! isset( $version_modules[ $version ] )
				|| ! in_array( $module, $version_modules[ $version ] )
		) {
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
