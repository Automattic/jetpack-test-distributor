<?php
namespace Automattic\Human_Testable;

require_once( __DIR__ . DIRECTORY_SEPARATOR . 'data-sources' . DIRECTORY_SEPARATOR . 'class.data-source.php' );

use Automattic\Human_Testable\Data_Sources\Data_Source;

class Test_Distributor {
	private $data_source;

	public function __construct( Data_Source $data_source ) {
		$this->data_source = $data_source;
	}

	/**
	 * Returns all the tests for the site and environment
	 *
	 * @param  int   $site_id     Site ID.
	 * @param  array $environment Array of the environment.
	 * @return array	List of tests.
	 */
	public function get_tests( $site_id, $environment = array() ) {
		$tests = array();
		$completed_tests = $this->data_source->get_completed_tests( $site_id );
		foreach ( $this->data_source->get_tests() as $test_id => $test_item ) {
			if ( in_array( $site_id, $completed_tests, true ) ) {
				continue;
			}
			if ( ! $test_item->test_environment( $test_item ) ) {
				continue;
			}
			$tests[ $test_id ] = $test_item->get_package();
		}
		return $tests;
	}
}
