<?php 

require_once "connect.inc.php";
require_once dirname(__FILE__).'/vendor/autoload.php';
date_default_timezone_set('Asia/Karachi');

$returnLocation = "" ;
$returnMsg = "";

if( isset($_GET['id']) && !empty($_GET['id']) ){		
    $conn = connect();
    $item = null;
    $id = $_GET['id'] ;

    $sql = "SELECT * FROM " . TBL_ITEM . " WHERE item_id= :id" ;

    try {
	  $st = $conn->prepare( $sql );
	  $st->bindValue( ":id", $id, PDO::PARAM_INT );
	  $st->execute();      
	  $item =  $st->fetch();
	  disconnect( $conn );
	  
	  $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('template/Item-Print.docx');
	  $templateProcessor->setValue('id', $item['item_id']);
	  $templateProcessor->setValue('title', $item['title']);
	  $templateProcessor->setValue('price', number_format($item['price'],2));

	  header('Content-Type: application/octet-stream');
	  header("Content-Disposition: attachment; filename="."Item-ID {$item['item_id']}".".docx");
	  $templateProcessor->saveAs('php://output');
	  @header('Location: '.$returnLocation . '?returnMsg='.urlencode($returnMsg) ) ;
	  exit();
    } catch ( PDOException $e ) {
      disconnect( $conn );
      die( "Query failed: " . $e->getMessage() );
    }
}



?>