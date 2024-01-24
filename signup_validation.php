<?php

// Replace with your actual database credentials
$servername = "127.0.0.1";
$username = "root";
$password = "JCTWindows2024";
$dbname = "logindb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handling POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the POST request
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $login_email = $_POST['login_email'];
    $login_password = $_POST['login_password'];

    // SQL query to insert data into the database
    $sql = "INSERT INTO login_data (first_name, last_name, login_email, login_password)
            VALUES ('$first_name', '$last_name', '$login_email', '$login_password')";

    if ($conn->query($sql) === TRUE) {
        // Data inserted successfully
        echo "Data inserted successfully";
    } else {
        // Error inserting data
        echo "User already exists";
    }
}

// Close the database connection
$conn->close();

?>
