<?php
namespace Automattic\Human_Testable\Data_Sources;

require_once( __DIR__ . DIRECTORY_SEPARATOR . 'class.data-source.php' );
require_once( dirname( __DIR__ ) . DIRECTORY_SEPARATOR . 'test-items' . DIRECTORY_SEPARATOR . 'class.jetpack-test-item.php' );

use PDO;
use Automattic\Human_Testable\Test_Items\Jetpack_Test_Item;

/**
 * Abstract class for a data source
 */
class PDO_Jetpack_Data_Source extends Data_Source {
	/**
	 * PDO connection
	 *
	 * @var \PDO
	 */
	private $pdo;

	/**
	 * Constructor
	 *
	 * @param string $dsn      DSN string for DBO connection.
	 * @param string $username Username for the connection.
	 * @param string $password Password for the connection.
	 * @param array  $options DBO connection options.
	 */
	public function __construct( $dsn, $username, $password, $options = [] ) {
		$this->pdo = new PDO( $dsn, $username, $password, $options );
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_tests() {
		$jti_query = $this->pdo->prepare( 'SELECT `jti`.* FROM `jetpack_test_items` `jti` WHERE `jti`.`active`=1' );
		$jti_query->execute();
		$tests = array();
		while ( $row = $jti_query->fetch( PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT ) ) {
			$test_item = $this->prepare( $row );
			$tests[ $test_item->get_id() ] = $test_item;
		}
		return $tests;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_completed_tests( $site_id ) {
		$jtic_query = $this->pdo->prepare( 'SELECT `jtic`.`jetpack_test_item_id` FROM `jetpack_test_items_completed` `jtic` WHERE `jtic`.`site_id`=:site_id' );
		$jtic_query->execute( array( ':site_id' => $site_id ) );
		$tests = $jtic_query->fetchColumn();
		if ( false === $tests ) {
			$tests = array();
		}
		return $tests;
	}

	/**
	 * {@inheritdoc}
	 */
	public function save_completed_test( $site_id, $test_id, $skipped = false ) {
		if ( true === $skipped ) {
			$skipped = 1;
		} else {
			$skipped = 0;
		}
		$insert_sql = 'INSERT INTO `jetpack_test_items_completed` SET `site_id`=:site_id, `jetpack_test_item_id`=:jetpack_test_item_id, `skipped`=:skipped';
		$jtic_insert_query = $this->pdo->prepare( $insert_sql );
		return $jtic_insert_query->execute( array( ':site_id' => $site_id, ':jetpack_test_item_id' => $test_id, ':skipped' => $skipped ) );
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_test_item_class() {
		return Jetpack_Test_Item::class;
	}
}
