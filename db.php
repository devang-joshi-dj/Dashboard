<?php
// database connectivity establishment
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dashboard";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
	$connection = false;
}

// creating database
$dbSql = "CREATE DATABASE IF NOT EXISTS dashboard";

$dbExists = false;
if ($conn->query($dbSql) === TRUE) {
	$dbExists = true;
}

// connecting to database
mysqli_select_db($conn, $dbname);

// checking if table exists
$tableExists = $conn->query("select 1 from userinfo LIMIT 1");

// creating table if doesn't exists
if ($tableExists == false && $dbExists == true) {
	$tableSql = "CREATE TABLE userinfo (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(100) NOT NULL,
email VARCHAR(100) NOT NULL UNIQUE,
password VARCHAR(100) NOT NULL,
gender VARCHAR(100) NOT NULL,
marital_status VARCHAR(100) NOT NULL,
reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

	if ($conn->query($tableSql) === TRUE) {
		$tableExists = true;
	} else {
		$tableExists = false;
	}
}
