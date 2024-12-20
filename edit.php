<?php
session_start();

// Verifica se o usuário está autenticado
if (!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true) {
    header('Location: login.php');
    exit;
}
include 'conexao.php';

// Verifica se foi passado o ID do cupom
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM cupons WHERE id = ?");
    $stmt->execute([$id]);
    $cupom = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Verifica se o cupom foi encontrado
    if (!$cupom) {
        die("Cupom não encontrado.");
    }
} else {
    die("Cupom não encontrado.");
}

// Atualiza os dados do cupom
if (isset($_POST['update'])) {
    $loja = $_POST['loja'];
    $titulo_h1 = $_POST['titulo_h1'];
    $descricao_card = $_POST['descricao_card'];
    $desconto = $_POST['desconto'];
    $codigo = $_POST['codigo'];
    $titulo_modal = $_POST['titulo_modal'];
    $descricao_modal = $_POST['descricao_modal'];
    $como_usar = $_POST['como_usar'];
    $codigo_modal = $_POST['codigo_modal'];
    $data_copy_modal = $_POST['data_copy_modal'];
    $link_loja = $_POST['link_loja'];
    $loja_nome = $_POST['loja_nome'];

    // Atualiza no banco de dados
    $stmt = $pdo->prepare("UPDATE cupons SET loja = ?, titulo_h1 = ?, descricao_card = ?, desconto = ?, codigo = ?, titulo_modal = ?, descricao_modal = ?, como_usar = ?, codigo_modal = ?, data_copy_modal = ?, link_loja = ?, loja_nome = ? WHERE id = ?");
    $stmt->execute([$loja, $titulo_h1, $descricao_card, $desconto, $codigo, $titulo_modal, $descricao_modal, $como_usar, $codigo_modal, $data_copy_modal, $link_loja, $loja_nome, $id]);

    // Exibe a mensagem de sucesso via JavaScript e redireciona após o clique no OK
    echo "<script>
            alert('Cupom atualizado com sucesso!');
            window.location.href = 'admin.php';
          </script>";
    exit();  // Termina a execução após o redirecionamento
}

// Definir valores para o formulário caso o cupom tenha sido encontrado
$loja = isset($cupom['loja']) ? $cupom['loja'] : '';
$titulo_h1 = isset($cupom['titulo_h1']) ? $cupom['titulo_h1'] : '';
$descricao_card = isset($cupom['descricao_card']) ? $cupom['descricao_card'] : '';
$desconto = isset($cupom['desconto']) ? $cupom['desconto'] : '';
$codigo = isset($cupom['codigo']) ? $cupom['codigo'] : '';
$titulo_modal = isset($cupom['titulo_modal']) ? $cupom['titulo_modal'] : '';
$descricao_modal = isset($cupom['descricao_modal']) ? $cupom['descricao_modal'] : '';
$como_usar = isset($cupom['como_usar']) ? $cupom['como_usar'] : '';
$codigo_modal = isset($cupom['codigo_modal']) ? $cupom['codigo_modal'] : '';
$data_copy_modal = isset($cupom['data_copy_modal']) ? $cupom['data_copy_modal'] : '';
$link_loja = isset($cupom['link_loja']) ? $cupom['link_loja'] : '';
$loja_nome = isset($cupom['loja_nome']) ? $cupom['loja_nome'] : '';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Promo Cupom - Cupons Camicado</title>
    <script src="https://kit.fontawesome.com/43b36f20b7.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="CSS/index.css">
    <link rel="stylesheet" href="CSS/admin.css">
    <script src="script.js" defer></script>
</head>
<body>

    <!-- Header com Home e botão hamburguer -->
    <a href="index.php" class="home-icon">
        <span>&#8962;</span>
    </a>
    

    <!-- Menu suspenso -->
    <div class="menu-container">
        <a href="cupons-cea.html?loja=cea">C&A</a>
        <a href="cupons-rchlo.html?loja=rchlo">Riachuelo</a>
        <a href="cupons-camicado.html?loja=camicado">Camicado</a>
        <a href="cupons-zzmall.html?loja=zzmall">ZZ Mall</a>
        <a href="cupons-youcom.html?loja=youcom">Youcom</a>
        <!-- <a href="#link6">Link 6</a> -->
    </div>


    <div class="banner"></div>
    <section class="categories">
        <p><b>Editar Cupom</b></p>
    </section>

    <form method="POST" action="edit.php?id=<?php echo $cupom['id']; ?>">
    <label for="loja">Escolha a Loja:</label>
            <select id="loja" name="loja" onchange="atualizarLojaNome()">
                <option value="cea" <?php echo ($loja == 'cea') ? 'selected' : ''; ?>>C&A</option>
                <option value="rchlo" <?php echo ($loja == 'rchlo') ? 'selected' : ''; ?>>Riachuelo</option>
                <option value="renner" <?php echo ($loja == 'renner') ? 'selected' : ''; ?>>Renner</option>
                <option value="camicado" <?php echo ($loja == 'camicado') ? 'selected' : ''; ?>>Camicado</option>
                <option value="zzmall" <?php echo ($loja == 'zzmall') ? 'selected' : ''; ?>>ZZ Mall</option>
                <option value="youcom" <?php echo ($loja == 'youcom') ? 'selected' : ''; ?>>Youcom</option>
            </select>

        <label for="titulo_h1">Título H1:</label>
        <input type="text" name="titulo_h1" value="<?php echo $cupom['titulo_h1']; ?>" required><br>

        <label for="descricao_card">Descrição do Card:</label>
        <textarea name="descricao_card" required><?php echo $cupom['descricao_card']; ?></textarea><br>

        <label for="desconto">Desconto:</label>
        <input type="text" name="desconto" value="<?php echo $cupom['desconto']; ?>" required><br>

        <label for="codigo">Código:</label>
        <input type="text" name="codigo" value="<?php echo $cupom['codigo']; ?>" required><br>

        <label for="titulo_modal">Título Modal:</label>
        <input type="text" name="titulo_modal" value="<?php echo $cupom['titulo_modal']; ?>" required><br>

        <label for="descricao_modal">Descrição Modal:</label>
        <textarea name="descricao_modal" required><?php echo $cupom['descricao_modal']; ?></textarea><br>

        <label for="como_usar">Como Usar:</label>
        <textarea name="como_usar"><?php echo $cupom['como_usar']; ?></textarea><br>

        <label for="codigo_modal">Código Modal:</label>
        <input type="text" name="codigo_modal" value="<?php echo $cupom['codigo_modal']; ?>" required><br>

        <label for="data_copy_modal">Data Copy Modal:</label>
        <input type="text" name="data_copy_modal" value="<?php echo $cupom['data_copy_modal']; ?>" required><br>

        <label for="link_loja">Link Loja:</label>
        <input type="url" name="link_loja" value="<?php echo $cupom['link_loja']; ?>" required><br>

        <label for="loja_nome">Nome da Loja:</label>
        <input type="text" id="loja_nome" name="loja_nome" value="<?php echo $loja_nome; ?>" readonly>

        <button type="submit" name="update">Atualizar Cupom</button>
    </form>

    <script>
        function atualizarLojaNome() {
            // Obtém o texto da opção selecionada (não o valor)
            const lojaSelecionada = document.getElementById('loja').options[document.getElementById('loja').selectedIndex].text;

            // Define o valor do input loja_nome com o nome da loja selecionada
            document.getElementById('loja_nome').value = lojaSelecionada;
        }

        // Preenche automaticamente o campo loja_nome ao carregar a página
        window.onload = function() {
            atualizarLojaNome();
        };
    </script>
</body>
</html>
