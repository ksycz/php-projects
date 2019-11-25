<?php
// Create connection to database, details in config
$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection

if(mysqli_connect_errno()) {
  // Failed to connect
  echo 'Failed to connect to database '.mysqli_connect_errno();
}