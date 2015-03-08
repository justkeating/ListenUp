<?
require_once 'connection.php';

$sql = "INSERT INTO songs
		(Title, Artist, Album, Category)
		VALUES
		(:Title, :Artist, :Album, :Category)";
$stmt = $dbConn -> prepare($sql);
$stmt -> execute(array(":Title"=>$_POST['Title'],
						":Artist"=>$_POST['Artist'],
						":Album"=>$_POST['Album'],
						":Category"=>$_POST['Category'],
						));
						
$songId = $dbConn->lastInsertId();
 echo "<h4>".$_POST['Title']." Added</h4>";
 include 'admin.php';
?>