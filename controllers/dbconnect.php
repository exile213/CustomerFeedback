<?php
$host = 'localhost';
$dbname = 'customer_feedback';
$username = 'root';
$password = 'imperial12';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}