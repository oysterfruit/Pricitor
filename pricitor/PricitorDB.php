<?php
 //connect to the database

$servername = "localhost";
$username = "root";
$password = "";
$dbname="pricetable";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    echo "Oh dear, something seems to have gone wrong.  Please try again later!";
    die("Connection failed: " . $conn->connect_error);
 }
?>
