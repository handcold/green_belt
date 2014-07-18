<?php

session_start();
echo "Welcome to crime watch, {$_SESSION['first_name']}!   ";
echo "<a href='process.php'>Click to log off </a>";
require('new-connection.php');
$query = "SELECT incidents.name, incidents.created_at, users.first_name, incidents.id, users.id as user_id FROM incidents JOIN users WHERE incidents.users_id = users.id;";
$incidents = fetch_all($query);
?>

<html>
<head>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
	<!-- Optional theme -->
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
	<!-- Latest compiled and minified JavaScript -->
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<title>Report Shadyness</title>
</head>
<body>
	<table>
 		<thead>
 			<th>Incident</th>
 			<th>Date</th>
 			<th>Reported By</th>
 			<th>Did you see it?</th>
 			<th>Link</th>
 		</thead>
 		<?php 
 			foreach ($incidents as $incident) 
 			{
 				echo 
 				"<tr>
 					<td>{$incident['name']}</td>
 					<td>{$incident['created_at']}</td>
 					<td>{$incident['first_name']}</td>
 					<td><a href='process.php?action=report&id={$incident['id']}'>I am a witness</a></td>
 					<td><a href='process.php?action=view&id={$incident['id']}'>View incident</a></td>
 				</tr>";
 			}
 		 ?>
 	</table>
 	<?php 
 		if(isset($_SESSION['success']))
 		{
 			echo "<p>{$_SESSION['success']}</p>";
 			unset($_SESSION['success']);
 		}
		if(isset($_SESSION['incident_errors']))
		{
			foreach($_SESSION['incident_errors'] as $i_error)
			{
				echo "<p class='error'>{$i_error} </p>";
			}
			unset($_SESSION['incident_errors']);
		}

 	 ?>
 	<h2>Report a crime</h2>
 	<form action='process.php?action=add' method='post'>
 		Crime witnessed:<input type='text' name='incident_name'>
 		Incident Date:<input type='date' name='incident_date'>
 		<input type='submit' value='Report!'>
 	</form>
</body>
</html>