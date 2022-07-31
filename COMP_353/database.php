
<?php
$server = 'localhost';
$username = 'root';
$password = 'Bhavyaraj10';
$database = 'testdbms';

try {
    $conn = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
} catch (PDOException $e) {
    die('Connection Failed: ' . $e->getMessage());
}
?>