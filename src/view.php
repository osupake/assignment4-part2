<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="main.css">
	<title>Eugene Pak | CS290 Assignment 4 Part 2</title>
</head>
<body>
<?php
ini_set('display_errors', 'On');
include 'storedInfo.php';

$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "pake-db", "$myPassword", "pake-db"); //code from cs290 php-demo lecture
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

echo "Click <a href=\"index.html\">here</a> to go back."
?>

</body>
</html>