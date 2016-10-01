<?php
namespace Automattic\Human_Testable\Utils;

/**
 * Helper class for semantic versions
 */
class Semver_Helper {
	/**
	 * Tests one version is between two other versions
	 *
	 * @param  string $test_version Version number to test for.
	 * @param  string $min_version    Minimum version.
	 * @param  string $max_version    Maximum version.
	 * @return bool                   If $client_version hits or is between the min and max version
	 */
	static public function test_version( $test_version, $min_version, $max_version ) {
		$test_version = static::normalize_version( $test_version );
		$min_version = static::normalize_version( $min_version );
		$max_version = static::normalize_version( $max_version );

		if ( ! isset( $test_version ) ) {
			if ( isset( $max_version ) ) {
				return false;
			}
			return true;
		}
		if ( isset( $min_version ) && version_compare( $test_version, $min_version, '<' ) ) {
			return false;
		}
		if ( isset( $max_version ) && version_compare( $test_version, $max_version, '>' ) ) {
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
	static public function normalize_version( $version ) {
		if ( isset( $version ) &&  preg_match( '/^\d+\.\d+/', $version ) !== 1 ) {
			return null;
		}
		return $version;
	}

	/**
	 * Tests is a version is a major version release
	 *
	 * @param  string  $version Version to test.
	 * @return boolean          Result of the test.
	 * @todo
	 */
	static public function is_major_release( $version ) {
		return true;
	}
}
