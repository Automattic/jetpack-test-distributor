<?php
namespace Automattic\Human_Testable;

require_once( __DIR__ . DIRECTORY_SEPARATOR . 'data-sources' . DIRECTORY_SEPARATOR . 'class.data-source.php' );

use Automattic\Human_Testable\Data_Sources\Data_Source;

class Test_Distributor {
	private $data_source;

	public function __construct( Data_Source $data_source ) {
		$this->data_source = $data_source;
	}
}
