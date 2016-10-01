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
	 * @param  string $version       Version to normalize.
	 * @param  bool   $return_number Returns just the number and not branch/beta tags.
	 * @return string          Normalized version.
	 */
	static public function normalize_version( $version, $return_number = false ) {
		if ( ! isset( $version ) || preg_match( '/^\d+\.\d+/', $version ) !== 1 ) {
			return null;
		}
		$version_parts = explode( '-', $version );
		$version_parts[0] = static::expand_version_number( $version_parts[0] );
		if ( $return_number ) {
			return $version_parts[0];
		}
		return implode( '-', $version_parts );
	}

	/**
	 * Expands version numbers to be [major].[minor].[patch]
	 * For example:
	 *   1.0 -> 1.0.0
	 *   3 -> 3.0.0
	 *
	 * @param  string $version Version number.
	 * @return string
	 */
	static public function expand_version_number( $version ) {
		$version_parts = explode( '.', $version );
		if ( ! isset( $version_parts[1] ) ) {
			$version_parts[1] = 0;
		}
		if ( ! isset( $version_parts[2] ) ) {
			$version_parts[2] = 0;
		}
		return implode( '.', $version_parts );
	}

	/**
	 * Tests is a version is a major version release
	 *
	 * @param  string $version Version to test.
	 * @return boolean         Result of the test.
	 * @todo
	 */
	static public function is_major_release( $version ) {
		$version = static::normalize_version( $version );
		return preg_match( '/^\d+\.0.0$/', $version ) === 1;
	}
}
