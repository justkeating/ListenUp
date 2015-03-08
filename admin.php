<?php
session_start();
require 'connection.php';
$sql = "SELECT * 
		FROM songs AS s";
$stmt = $dbConn -> prepare($sql);
$stmt -> execute();
$songs = $stmt -> fetchAll();
?>
<html>
	<head>
		<title>Keating's Music</title>
		<link rel="icon" type="image/ico" href="http://hosting.csumb.edu/keatingkennyl/CST336/img/icon2.png"/>
		<link rel="stylesheet" type="text/css" href="css/adminStyle.css"/>
	</head>
		<script>
			function confirmDelete(songName) {
				var removeSong = confirm("Press OK to delete: " + songName)
				if (!removeSong) {
					event.preventDefault();
					//prevents form submission
				}
			}
		</script>
	</head>
	<body>
		<div id="logoutDiv">
			<a href="logout.php" id="logout">Logout</a>
		</div>
		
		<?php
			echo "<h1>Admin Page </h1><br>
			<h3>Welcome Administrator: " . $_SESSION['adminName'] . "</h3>";
		 ?>
		<div id="adddiv">
			<a href="adminLog.php" id="reports">Get Login Report</a><br/><br/>
			<a href="add.html" id="add">Add Song</a><br/><br/>
		</div>
		
		<table>
			<tr>
				<th>Title</th>
				<th>Artist</th>
				<th>Album</th>
				<th>Category</th>
				<th colspan="2">Action</th>
			</tr>
				<?php
				foreach ($songs as $s) {
				?>
					<tr>
					<td><?= $s['Title'] ?></td>
					<td><?= $s['Artist'] ?></td>
					<td><?= $s['Album'] ?></td>
					<td><?= $s['Category'] ?></td>				
					<td>
						<form method="post" action="edit.php">
							<input type='hidden' name='songId' value='<?= $s['songId']?>'/>
							<input type='submit' name='Edit' id="Edit" value='Edit'>
						</form>
					</td>
					<td>
						<form method="post"action="delete.php" onsubmit="confirmDelete('<?= $s['Title'] ?>')">
							<input type='hidden' name='songId' value='<?= $s['songId']?>'/>
							<input type='submit' name='Delete' id="Delete" value='Delete'>
						</form>
					</td>
					</tr>
						<?php
					} 				
					?>
		</table>
	</body>
</html>	