<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="main.css">
	<title>Eugene Pak | CS290 Assignment 4 Part 2</title>
	<style>
		table {
			border: 1px solid black;
		}
		th, td {
			width: 150px;
		}
		td {
			border: 1px solid black;
		}
		input {
		    width: 100%;
		    clear: both;
		}
	</style>
</head>
<body>

<?php
ini_set('display_errors', 'On');
include 'storedInfo.php';

$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "pake-db", "$myPassword", "pake-db"); //code from cs290 php-demo lecture
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

$viewQuery = "SELECT id, name, category, length, rented FROM movies";
$results = $mysqli->query($viewQuery);

//generate HTML table to display results from movies database
if ($results->num_rows > 0) {
	echo "<table><thead><tr><th>Title</th><th>Category</th><th>Length</th><th>Availability</th><th>Delete</th></tr></thead><tbody>";
	while($row = $results->fetch_assoc()) {
		$rentedStatus = $row["rented"];
		//var_dump($rentedStatus)
		
		if($rentedStatus == 0){
			$rentedStatus = "Available";
		} else if ($rentedStatus == 1) {
			$rentedStatus = "Checked out";
		}
		
		echo "<tr><td>" . $row['name'] . "</td>";
		echo "<td>" . $row['category'] . "</td>";
		echo "<td>" . $row['length'] . "</td>"; //pass id to form
		echo "<td>" . $rentedStatus . "<form action=\"rent.php\" method=\"post\"><input type=\"submit\" value=\"Change Status\"></form></td>";
		echo "<td>Remove Entry<form action=\"deleteRow.php\" method=\"post\"><input type=\"submit\" value=\"Delete\"></form></td></tr>";
	}
	echo "</tbody></table>";
} else {
	echo "No movies in database. ";
}

echo "Click <a href=\"index.html\">here</a> to go back."
?>

</body>
</html>