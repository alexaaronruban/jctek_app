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
	$username = mysqli_real_escape_string($db, $_POST['username']);
	$password = mysqli_real_escape_string($db, $_POST['password']);
	// $username="abc123@gmail.com";
	// $password="QweRy4326";

	// Log received data
	error_log("Username: $username, Password: $password", 0);


	$sql= "SELECT * FROM login_data WHERE login_email='$username' AND login_password='$password'";

	$result= mysqli_query($db, $sql);
	$count=mysqli_num_rows($result);

	// print($username);
	// print($password);

	// print($count);
	// print($result);

	if ($count==1){
		echo json_encode("Success");

	}else {
		echo json_encode("Error");
	}


?>