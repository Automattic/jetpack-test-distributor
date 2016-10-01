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
	 * Tests one version is between two other versions
	 *
	 * @param  string $client_version Version number to test for.
	 * @param  string $min_version    Minimum version.
	 * @param  string $max_version    Maximum version.
	 * @return bool                   If $client_version hits or is between the min and max version
	 */
	protected function test_version( $client_version, $min_version, $max_version ) {
		$client_version = $this->normalize_version( $client_version );
		$min_version = $this->normalize_version( $min_version );
		$max_version = $this->normalize_version( $max_version );

		if ( ! isset( $client_version ) ) {
			if ( isset( $max_version ) ) {
				return false;
			}
			return true;
		}
		if ( isset( $min_version ) && version_compare( $client_version, $min_version, '<' ) ) {
			return false;
		}
		if ( isset( $max_version ) && version_compare( $client_version, $max_version, '>' ) ) {
			return false;
		}
		return true;
	}

	/**
	 * Normalize a version. Nulls invalid version numbers.
	 *
	 * @param  string $version Version to normalize.
	 * @return string          Normalized version.
	 */
	protected function normalize_version( $version ) {
		if ( isset( $version ) &&  preg_match( '/^\d+\.\d+/', $version ) !== 1 ) {
			return null;
		}
		return $version;
	}

	/**
	 * Tests the environment for a match with the test item
	 *
	 * @param  array $environment Current environment.
	 * @return bool Test result
	 */
	abstract public function test_environment( $environment );

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
}
