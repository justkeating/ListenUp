<?php
session_start();
if (isset($_POST['loginForm'])) {//login form has been submitted
	include 'connection.php';
	$sql = "SELECT * FROM songs_admin " . " WHERE username = :username " . " AND password = :password";

	$stmt = $dbConn -> prepare($sql);
	$stmt -> execute(array(":username" => $_POST['username'], ":password" => hash("sha1", $_POST['password'])));
	$record = $stmt -> fetch();

}
if (!empty($record)) {
	$_SESSION['username'] = $record['username'];
	$_SESSION['adminName'] = $record['firstName'] . " " . $record['lastName'];

	$sql = "INSERT INTO songs_admin_log 
 			(adminId, loginTimestamp) 
			 VALUES (:adminId, now() )"; 
			 $stmt = $dbConn->prepare($sql); 
			 $stmt->execute(array(":adminId"=>$record['adminId']));
			 
	header("Location: admin.php");
}

require 'connection.php';
$sql = "SELECT * 
		FROM songs AS s";
$stmt = $dbConn -> prepare($sql);
$stmt -> execute();
$songs = $stmt -> fetchAll();
?>
<html>
<head>
     <!--Import materialize.css-->
      <link type="text/css" rel="stylesheet" href="materialize/css/materialize.min.css"  media="screen,projection"/>

      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <!-- my stylesheet -->
		<link rel="icon" type="image/ico" href="http://hosting.csumb.edu/keatingkennyl/CST336/img/icon2.png">
		<!--<link rel="stylesheet" href="css/mainStyle.css" />-->
        <link rel="stylesheet" href="css/indexStyle.css"/>
    </head>
</head>
<body>
    <div class="container">
         <div class="divider"></div>
        <div class="row">
          <div class="col s6 offset-s2 grid-example" id="title"><h1>Listen Up!</h1></div>
          <div class="col s8 offset-s2 grid-example"><span class="flow-text"> Database spout/ Youtube</span></div>
        </div>
    </div>
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="js/materialize.min.js"></script>
</body>
</html>