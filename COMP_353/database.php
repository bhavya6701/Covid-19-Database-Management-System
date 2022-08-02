
<?php
$server = 'evc353.encs.concordia.ca';
$username = 'evc353_1';
$password = 'BR_DV_AG';
$database = 'evc353_1';

try {
    $conn = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
} catch (PDOException $e) {
    die('Connection Failed: ' . $e->getMessage());
}
?>