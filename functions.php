<?php
session_start();

require_once('connect.php');

// call the login() function if register_btn is clicked
if (isset($_POST['login_btn'])) {
	login();
}

if (isset($_GET['logout'])) {
	session_destroy();
	unset($_SESSION['user']);
	header("index.php");
}

function login()
{
	//  require_once ('connect.php');
	global $con, $username;
	// grap form valuese($_POST['username']);
	$username = e($_POST['Username']);
	$password = e($_POST['password']);

	// attempt login if no errors on form

	$password = md5($password);

	//$query = "SELECT * FROM users WHERE username='$username' AND password='$password' LIMIT 1";
	$query = "SELECT * FROM `user_account` WHERE `user_name`='$username' AND `password`='$password' AND `activated`='1' LIMIT 1";
	$results = mysqli_query($con, $query);


	if (mysqli_num_rows($results) == 1) { // user found
		// check if user is admin or user
		$logged_in_user = mysqli_fetch_assoc($results);

		if ($logged_in_user['user_type'] == '1') {
			//$_SESSION['user'] = $logged_in_userid['user_id'];
			$_SESSION['user_name'] = $logged_in_user['user_name'];
			$_SESSION['user'] = $logged_in_user;
			$_SESSION['user_type'] = "Admin";
			$_SESSION['success']  = "You are now logged in";
			header('location: dashboard.php');
		} else if ($logged_in_user['user_type'] == '2') {
			$_SESSION['user_name'] = $logged_in_user['user_name'];
			$_SESSION['user'] = $logged_in_user;
			$_SESSION['user_type'] = "Customer";
			$_SESSION['success']  = "You are now logged in";
			header('location: dashboard_Customer.php');
		} else if ($logged_in_user['user_type'] == '3') {
			$_SESSION['user_name'] = $logged_in_user['user_name'];
			$_SESSION['user'] = $logged_in_user;
			$_SESSION['user_type'] = "Executive Officer";
			$_SESSION['success']  = "You are now logged in";
			header('location: dashboard.php');
		} else {
			echo "Undefined User";
		}
	} else {

		echo "Wrong username/password combination";
	}
}

function getUserById($id)
{
	global $con;
	//$query = "SELECT * FROM users WHERE id=" . $id;
	$query = "SELECT * FROM `user_account` WHERE `user_id`" . $id;
	//SELECT * FROM `cbm_user_account` WHERE `user_id`
	$result = mysqli_query($con, $query);

	$user = mysqli_fetch_assoc($result);
	return $user;
}

function isLoggedIn()
{
	if (isset($_SESSION['user'])) {
		return true;
	} else {
		return false;
	}
}

// function isAdmin()
// {
//     if (isset($_SESSION['user']) && $_SESSION['user']['user_type'] == '1') {
//         return true;
//     } else {
//         return false;
//     }
// }

// escape string
function e($val)
{
	global $con;
	return mysqli_real_escape_string($con, trim($val));
}

function display_error()
{
	global $errors;

	if (count($errors) > 0) {
		echo '<div class="error">';
		foreach ($errors as $error) {
			echo $error . '<br>';
		}
		echo '</div>';
	}
}
