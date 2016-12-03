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
	 * @param  in
	 * @return [type]
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
