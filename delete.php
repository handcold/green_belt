<?php 
	require('new-connection.php');
	$query = "SELECT * FROM incidents WHERE id = {$_GET['id']}";
	$incident_to_delete = fetch_record($query);
 ?>
 <html>
 <head>
 	<title></title>
 </head>
 <body>
 	<h1>Are you sure you want to delete this incident?</h1>
 	<?php 
 		echo
 		"
 		<h3>Incident: {$incident_to_delete['name']}</h3>
 		<h3>Incident date: {$incident_to_delete['created_at']}</h3>
 		<a href='process.php?action=confirm_delete&id={$_GET['id']}'><button>YES</button></a>
 	 	<a href='main.php'><button>NO</button></a>
 		";
 	 ?>
 	 
 </body>
 </html>