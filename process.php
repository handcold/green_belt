<?php 
	session_start();
	require('new-connection.php');

	if(isset($_POST['action']) && $_POST['action'] == 'register')
	{
		//call to function
		register_user($_POST);  //use actual _POST
	}

	elseif(isset($_POST['action']) && $_POST['action'] == 'login')
	{
		login_user($_POST);
	}

	elseif(isset($_GET['action']) && $_GET['action'] == 'view')
	{
		header("location:incident.php?id={$_GET['id']}");
	}

	elseif(isset($_GET['action']) && $_GET['action'] == 'report')
	{
		add_witness_to_incident($_GET['id']);
	}

	elseif(isset($_GET['action']) && $_GET['action'] == 'add')
	{
		add_incident($_POST);
	}

	elseif(isset($_GET['action']) && $_GET['action'] == 'delete')
	{
		header("location: delete.php?id={$_GET['id']}");
		die();
	}

	elseif(isset($_GET['action']) && $_GET['action'] == 'confirm_delete')
	{
		delete_incident($_GET['id']);
	}

	else //malicious navigation to process.php or someone is trying to log off!
	{
	session_destroy();
	header('location: index.php');
	die();
	}

function register_user($post)    //just a parameter called post
{
	$esc_first_name = escape_this_string($_POST['first_name']);
	$esc_last_name = escape_this_string($_POST['last_name']);
	$esc_email = escape_this_string($_POST['email']);
	$esc_password = escape_this_string($_POST['password']);
	$esc_confirm_password = escape_this_string($_POST['confirm_password']);
	// ---------- begin validation checks ------------ //
	$_SESSION['errors'] = array();

	if(empty($esc_first_name))   //post info to be validated
	{
		$_SESSION['errors'][] = "First name can't be blank!";
	}
	if(empty($esc_last_name))   //post info to be validated
	{
		$_SESSION['errors'][] = "Last name can't be blank!";
	}
	if(empty($esc_password))   //post info to be validated
	{
		$_SESSION['errors'][] = "Password field is required";
	}
	if($esc_password !== $esc_confirm_password)
	{
		$_SESSION['errors'][] = "Passwords must match!";
	}
	if(!filter_var($esc_email, FILTER_VALIDATE_EMAIL))
	{
		$_SESSION['errors'][] = "Enter a valid email address!";
	}
	// ------------ end of validation checks ------------ //

	if(count($_SESSION['errors']) > 0)   //if there are any errors
	{
		header('location: index.php');
		die();
	}
	else  //now you need to insert the data into hte database
	{
		$query = "INSERT INTO users (first_name, last_name, email, password, created_at, updated_at)
				VALUES ('{$esc_first_name}', '{$esc_last_name}', '{$esc_email}', '{$esc_password}', NOW(), NOW())";
		run_mysql_query($query);
		$_SESSION['success_message'] = 'User successfully created!';
		header('location: index.php');
		die();

	}
}

function login_user($post)    //just a parameter called post
{
	$esc_email = escape_this_string($_POST['email']);
	$esc_password = escape_this_string($_POST['password']);
	$query = "SELECT * FROM users WHERE users.password = '{$esc_password}' AND users.email = '{$esc_email}';";
	$user = fetch_all($query); //go and attempt to grab user with above credentials
	if(count($user) > 0)
	{
		$_SESSION['user_id']= $user[0]['id'];
		$_SESSION['first_name'] = $user[0]['first_name'];
		$_SESSION['logged_in'] = TRUE;
		header('location: main.php');
		die();
	}
	else
	{
		$_SESSION['errors'][] = "Can't find a user with those credentials";
		header('location: index.php');
		die();
	}
}

function add_incident($post)
{
	$query = "SELECT * FROM incidents WHERE name LIKE '{$post['incident_name']}';";
	$same_name = fetch_all($query);
	$query2 = "SELECT * FROM incidents WHERE created_at LIKE '{$post['incident_date']}';";
	$same_date = fetch_all($query2);

	$_SESSION['incident_errors'] = array();
	if(empty($post['incident_name']))
	{
		$_SESSION['incident_errors'][] = "Incident can't be blank";
	}
	if(empty($post['incident_date']))
	{
		$_SESSION['incident_errors'][] = "Please enter a date";
	}
	if(count($_SESSION['incident_errors']) > 0)   //if there are any errors
	{
		header('location: main.php');
		die();
	}
	else
	{
		if(empty($same_name) && empty($same_date))
		{
			$query = "INSERT INTO incidents (name, created_at, updated_at, users_id)
			VALUES ('{$post['incident_name']}', '{$post['incident_date']}', NOW(), '{$_SESSION['user_id']}');";
			run_mysql_query($query);
			$_SESSION['success'] = "New crime reported!";
			header('location: main.php');
			die();
		}
		$_SESSION['incident_errors'][] = "Incident already in db";
		header('location: main.php');
		die();
	}
}

function add_witness_to_incident($id)
{
	$query = "INSERT INTO users_has_incidents (users_id, incidents_id)
	VALUES ({$_SESSION['user_id']}, {$id});";
	run_mysql_query($query);
	$_SESSION['success'] = "You witnessed a crime";
	header('location: main.php');
	die();
}

function delete_incident($id)
{
	$query = "DELETE FROM incidents WHERE id = '{$id}'";
	run_mysql_query($query);
	header('location: main.php');
	die();
}
?>