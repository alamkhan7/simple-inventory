<?php 

require_once "connect.inc.php";

$returnLocation = "" ;
$returnMsg = "";

if (isset($_GET['deleteID']) && !empty($_GET['deleteID']))
{
 
  $returnMsg = deleteItem($_GET['deleteID']) ;

  $returnLocation = "../index.php" ;
  header('Location: '.$returnLocation . '?returnMsg='.urlencode($returnMsg) ) ;
  exit();
}

function deleteItem($id){
	$conn = connect();

    $sql = "DELETE FROM " . TBL_ITEM . " WHERE item_id= :id";

    try {
      $st = $conn->prepare( $sql );
      $st->bindValue( ":id", $id, PDO::PARAM_INT );
      $st->execute();
    } catch ( PDOException $e ) {
      disconnect( $conn );
      die( "Query failed: " . $e->getMessage() );
    }
    return "Item remove successfully" ;
}




?>