<?php
// Configuração do banco de dados
$host = 'localhost';
$dbname = 'promo-cupom';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar: " . $e->getMessage());
}

// Processar submissão do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST['textos'] as $chave => $conteudo) {
        $stmt = $pdo->prepare("UPDATE textos_site SET conteudo = ? WHERE chave = ?");
        $stmt->execute([$conteudo, $chave]);
    }
    echo "<p>Textos atualizados com sucesso!</p>";
}

// Buscar textos do banco de dados
$stmt = $pdo->query("SELECT chave, conteudo FROM textos_site");
$textos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Textos</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        form { max-width: 600px; margin: auto; }
        textarea { width: 100%; height: 80px; margin-bottom: 15px; padding: 10px; font-size: 14px; }
        button { padding: 10px 20px; background: #007BFF; color: white; border: none; cursor: pointer; }
        button:hover { background: #0056b3; }
    </style>
</head>
<body>
    <h1>Editar Textos do Site</h1>
    <form method="POST">
        <?php foreach ($textos as $texto): ?>
            <label for="<?php echo $texto['chave']; ?>"><strong><?php echo $texto['chave']; ?></strong></label>
            <textarea name="textos[<?php echo $texto['chave']; ?>]" id="<?php echo $texto['chave']; ?>">
                <?php echo htmlspecialchars($texto['conteudo']); ?>
            </textarea>
        <?php endforeach; ?>
        <button type="submit">Salvar Alterações</button>
    </form>
</body>
</html>