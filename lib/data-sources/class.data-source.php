<?php
namespace Automattic\Human_Testable\Data_Sources;

require_once( dirname( __DIR__ ) . DIRECTORY_SEPARATOR . 'env' . DIRECTORY_SEPARATOR . 'class.environment.php' );
require_once( dirname( __DIR__ ) . DIRECTORY_SEPARATOR . 'env' . DIRECTORY_SEPARATOR . 'class.environment-set.php' );

use Automattic\Human_Testable\Env\Environment;
use Automattic\Human_Testable\Env\Environment_Set;

/**
 * Abstract class for a data source
 */
abstract class Data_Source {
	/**
	 * Hydrates a new test item object with an array of attributes from the database
	 *
	 * @param  array $attributes List of attributes to use in new object.
	 * @return Automattic\Human_Testable\Test_Items\Test_Item
	 */
	protected function generate_test_item( $attributes ) {
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
	 * Hydrates a new Environment object from an array of environment attributes
	 *
	 * @param  array $environment Array of the environnent
	 * @return Environment
	 */
	abstract public function generate_environment( array $environment );

	/**
	 * Returns loaded environment set
	 *
	 * @param  int   $site_id     Site ID for the current site.
	 * @param  array $environment Array containing current environment's attributes
	 * @return Environment_Set
	 */
	abstract public function get_environment_set( $site_id, array $environment );

	/**
	 * Marks a test as being completed or skipped for a site ID
	 *
	 * @param int         $site_id     ID of the site requesting tests.
	 * @param int         $test_id     ID of the test that was completed or skipped.
	 * @param Environment $environment Current environment
	 * @return boolean Success result.
	 */
	abstract public function save_completed_test( $site_id, $test_id, Environment $environment );


	/**
	 * Returns the test item class to use for this data source
	 *
	 * @return string Class name
	 */
	abstract public function get_test_item_class();
}
