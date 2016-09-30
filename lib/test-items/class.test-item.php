<?php
namespace Automattic\Human_Testable\Test_Items;

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
	 * Constructor
	 *
	 * @param array $attributes List of attributes for item.
	 */
	public function __construct( $attributes = array() ) {
		$this->attributes = $this->clean_attributes( $attributes );
	}

	protected function clean_attributes( $attributes = array() ) {
		foreach ( $attributes as $key => $value ) {
			if ( $value === '' ) {
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
	 * Gets the minimum product version that should be tested against this item
	 *
	 * @return string
	 */
	abstract public function get_min_product_version();

	/**
	 * Gets the maximum product version that should be tested against this item
	 *
	 * @return string
	 */
	abstract public function get_max_product_version();

	/**
	 * Gets the minimum WordPress version that should be tested with this item
	 *
	 * @return string
	 */
	abstract public function get_min_wordpress_version();

	/**
	 * Gets the maximum WordPress version that should be tested with this item
	 *
	 * @return string
	 */
	abstract public function get_max_wordpress_version();

	/**
	 * Gets the minimum PHP version that should be tested with this item
	 *
	 * @return string
	 */
	abstract public function get_min_php_version();

	/**
	 * Gets the maximum PHP version that should be tested with this item
	 *
	 * @return string
	 */
	abstract public function get_max_php_version();

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
}
