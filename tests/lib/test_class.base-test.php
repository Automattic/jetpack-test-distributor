<?php
namespace Automattic_Unit\Human_Testable;

require_once( dirname( __DIR__ ) . DIRECTORY_SEPARATOR . 'fakes' . DIRECTORY_SEPARATOR . 'class.test-data-source.php' );

use Automattic_Unit\Human_Testable_Helpers\Fakes\Test_Data_Source;

/**
 * This is the base class for all human testable distribution tests.
 */
abstract class Base_Test extends \PHPUnit_Framework_TestCase {
	protected function get_test_data_source() {
		return new Test_Data_Source();
	}
}
