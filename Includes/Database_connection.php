<?php

// connect database
$servername = 'localhost';
$username = 'root';
$db_password = '';
$databasename = 'uiu_healthcare';

// connection obj
$conn = mysqli_connect($servername, $username, $db_password, $databasename);

// check connection
if (!$conn) {
    die("Sorry failed to connect: " . mysqli_connect_error());
}
