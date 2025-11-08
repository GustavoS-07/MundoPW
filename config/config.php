<?php
$DB_HOST = '127.0.0.1';
$DB_NAME = 'bd_mundo';
$DB_USER = 'root';
$DB_PASS = '';

define('OPENWEATHER_API_KEY','a2ba51c18d4f79d8d6b8fb248cad4843');
try {
    $pdo = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4", $DB_USER, $DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die("Erro conexão BD: " . $e->getMessage());
}
?>