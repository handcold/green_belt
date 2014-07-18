<?php 
	session_start();
	require('new-connection.php');
	$query = "SELECT * FROM incidents WHERE id = {$_GET['id']}";
	$incident_record = fetch_record($query);
	$query2 = "SELECT users_has_incidents.users_id, users_has_incidents.incidents_id, users.first_name, users.last_name FROM users_has_incidents JOIN users WHERE users.id = users_has_incidents.users_id AND incidents_id = '{$_GET['id']}';";
	$witnesses_to_incident = fetch_all($query2);


?>

<html>
<head>
	<title>Incident</title>
</head>
<body>
	<h1>Incident Details</h1>
	Incident witnessed: <?= $incident_record['name']; ?> <br>
	Incident date: <?= $incident_record['created_at']; ?> <br>
	Seen by:<br><?php foreach($witnesses_to_incident as $witness_to_incident){
		echo "{$witness_to_incident['first_name']} {$witness_to_incident['last_name']}<br>";
	}
	echo "<a href='process.php?action=delete&id={$_GET['id']}'>DELETE THIS INCIDENT</a>"; ?>
</body>
</html>