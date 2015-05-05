<?php
ini_set('display_errors', 'On');
include 'storedInfo.php';

$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "pake-db", "$myPassword", "pake-db"); //code from cs290 php-demo lecture
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

$name = $_POST["title"];
$category = $_POST["category"];
$length = $_POST["length"];

//var_dump($name);
//var_dump($category);
//var_dump($length);

$stmt = $mysqli->prepare("INSERT INTO movies (name, category, length) VALUES (?, ?, ?)");
$stmt->bind_param("ssi", $name, $category, $length);

$stmt->execute();
$stmt->close();
?>