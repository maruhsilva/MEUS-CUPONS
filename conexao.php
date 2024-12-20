<?php
// Configuração do banco de dados
$host = 'promo_cupom.mysql.dbaas.com.br';
$dbname = 'promo_cupom';
$username = 'promo_cupom'; // Usuário do banco de dados
$password = 'Marua3902@';     // Senha do banco de dados (geralmente vazio no XAMPP)

// Criar conexão PDO
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}
?>
