<?php 

//sets my sql
$username = "user";
$password = "password";
$dbServer = "localhost";
$dbName   = "comslib";

//creates a connection with mysql server
$sqlCon = new mysqli($dbServer, $username, $password, $dbName);

// error check for connection
if ($sqlCon->connect_error) {
	die("Connection failed: " . $sqlCon->connect_error);
	//echo "failed";
} else {
	//echo("Connected successfully<br>");
}

$testing = "testing";

$sql = "INSERT INTO users (usrname) VALUES ('$testing')";

if ($sqlCon->query($sql) === TRUE) {
	//echo "New record created successfully<br>";
} else {
	//echo "Error: " . $sql . "<br>" . $sqlCon->error;
}

$sqlCon->close();



?>