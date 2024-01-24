<?php
$servername = "localhost";
$usernamedb = "root";
$passworddb = "JCTWindows2024";
$dbname = "logindb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}else{
    echo "Connection succesful";
}


$username=$_POST['username'];
$password=$_POST['password'];

// Assuming $username and $password are provided from your application
$username = mysqli_real_escape_string($conn, $username);
$password = mysqli_real_escape_string($conn, $password);

$sql = "SELECT * FROM login_info WHERE login_email = '$username' AND login_password = '$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Login successful
    echo json_encode("Success");
} else {
    // Username or password incorrect
    echo json_encode("Failure");
}

// Close the connection
$conn->close();
?>
