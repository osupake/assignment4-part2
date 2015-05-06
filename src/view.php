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
			text-align: center;
		}
		button {
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

//change status to available or check out
function changeStatus($id, $mysqli){
	if (!($change = $mysqli->prepare("UPDATE movies SET rented = !rented WHERE id=?"))) {
	     echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}

	$change->bind_param("i", $id);
	$change->execute();
	$change->close();
}

//delete a row in database to remove movie
function deleteEntry($id, $mysqli){
	if (!($delete = $mysqli->prepare("DELETE FROM movies WHERE id=?"))) {
	     echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}

	$delete->bind_param("i", $id);
	$delete->execute();
	$delete->close();
}

$filteredCategory = "viewAll"; //default set to view all movies

//perform changeStatus or deleteEntry or filter if applicable
if ($_POST) {
	if(isset($_POST['changeStatus'])) {
		$id = $_POST['changeStatus'];	
		changeStatus($id, $mysqli);
		//var_dump($id);
	}

	if(isset($_POST['deleteEntry'])) {
		$id = $_POST ['deleteEntry'];
		deleteEntry($id, $mysqli);
	}

	if(isset($_POST['filter'])) {
		$filteredCategory = $_POST['filter'];
	}
}

//query to get distinct categories
$categoryQuery = "SELECT DISTINCT category FROM movies";
$categoryResults = $mysqli->query($categoryQuery);

//create drop down box with options
if ($categoryResults->num_rows > 0) {
	echo "<form action=\"view.php\" method=\"POST\">";
	echo "<select name=\"filter\">";
	echo "<option value=\"viewAll\">View All</option>";
	while ($row = $categoryResults->fetch_assoc()) {
		echo "<option value=\"" . $row['category']  . "\">" . $row['category'] . "</option>";	
	}
	echo "</select>";
	echo "<input type=\"submit\" value=\"Filter Movies\"></form><br>";
}

//determine which query is used to get results to put into HTML table
if($filteredCategory != "viewAll") {
	$viewQuery = "SELECT id, name, category, length, rented FROM movies WHERE category=\"" . $filteredCategory . "\"";
} else if ($filteredCategory == "viewAll") {
	$viewQuery = "SELECT id, name, category, length, rented FROM movies";
}

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
		echo "<td>" . $row['length'] . "</td>"; 
		echo "<td>" . $rentedStatus . "<form action=\"view.php\" method=\"POST\"><button type=\"submit\" name=\"changeStatus\" value=\"" . $row['id'] . "\">Change Status</button></td>"; //pass id to form
		echo "<td>Remove Movie<button type=\"submit\" name=\"deleteEntry\" value=\"" . $row['id'] . "\">Delete</button></td></tr></form>";
	}
	echo "</tbody></table>";
} else {
	echo "No movies in database. ";
}

echo "Click <a href=\"index.html\">here</a> to go back."
?>

</body>
</html>