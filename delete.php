<?php
require 'connection.php';

if (isset($_POST['Delete'])) {
    $sql = "DELETE 
            FROM songs 
            WHERE songId = :songId";
    $stmt = $dbConn -> prepare($sql);
    $stmt -> execute( array(":songId" => $_POST['songId']) );	
   }
echo "<h4>Record Deleted</h4>";
include 'admin.php';
?>
