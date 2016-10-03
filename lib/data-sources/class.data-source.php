<?php
namespace Automattic\Human_Testable\Data_Sources;

/**
 * Abstract class for a data source
 */
abstract class Data_Source {
	/**
	 * Prepares a test item object with an array of attributes from the database
	 *
	 * @param  array $attributes List of attributes to use in new object.
	 * @return Automattic\Human_Testable\Test_Items\Test_Item
	 */
	protected function prepare( $attributes ) {
		$class_name = $this->get_test_item_class();
		return new $class_name( $this, $attributes );
	}

	/**
	 * Returns all available tests
	 *
	 * @return array All tests
	 */
	abstract public function get_tests();


	/**
	 * Returns the environment attribute names that this data source uses.
	 *
	 * @return array Attribute names
	 */
	abstract public function get_environment_attributes();

	/**
	 * Returns an array of test IDs
	 *
	 * @param string $site_id          ID of the site requesting tests.
	 * @param string $environment_hash Environment hash.
	 * @return array Array of test IDs
	 */
	abstract public function get_completed_tests( $site_id, $environment_hash );

	/**
	 * Marks a test as being completed or skipped for a site ID
	 *
	 * @param int    $site_id          ID of the site requesting tests.
	 * @param int    $test_id          ID of the test that was completed or skipped.
	 * @param string $environment_hash Environment hash.
	 * @return boolean Success result.
	 */
	abstract public function save_completed_test( $site_id, $test_id, $environment_hash );

	/**
	 * Returns the test item class to use for this data source
	 *
	 * @return string Class name
	 */
	abstract public function get_test_item_class();
}
