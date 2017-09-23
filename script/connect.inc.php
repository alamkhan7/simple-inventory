<?php 

require_once "config.php";

function connect (){
  try {
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $conn->setAttribute( PDO::ATTR_PERSISTENT, true );
    $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
  } 
  catch ( PDOException $e ) {
    die( "Connection failed: " . $e->getMessage() );
  }
  return $conn;
}

function disconnect (){
  $conn = "";
}

?>