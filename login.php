<?php
session_start();

// Usuário e senha definidos
$usuario_valido = 'administrador_roberto';
$senha_valida = 'Promocupom2024@';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    // Verifica as credenciais
    if ($usuario === $usuario_valido && $senha === $senha_valida) {
        $_SESSION['autenticado'] = true;
        header('Location: admin.php');
        exit;
    } else {
        $erro = "Usuário ou senha inválidos!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Promo Cupom - Cupons Camicado</title>
    <script src="https://kit.fontawesome.com/43b36f20b7.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="CSS/index.css">
    <script src="script.js" defer></script>
</head>
<body>

    <!-- Header com Home e botão hamburguer -->
    <a href="index.php" class="home-icon">
        <span>&#8962;</span>
    </a>
    

    <div class="banner"></div>

    <style>
        /* Estilos gerais */
body {
    font-family: Arial, sans-serif;
    background-color: #f5f5f5;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    /* height: 100vh; */
    margin: 0;
}

.login-form {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 300px;
    text-align: center;
}

h2 {
    font-size: 24px;
    margin-bottom: 20px;
    color: #333;
}

/* Estilo dos campos de entrada */
input[type="text"], input[type="password"] {
    width: 100%;
    padding: 12px;
    margin: 8px 0;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
}

input[type="text"]:focus, input[type="password"]:focus {
    border-color: #007BFF;
    outline: none;
}

/* Estilo do botão */
button {
    width: 100%;
    padding: 12px;
    background-color: #007BFF;
    color: white;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    cursor: pointer;
}

button:hover {
    background-color: #0056b3;
}

/* Estilo da mensagem de erro */
.erro {
    color: red;
    font-size: 14px;
    margin-bottom: 10px;
}
    </style>
    <section class="categories">
        <p><b>Login Painel do Administrador</b></p>
        <!-- <p class="descricao">A Camicado é referência em casa e decoração, oferecendo uma ampla seleção de produtos para transformar ambientes com estilo e praticidade. Com mais de 100 lojas em todo o Brasil e uma forte presença online, a Camicado disponibiliza itens como utilidades domésticas, decoração, organização e eletroportáteis. Aproveite as promoções e cupons exclusivos para renovar sua casa com economia e bom gosto.</p> -->
    </section>
    <?php if (isset($erro)) echo "<p style='color: red;'>$erro</p>"; ?>
    <form method="POST" action="login.php">
        <label for="usuario">Usuário:</label>
        <input type="text" id="usuario" name="usuario" required><br>

        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required><br>

        <button type="submit">Entrar</button>
    </form>
</body>
</html>
