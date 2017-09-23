<?php 

require_once "connect.inc.php";

function getItems(){		
    $conn = connect();
    $items = array();
    $totalRows = 0;

    $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM " . TBL_ITEM ;

    try {
      $st = $conn->prepare( $sql );
      $st->execute();      
      foreach ( $st->fetchAll() as $row ) {
        $items[] = $row ;
      }

      $st = $conn->query( "SELECT found_rows() AS totalRows" );
      $row = $st->fetch();
      disconnect( $conn );
      $totalRows = $row["totalRows"];
      return  array($items, $totalRows);
    } catch ( PDOException $e ) {
      disconnect( $conn );
      die( "Query failed: " . $e->getMessage() );
    }
}

function searchItem($search){    
    $conn = connect();
    $items = array();
    $totalRows = 0;

    $sql = "SELECT  * FROM " . TBL_ITEM . " WHERE title LIKE '%". $search ."%'" ;

    try {
      $st = $conn->prepare( $sql );
      $st->execute();      
      foreach ( $st->fetchAll() as $row ) {
        $items[] = $row ;
      }

      $st = $conn->query( "SELECT found_rows() AS totalRows" );
      $row = $st->fetch();
      disconnect( $conn );
      $totalRows = $row["totalRows"];
      return  array($items, $totalRows);
    } catch ( PDOException $e ) {
      disconnect( $conn );
      die( "Query failed: " . $e->getMessage() );
    }
}

?>