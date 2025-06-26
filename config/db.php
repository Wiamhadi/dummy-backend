<?php
// config/db.php

$host = 'localhost';
$port = '5433';
$dbname = 'wiam';
$user = 'postgres';
$password = '0000';

$dsn = "pgsql:host=$host;port=$port;dbname=$dbname;sslmode=disable";

try {
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}
?>
