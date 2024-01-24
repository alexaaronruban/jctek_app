<?php
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Methods: POST, GET, OPTIONS");


	$db= mysqli_connect("127.0.0.1","root","JCTWindows2024","logindb");
	if (!$db){
		echo "Database connection failed";}
	// else{
	// 	echo "Database connection successful";
	// }



	// Get and escape user input
	$username_validation = mysqli_real_escape_string($db, $_POST['username']);

	// $username_validation = 'abc123@gmail.com';

	// Log received data
	// error_log("Username: $username, Password: $password", 0);

	$sql= "SELECT * FROM login_data WHERE login_email='$username_validation'";

	$result= mysqli_query($db, $sql);
	$count=mysqli_num_rows($result);

	if ($count==1){
		echo json_encode("Emailexists");

	}else {
		echo json_encode("Error");
	}
