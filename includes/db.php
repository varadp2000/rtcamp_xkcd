<?php


//Declear Environmental Variables in .htaccess file on server
//Syntax: SetEnv HTTP_VARIABLE_NAME "VALUE"
//with quotes
$servername = getenv('HTTP_SETVERNAME');
$username = getenv("HTTP_USERNAME");
$password = getenv("HTTP_PASSWORD");
$dbname = getenv("HTTP_DBNAME");

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}