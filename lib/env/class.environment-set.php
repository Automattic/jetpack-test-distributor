<?php
namespace Automattic\Human_Testable\Env;

require_once( __DIR__ . DIRECTORY_SEPARATOR . 'class.environment.php' );

class Environment_Set {
	/**
	 * Completed environments grouped by test ID
	 *
	 * @var array
	 */
	private $completed_test_environments = array();

	/**
	 * Current environment
	 *
	 * @var Environment
	 */
	private $current_environment;

	/**
	 * Constructor
	 *
	 * @param Environment $current_environment
	 */
	public function __construct( Environment $current_environment ) {
		$this->current_environment = $current_environment;
	}

	/**
	 * Check if the current environment has been tested based on a full
	 * set ($attributes = null) or subset of attributes.
	 *
	 * @param  int        $test_id
	 * @param  array|null $attribute_names  Name of attributes to test from the current environment
	 * @return boolean    Returns true if there is a match in the set of tested environments for the current environment
	 */
	public function match( $test_id, $attribute_names = null ) {
		if ( ! isset( $this->completed_test_environments[ $test_id ] ) ) {
			return false;
		}
		if ( null === $attribute_names ) {
			if ( isset( $this->completed_test_environments[ $test_id ][ $this->current_environment->get_hash() ] ) ) {
				return true;
			}
			return false;
		}
		foreach ( $this->completed_test_environments[ $test_id ] as $test ) {
			if ( $test->equals( $this->current_environment, $attribute_names ) ) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Loads an environment into the set
	 *
	 * @param  int         $test_id      ID of the test that we're loading
	 * @param  Environment $environment  Environment to load
	 */
	public function load_completed_test( $test_id, Environment $environment ) {
		if ( ! isset( $this->completed_test_environments[ $test_id ] ) ) {
			$this->completed_test_environments[ $test_id ] = array();
		}
		$this->completed_test_environments[ $test_id ][ $environment->get_hash() ] = $environment;
	}

	/**
	 * Gets all completed tests for a particular test ID
	 *
	 * @param int $test_id
	 * @return array Completed environments for a test
	 */
	public function get_completed_tests( $test_id ) {
		if ( ! isset( $this->completed_test_environments[ $test_id ] ) ) {
			return array();
		}
		return $this->completed_test_environments[ $test_id ];
	}

	/**
	 * Returns the current environment
	 *
	 * @return Environment
	 */
	public function get_current_environment() {
		return $this->current_environment;
	}
}
