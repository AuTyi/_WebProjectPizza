<?php
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 

// DB server info
$server = 'localhost';
$user = 'root';
$pass = 'root';
$db = 'pizza';

// connect to the database
$conn = new mysqli($server, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error); //conection check
    }
?>