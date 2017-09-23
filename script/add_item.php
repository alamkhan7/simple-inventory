<?php 

require_once "connect.inc.php";

$returnLocation = "" ;
$returnMsg = "";

if (isset($_POST['title']) && !empty($_POST['title']))
{
  if (itemTitleExist($_POST['title'])){
    $returnMsg = "{$_POST['title']} title already exist choose another" ;
  }else{
    $returnMsg = addItem($_POST['title'], $_POST['price']) ;
  }

  $returnLocation = "../index.php" ;
  header('Location: '.$returnLocation . '?returnMsg='.urlencode($returnMsg) ) ;
  exit();
}


function addItem($title,$price)
{		
    $conn = connect();

    $sql = "INSERT INTO " . TBL_ITEM . " (`title`, `price`) VALUES (:title, :price)";

    try {
      $st = $conn->prepare( $sql );
      $st->bindValue( ":title", $title, PDO::PARAM_STR );
      $st->bindValue( ":price", $price, PDO::PARAM_INT );
      $st->execute();
    } catch ( PDOException $e ) {
      disconnect( $conn );
      die( "Query failed: " . $e->getMessage() );
    }
    return "Item added successfully" ;
}

function itemTitleExist($title)
{ 
    $conn = connect();

    $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM " . TBL_ITEM . " WHERE title = :title ";

    try {
      $st = $conn->prepare( $sql );
      $st->bindValue( ":title", $title, PDO::PARAM_STR );
      $st->execute();
      $st = $conn->query( "SELECT found_rows() AS totalRows" );
      $row = $st->fetch();
      disconnect( $conn );
      return $row["totalRows"];
    } catch ( PDOException $e ) {
      disconnect( $conn );
      die( "Query failed: " . $e->getMessage() );
    }
}


?>