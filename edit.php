<?php 
//This grabs the current infomation of the song 
require 'connection.php';
//query that grabs everything
$sql = "SELECT *
        FROM songs
        WHERE songId = :songId";
$stmt = $dbConn -> prepare($sql);
$stmt -> execute(array(":songId" => $_POST['songId']));
$songs = $stmt -> fetch();
?>

<html>
	<head>
		<link rel="icon" type="image/ico" href="http://hosting.csumb.edu/keatingkennyl/CST336/img/icon2.png">
		<style>
		#submit {
			background:white;
			color: #000;
			border: 1px solid white;
			border-radius: 10px;
			font-size:20px;
			cursor: pointer;
		}
		#submit:hover{
			background:#000 ;
			color: white;
			border: 1px solid white;
			border-radius: 10px;
			font-size:20px;
			cursor: pointer;
		}
		#editInfo{
			text-align:center;
		}
		</style>
	</head>
	<style>
		#editInfo{
			
		}
	</style>
	<body>
	<?php
	//This displays the information of the song chosen that can be edited
if (isset($_POST['Edit'])) {
	?>
	<div id="editInfo">
	<h3>Edit <?= $songs['Title'] ?>'s information:</h3>
	<form method="post">
		Title:
		<input type="text" name="Title" value="<?= $songs['Title'] ?>" />
		<br />
		Artist:
		<input type="text" name="Artist" value="<?= $songs['Artist'] ?>" />
		<br />
		Album:
		<input type="text" name="Album" value="<?= $songs['Album'] ?>" />
		<br />
		Category:
		<input type="text" name="Category" value="<?= $songs['Category'] ?>" />
		<br />
		<input type="hidden" name="songId" value="<?= $songs['songId'] ?>" />
		<input type="submit" value="Save" name="Save" id="submit" />
	</form>
	</div>
	<?
	}//endIf
?>
</body>
</html>

<?php
require 'connection.php';
//Query that saves the information edited from the form
if (isset($_POST['Save'])) {
		
	$title = $_POST['Title'];
	$artist = $_POST['Artist'];
	$album = $_POST['Album'];
	$category = $_POST['Category'];
	$songId = $_POST['songId'];
	
	$sql = "UPDATE songs SET Title = :Title, Artist = :Artist, Album = :Album, Category = :Category WHERE songId = ".$songId;
	$stmt = $dbConn -> prepare($sql);
	$stmt -> execute(array(":Title" => $title, ":Artist" => $artist, ":Album" => $album, ":Category" => $category));
	echo "<h4>".$title ." Updated</h4>";

} else {
	$sql = "SELECT *
      	    FROM songs 
            WHERE songId = :songId";
	$stmt = $dbConn -> prepare($sql);
	$stmt -> execute(array(":songId" => $_POST['songId']));
	$songs = $stmt -> fetch();
}
include 'admin.php';
?>