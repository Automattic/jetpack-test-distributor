<?php
namespace Automattic\Human_Testable\Test_Items;

require_once( dirname( __DIR__ ) . DIRECTORY_SEPARATOR . 'utils' . DIRECTORY_SEPARATOR . 'class.semver-helper.php' );
require_once( dirname( __DIR__ ) . DIRECTORY_SEPARATOR . 'data-sources' . DIRECTORY_SEPARATOR . 'class.data-source.php' );

use Automattic\Human_Testable\Data_Sources\Data_Source;
use Automattic\Human_Testable\Utils\Semver_Helper;

/**
 * Abstract class for a test item
 */
abstract class Test_Item {
	/**
	 * Attributes for the test item (loaded from database)
	 *
	 * @var array
	 */
	protected $attributes;

	/**
	 * Data source that this object originated from
	 *
	 * @var Data_Source
	 */
	protected $data_source;

	/**
	 * Constructor
	 *
	 * @param array $attributes List of attributes for item.
	 */
	public function __construct( Data_Source $data_source, $attributes = array() ) {
		$this->data_source = $data_source;
		$this->attributes = $this->clean_attributes( $attributes );
	}

	/**
	 * Cleans the attributes from the database for consistent comparison
	 *
	 * @param  array $attributes Dirty attributes.
	 * @return array Cleaned attributes
	 */
	protected function clean_attributes( $attributes = array() ) {
		foreach ( $attributes as $key => $value ) {
			if ( '' === $value ) {
				$attributes[ $key ] = null;
			}
		}
		return $attributes;
	}

	/**
	 * Gets the package of key test item attributes
	 *
	 * @return array
	 */
	public function get_package() {
		return array(
			'id'           => $this->get_id(),
			'title'        => $this->get_title(),
			'instructions' => $this->get_instructions(),
			'module'       => $this->get_module(),
			'initial_path' => $this->get_initial_path(),
		);
	}

	/**
	 * Tests the environment for a match with the test item
	 *
	 * @param  array $environment Current environment.
	 * @return bool Test result
	 */
	public function test_environment( $environment ) {
		foreach ( $this->get_version_tests() as $test ) {
			if ( ! Semver_Helper::test_version( $environment[ $test['env_attr'] ], $this->attributes[ $test['min_attr'] ], $this->attributes[ $test['max_attr'] ] )
			) {
				return false;
			}
		}
		return true;
	}

	/**
	 * Gets the unique identifier for the test item
	 *
	 * @return int
	 */
	abstract public function get_id();

	/**
	 * Gets the title for the test item
	 *
	 * @return string
	 */
	abstract public function get_title();

	/**
	 * Gets the instructions for testing the item
	 *
	 * @return string
	 */
	abstract public function get_instructions();

	/**
	 * Gets the component that is being tested
	 *
	 * @return string
	 */
	abstract public function get_module();

	/**
	 * Gets the importance for this test item
	 *
	 * @return int
	 */
	abstract public function get_importance();

	/**
	 * Gets the host this test item should be tested against
	 *
	 * @return string
	 */
	abstract public function get_host();

	/**
	 * Gets the browser that this item should be tested with
	 *
	 * @return string
	 */
	abstract public function get_browser();

	/**
	 * Gets the start of the path that tests this item
	 *
	 * @return string
	 */
	abstract public function get_initial_path();


	/**
	 * Gets the version tests
	 * Example:
	 * ```
	 * 	array(
	 * 		array(
	 * 			'env_attr' => 'jp_version',
	 * 			'min_attr' => 'min_jp_ver',
	 * 			'max_attr' => 'max_jp_ver',
	 * 		),
	 * 		array(
	 * 			'env_attr' => 'wp_version',
	 * 			'min_attr' => 'min_wp_ver',
	 * 			'max_attr' => 'max_wp_ver',
	 * 		),
	 * 	)
	 * ```
	 *
	 * @return array
	 */
	abstract public function get_version_tests();
}
