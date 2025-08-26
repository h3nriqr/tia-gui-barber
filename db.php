<?php
date_default_timezone_set('America/Sao_Paulo');

$host = 'localhost';
$dbname = 'barbeiros';
$username = 'root';
$password = ''; // Ajuste conforme necessário

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}
?>
