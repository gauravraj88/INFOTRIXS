<?php

$host = "localhost";
$username = "root";
$password = "";
$dbname = "test";

try {
    $dsn = "mysql:host=$host;dbname=$dbname";

    $pdo = new PDO($dsn, $username, $password);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}