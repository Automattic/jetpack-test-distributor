<?php
namespace Automattic\Human_Testable\Data_Sources;

/**
 * Abstract class for a data source
 */
abstract class Data_Source {
	/**
	 * Returns all available tests
	 *
	 * @return array All tests
	 */
	abstract public function get_tests();

	/**
	 * Returns an array of test IDs
	 *
	 * @param string $site_id ID of the site requesting tests.
	 * @return array Array of test IDs
	 */
	abstract public function get_sent_tests( $site_id );

	/**
	 * Marks tests as being sent to a site ID
	 *
	 * @param string $site_id ID of the site requesting tests.
	 * @param array  $test_ids Array of all test IDs sent to the site.
	 * @return boolean Success result.
	 */
	abstract public function save_sent_tests( $site_id, $test_ids );
}
