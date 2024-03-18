<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "opinions";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Delete all tuples in the "opinion" table
$deleteQuery = "DELETE FROM opinion";
$conn->query($deleteQuery);

// Close the database connection
$conn->close();
?>
