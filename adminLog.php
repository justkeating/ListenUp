<?php 
session_start();
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>
			Admin Log
		</title>
		<link rel="icon" type="image/ico" href="http://hosting.csumb.edu/keatingkennyl/CST336/img/icon2.png"/>
		<link rel="stylesheet" type="text/css" href="css/adminStyle.css" />
		<style>
			#logResult{
				 position:fixed;
				 margin-left:-150px; /* half of width */
				 margin-top:-150px;  /* half of height */
				 top:50%;
				 left:30%;
			}
			h1{
				 position:fixed;
				 margin-left:-150px; /* half of width */
				 margin-top:-150px;  /* half of height */
				 top:30%;
				 left:38%;
			}
			td, th{
				font-size:20px;
			}
		</style>
	</head>
	<body>
		<a href="admin.php" id="back">Back</a>
		<h1>Admin Login Times</h1>
		
		<?php
		require_once 'connection.php'; 		
		/*------------------------------------------
		 * Get's last login of the administrator
		 * ----------------------------------------- */
		$sql = "SELECT MIN(loginTimestamp) AS firstLogin, MAX(loginTimestamp) AS lastLogin, adminId FROM songs_admin_log";
		$stmt = $dbConn -> prepare($sql);
		$stmt -> execute();
		$adminInfo = $stmt -> fetchAll();
		echo "<table id='logResult'>";
		echo "<tr>";
		echo "<th>First Login</th>";
		echo "<th>Last Login</th>";
		echo "<th>Admin </th>";
		
		foreach($adminInfo as $a){
			echo "<tr>";
			echo "<td>" . $a['firstLogin'] . "</td>";
			echo "<td>" . $a['lastLogin'] . "</td>";
			echo "<td>" . $_SESSION['adminName'] . "</td>";
			echo "</tr>";
		}
		echo "</table>";
		?>
	</body>
</html>