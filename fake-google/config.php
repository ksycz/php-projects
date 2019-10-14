<?php
// turns output buffering on
ob_start();

try {
  // create connection to the database
  $connection = new PDO("mysql:dbname=fake_google;host=localhost", "root", "");
  // if there is any error, show warning
	$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
}
catch(PDOExeption $e) {
  // show the error message
	echo "Connection failed: " . $e->getMessage();
}
?>