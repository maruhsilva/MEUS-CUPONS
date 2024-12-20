<?php
// Inclua a conexão
include '../conexao.php'; // Ajuste o caminho conforme necessário

try {
    // Obtém o nome da loja da URL (caso exista)
    $loja = isset($_GET['loja']) ? $_GET['loja'] : '';

    // Consulta para buscar cupons, filtrando pela loja se o parâmetro for fornecido
    if ($loja) {
        $query = $pdo->prepare("SELECT * FROM cupons WHERE loja = :loja");
        $query->bindParam(':loja', $loja, PDO::PARAM_STR);
    } else {
        $query = $pdo->query("SELECT * FROM cupons");
    }

    $query->execute();
    $cupons = $query->fetchAll(PDO::FETCH_ASSOC);

    // Retorne os dados em JSON
    header('Content-Type: application/json');
    echo json_encode($cupons);
} catch (Exception $e) {
    // Envie um erro no formato JSON
    http_response_code(500);
    echo json_encode(["error" => "Erro ao executar consulta: " . $e->getMessage()]);
}
?>
