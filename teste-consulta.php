<?php
include 'conexao.php';

try {
    $query = $pdo->query("SELECT * FROM cupons");
    $cupons = $query->fetchAll(PDO::FETCH_ASSOC);

    echo "<pre>";
    print_r($cupons);
    echo "</pre>";
} catch (Exception $e) {
    echo "Erro ao executar consulta: " . $e->getMessage();
}
?>