<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'pdo_practise';

// Set DSN

$dsn = 'mysql:host='. $host . ';dbname=' . $dbname;

// Create PDO instance 
$pdo = PDO($dsn, $user, $password);

// PDO query
$statement = $pdo->query('SELECT * FROM posts');

while


// The PDO_MYSQL Data Source Name (DSN) is composed of the following elements:

// DSN prefix
// The DSN prefix is mysql:.

// host
// The hostname on which the database server resides.

// port
// The port number where the database server is listening.

// dbname
// The name of the database.

// unix_socket
// The MySQL Unix socket (shouldn't be used with host or port).

// charset
// The character set. See the character set concepts documentation for more information.




?>