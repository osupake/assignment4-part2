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

//delete all movies from database
if(isset($_POST['deleteAll']) && ($_POST['deleteAll'] == "Delete All Movies")){
    $mysqli->query("DELETE FROM movies");
    echo "All movies deleted. ";
}

//add movie to database
if(isset($_POST['title']) && isset($_POST['category']) && isset($_POST['length'])) {
	$name = isset($_POST['title']) ? $_POST['title'] : '';
	$category = isset($_POST['category']) ? $_POST['category'] : '';
	$length = isset($_POST['length']) ? $_POST['length'] : '';

	if (!($stmt = $mysqli->prepare("INSERT INTO movies (name, category, length) VALUES (?, ?, ?)"))) {
	     echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}

	$stmt->bind_param("ssi", $name, $category, $length);

	$stmt->execute();
	$stmt->close();
	echo "Movie added. ";
}

echo "<br>Click <a href=\"index.html\">here</a> to go back.<br>Click <a href=\"view.php\">here</a> to go to the inventory."
?>

</body>
</html>