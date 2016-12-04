<?php
namespace Automattic\Human_Testable\Env;

class Environment implements \ArrayAccess {
	/**
	 * Attributes for the environment
	 *
	 * @var array
	 */
	private $attributes = array();

	/**
	 * Constructor.
	 *
	 * @param array $attribute_names Names of attributes handled by data source.
	 * @param array $attributes      Attributes of the environment.
	 */
	public function __construct( $attributes = array() ) {
		$this->attributes = $attributes;
	}

	/**
	 * Get hash of an environment.
	 *
	 * @return string Hash of the environment.
	 */
	public function get_hash() {
		return sha1( json_encode( $this->attributes ) );
	}

	/**
	 * Set an attribute of the environment (not allowed!)
	 *
	 * @param mixed $offset Array offset.
	 * @param mixed $value	Value of offset.
	 * @throws \Exception All the time.
	 */
	public function offsetSet( $offset, $value ) {
		throw new \Exception( "Trying to set read-only attribute '{$offset}''" );
	}

	/**
	 * Get an environmental attribute
	 *
	 * @param mixed $offset Offset of array.
	 */
	public function offsetGet( $offset ) {
		if ( isset( $this->attributes[ $offset ] ) ) {
			return $this->attributes[ $offset ];
		}
		return null;
	}

	/**
	 * Check if environmental value exists.
	 *
	 * @param mixed $offset Offset of array.
	 */
	public function offsetExists( $offset ) {
		return isset( $this->attributes[ $offset ] );
	}

	/**
	 * Remove an attribute (not allowed!)
	 *
	 * @param mixed $offset Offset of an array.
	 * @throws \Exception All the time.
	 */
	public function offsetUnset( $offset ) {
		throw new \Exception( "Trying to set read-only attribute '{$offset}''" );
	}

	/**
	 * Tests if another environment is equal
	 *
	 * @param  Environment $test_environment Environment to compare this environment with.
	 * @param  array       $attribute_names  Names of attributes to check; Null will check all (Default: null)
	 * @return boolean     Returns true if the environments are equal (based on provided attribute names)
	 */
	public function equals( Environment $test_environment, array $attribute_names = null ) {
		if ( null === $attribute_names ) {
			$attribute_names = array_keys( $this->attributes );
		}
		foreach ( $attribute_names as $attribute ) {
			if ( $test_environment[ $attribute ] !== $this[ $attribute ] ) {
				return false;
			}
		}
		return true;
	}
}
