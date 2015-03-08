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
		<title>Listen Up!</title>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">

		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">

		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
		<!-- my stylesheet -->
		<link rel="icon" type="image/ico" href="http://hosting.csumb.edu/keatingkennyl/CST336/img/icon2.png">
		<link rel="stylesheet" href="css/mainStyle.css" />
	</head>
	<body>
	    <div class="row">
	      <div class="col-md-3">
		<div id="login">
			<h3>Admin Login</h3>
			<form method="post">
				Username:
				<input type="text" name="username"/>
				<br/>
				Password:
				<input type="password" name="password"/>
				<span id="validLogin"></span>
				<br/>
				<input type="submit" name="loginForm" id="submit"/>
				<span id="loginResult"></span>
			</form>
		</div>
	       </div>
	     </div>
	     <div class ="row">
	       <div class="col-md-10 col-md-offset-1">	
		<div id="wrapper">
			<h1>Listen Up!</h1>

			<div id="displaySongs">
				<table>
					<tr>
						<th>Title</th>
						<th>Artist</th>
						<th>Album</th>
						<th>Category</th>
					</tr>
	 				<?php
					foreach ($songs as $s) {
						echo "<tr>";
						echo "<td>" . $s['Title'] . "</td>";
						echo "<td>" . $s['Artist'] . "</td>";
						echo "<td>" . $s['Album'] . "</td>";
						echo "<td>" . $s['Category'] . "</td>";
						echo "</tr>";
					}
					?>
				</table>
			</div><br/>
			<!-- Reference for code below: http://www.9lessons.info/2010/09/youtube-instant-search-with-jquery-and.html -->
			<div id="youtube">
				<script type="text/javascript" src="http://ajax.googleapis.com/
						ajax/libs/jquery/1.4.2/jquery.min.js"></script>
				<script type="text/javascript">
					$(document).ready(function()
						{
							$(".search_input").keyup(function(){
								var search_input = $(this).val();
								var keyword= encodeURIComponent(search_input);
									// Youtube API 
								var yt_url='http://gdata.youtube.com/feeds/api/videos?q='+keyword+'&format=5&max-results=1&v=2&alt=jsonc'; 
									$.ajax
									({
										type: "GET",
										url: yt_url,
										dataType:"jsonp",
										success: function(response){
											if(response.data.items)	{
												$.each(response.data.items, function(i,data){
													var video_id=data.id;
													var video_title=data.title;
													// IFRAME Embed for YouTube
													var video_frame="<iframe width='640' height='385' src='http://www.youtube.com/embed/"+video_id+"' frameborder='0' type='text/html'></iframe>";
													var final="<div id='title'>"+video_title+"</div><div>"+video_frame+"</div>";
						
												$("#result").html(final); // Result
					
												});
											}
											else{
												$("#result").html("<div id='no'>No Video</div>");
											}
										}
									});
								});
							});
					</script>
				Youtube Search:
			<input type="text" class='search_input' />
			<div id="result">
			</div>
		</div><!--youtube div-->
		<br>
	</div><!--wrapper div-->
	</div><!-- offset-->
	</div><!--row div -->
	</body>
</html>
