<?php
require_once( dirname( __DIR__ ) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php' );
require_once( __DIR__ . DIRECTORY_SEPARATOR . 'lists' . DIRECTORY_SEPARATOR . 'browsers.php' );
require_once( __DIR__ . DIRECTORY_SEPARATOR . 'lists' . DIRECTORY_SEPARATOR . 'hosts.php' );
require_once( __DIR__ . DIRECTORY_SEPARATOR . 'lists' . DIRECTORY_SEPARATOR . 'importances.php' );
require_once( __DIR__ . DIRECTORY_SEPARATOR . 'lists' . DIRECTORY_SEPARATOR . 'modules.php' );
( new josegonzalez\Dotenv\Loader( dirname( __DIR__ ) . DIRECTORY_SEPARATOR . '.env' ) )->parse()->toEnv();

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
    echo '<option value="'. $key .'"'. $selected_str .'>'. $label .'</option>';
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
    <div><label>Version</label> <input name="version" value="<?php echo isset( $_POST['version'] ) ? $_POST['version'] : ''; ?>" /></div>
    <div><label>Host</label> <?php echo draw_select_list( $hosts, 'host' ); ?></div>
    <div><label>Browser</label> <?php echo draw_select_list( $browsers, 'browser' ); ?></div>
    <!-- <div><label>Module</label> <?php echo draw_select_list( $hosts ); ?></div> -->
    <input type="submit" name="submit" value="Submit" />
  </form>
<?php

?>
</body>
</html>
