<?php
// MySQL database configuration
$servername = "127.0.0.1";
$username = "root";
$password = "JCTWindows2024";
$dbname = "search_db";

// Connect to MySQL
$mysqlConn = new mysqli($servername, $username, $password, $dbname);

if ($mysqlConn->connect_error) {
    die("MySQL Connection failed: " . $mysqlConn->connect_error);
}

// Fetch data from MySQL
$mysqlQuery = "SELECT * FROM `sample_q&a`";
$mysqlResult = $mysqlConn->query($mysqlQuery);

$data = array();

if ($mysqlResult) {
    while ($row = $mysqlResult->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);
} else {
    echo "MySQL query failed: " . $mysqlConn->error;
}

// Close connections
$mysqlConn->close();
?>
