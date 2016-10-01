<?php
require_once( dirname( __DIR__ ) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php' );
require_once( dirname( __DIR__ ) . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'class.test-distributor.php' );
require_once( dirname( __DIR__ ) . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'data-sources' . DIRECTORY_SEPARATOR . 'class.pdo-jetpack-data-source.php' );
require_once( __DIR__ . DIRECTORY_SEPARATOR . 'lists' . DIRECTORY_SEPARATOR . 'browsers.php' );
require_once( __DIR__ . DIRECTORY_SEPARATOR . 'lists' . DIRECTORY_SEPARATOR . 'hosts.php' );
require_once( __DIR__ . DIRECTORY_SEPARATOR . 'lists' . DIRECTORY_SEPARATOR . 'importances.php' );
require_once( __DIR__ . DIRECTORY_SEPARATOR . 'lists' . DIRECTORY_SEPARATOR . 'modules.php' );

use Automattic\Human_Testable\Data_Sources\PDO_Jetpack_Data_Source;
use Automattic\Human_Testable\Test_Distributor;

( new josegonzalez\Dotenv\Loader( dirname( __DIR__ ) . DIRECTORY_SEPARATOR . '.env' ) )->parse()->define();

$jetpack_data_source = new PDO_Jetpack_Data_Source( 'mysql:host=' . DB_HOST . ';dbname=' . DB_DATABASE, DB_USERNAME, DB_PASSWORD );
$test_distributor = new Test_Distributor( $jetpack_data_source );

function draw_select_list( $list, $name, $multiple = false ) {
	$value = '';
	$multiple_str = '';
	if ( $multiple ) {
		$multiple_str = ' multiple="multiple"';
	}
	if ( isset( $_POST[ $name ] ) ) {
		$value = $_POST[ $name ];
	}
	echo '<select name="'. $name .'">';
	echo '<option value=""></option>';
	foreach ( $list as $key => $label ) {
		$selected_str = '';
		if ( $value === $key ) {
			$selected_str = ' selected="selected"';
		}
		echo '<option value="' . $key . '"' . $selected_str . '>' . $label . '</option>';
	}
	echo '</select>';
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US">
<head profile="http://gmpg.org/xfn/11">
	<meta charset="utf-8" />
	<title>Test Distributor</title>
</head>
<body>
	<form method="post">
		<div><label>Site ID</label> <input name="site_id" value="<?php echo isset( $_POST['site_id'] ) ? $_POST['site_id'] : '1'; ?>" /></div>
		<div><label>Jetpack Version</label> <input name="jp_version" value="<?php echo isset( $_POST['jp_version'] ) ? $_POST['jp_version'] : '4.1.0-beta1'; ?>" /></div>
		<div><label>WordPress Version</label> <input name="wp_version" value="<?php echo isset( $_POST['wp_version'] ) ? $_POST['wp_version'] : '4.6.0'; ?>" /></div>
		<div><label>PHP Version</label> <input name="php_version" value="<?php echo isset( $_POST['php_version'] ) ? $_POST['php_version'] : '5.6'; ?>" /></div>
		<div><label>Host</label> <?php echo draw_select_list( $hosts, 'host' ); ?></div>
		<div><label>Browser</label> <?php echo draw_select_list( $browsers, 'browser' ); ?></div>
		<!-- <div><label>Module</label> <?php echo draw_select_list( $modules ); ?></div> -->
		<input type="submit" name="submit" value="Submit" />
	</form>
<?php
if ( ! empty( $_POST['site_id'] ) ) {
	$environment = array();
	$environment['jp_version'] = isset( $_POST['jp_version'] ) ? $_POST['jp_version'] : '';
	$environment['php_version'] = isset( $_POST['php_version'] ) ? $_POST['php_version'] : '';
	$environment['wp_version'] = isset( $_POST['wp_version'] ) ? $_POST['wp_version'] : '';
	$environment['browser'] = isset( $_POST['browser'] ) ? $_POST['browser'] : null;
	$environment['host'] = isset( $_POST['host'] ) ? $_POST['host'] : null;
	dump( $test_distributor->get_tests( $_POST['site_id'], $environment ) );
}
?>
</body>
</html>
