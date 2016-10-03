<?php
namespace Automattic\Human_Testable;

class Environment implements \ArrayAccess {
	/**
	 * Attributes for the environment
	 *
	 * @var array
	 */
	private $attributes = array();

	/**
	 * Data Source Attribute names
	 *
	 * @var array
	 */
	 private $attribute_names = array();

	/**
	 * Constructor.
	 *
	 * @param array $attribute_names Names of attributes handled by data source.
	 * @param array $attributes      Attributes of the environment.
	 */
	public function __construct( $attribute_names = array(), $attributes = array() ) {
		$this->attribute_names = $attribute_names;
		$this->attributes = $attributes;
	}

	/**
	 * Get hash of an environment.
	 *
	 * @return string Hash of the environment.
	 */
	public function get_hash() {
		$env = array();
		foreach ( $this->attribute_names as $attr ) {
			$env[ $attr ] = $this[ $attr ];
		}
		return sha1( json_encode( $env ) );
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
	public function offsetGet ( $offset ) {
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
}
