<?php
ini_set('display_errors', 'On');
include 'storedInfo.php';

$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "pake-db", "$myPassword", "pake-db"); //code from cs290 php-demo lecture
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

$name = isset($_POST['title']) ? $_POST['title'] : '';
$category = isset($_POST['category']) ? $_POST['category'] : '';
$length = isset($_POST['length']) ? $_POST['length'] : '';

if (!($stmt = $mysqli->prepare("INSERT INTO movies (name, category, length) VALUES (?, ?, ?)"))) {
     echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
}

$stmt->bind_param("ssi", $name, $category, $length);

$stmt->execute();
$stmt->close();
?>

<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="main.css">
	<title>Eugene Pak | CS290 Assignment 4 Part 2</title>
</head>
<body>
	<header>
	</header>
	<div id="wrapper">
		<div class="formContainer">
			<form action="movies.php" method="post">
				<fieldset>
					<p>Add Movie</p>
					<ul>
						<li><label for="title">Title:</label><input type="text" name="title" id="title" required></li>
						<li><label for="category">Category: </label><input type="text" name="category" id="category" required></li>
						<li><label for="length">Length:</label><input type="number" name="length" id="length" min="0" required></li>
					</ul>
					<input type="submit" value="Add">
				</fieldset>
			</form>
		</div>
	</div>

	<footer>
	</footer>
</body>
</html>