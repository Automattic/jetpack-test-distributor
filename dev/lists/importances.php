<?php
$importances = array(
	'5' => 'Regular (tested every major release and when the module is changed)',
	'1' => 'Low (only tested when the module is changed)',
	'10' => 'High (tested for every release)'
);

$importances_short = array();

foreach( $importances as $key => $imp ) :
	$parts = explode(' (', $imp );
	$importances_short[$key] = $parts[0];
endforeach;