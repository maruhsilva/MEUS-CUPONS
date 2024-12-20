<?php
session_start();

// Verifica se o usuário está autenticado
if (!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true) {
    header('Location: login.php');
    exit;
}
include 'conexao.php';

// Carregar cupons para exibição e edição
$stmt = $pdo->query("SELECT * FROM cupons");
$cupons = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Função para adicionar um novo cupom
if (isset($_POST['add'])) {
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

    $stmt = $pdo->prepare("INSERT INTO cupons (loja, titulo_h1, descricao_card, desconto, codigo, titulo_modal, descricao_modal, como_usar, codigo_modal, data_copy_modal, link_loja, loja_nome) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$loja, $titulo_h1, $descricao_card, $desconto, $codigo, $titulo_modal, $descricao_modal, $como_usar, $codigo_modal, $data_copy_modal, $link_loja, $loja_nome]);

    echo "<script>
            alert('Cupom adicionado com sucesso!');
            window.location.href = 'admin.php';
          </script>";
}


// Função para excluir um cupom
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM cupons WHERE id = ?");
    $stmt->execute([$id]);

    echo "<script>
            alert('Cupom excluído com sucesso!');
            window.location.href = 'admin.php';
          </script>";
}

// Carregar cupons para exibição e edição
$stmt = $pdo->query("SELECT * FROM cupons");
$cupons = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <a href="logout.php"><button class="botao1">SAIR</button></a>
    <section class="categories">
        <p><b>Adicionar Novo Cupom</b></p>
    </section>

    <form method="POST" action="admin.php" id="form-cupom">
  
    <!-- Campos do formulário -->
    <label for="loja">Escolha a Loja:</label>
    <select id="loja" name="loja" onchange="atualizarLojaNome()">
        <option value="cea">C&A</option>
        <option value="rchlo">Riachuelo</option>
        <option value="renner">Renner</option>
        <option value="camicado">Camicado</option>
        <option value="zzmall">ZZ Mall</option>
        <option value="youcom">Youcom</option>
    </select>

    <label for="titulo_h1">Título Card:</label>
    <input type="text" id="titulo_h1" name="titulo_h1" required><br>

    <label for="descricao_card">Descrição do Card:</label>
    <textarea id="descricao_card" name="descricao_card" required></textarea><br>

    <label for="desconto">Desconto:</label>
    <input type="text" id="desconto" name="desconto" placeholder="25% OFF" required><br>

    <label for="codigo">Código:</label>
    <input type="text" id="codigo" name="codigo" required><br>

    <label for="titulo_modal">Título Modal:</label>
    <input type="text" id="titulo_modal" name="titulo_modal" required><br>

    <label for="descricao_modal">Descrição Modal:</label>
    <textarea id="descricao_modal" name="descricao_modal" required></textarea><br>

    <label for="como_usar">Como Usar:</label>
    <textarea id="como_usar" name="como_usar">Copie e cole o código antes de finalizar a sua compra na loja</textarea><br>

    <label for="codigo_modal">Código Modal:</label>
    <input type="text" id="codigo_modal" name="codigo_modal" required><br>

    <label for="data_copy_modal">Data Copy Modal:</label>
    <input type="text" id="data_copy_modal" name="data_copy_modal" readonly required><br>

    <label for="link_loja">Link Loja:</label>
    <input type="url" id="link_loja" name="link_loja" value="https://www." required><br>

    <label for="loja_nome">Nome da Loja:</label>
    <input type="text" id="loja_nome" name="loja_nome" readonly><br>

    <button type="submit" name="add">Adicionar Cupom</button>
</form>

    <script>
        // Atualizar data_copy_modal com o valor de codigo_modal automaticamente
document.getElementById('codigo').addEventListener('input', function () {
    const codigoModal = this.value;
    document.getElementById('codigo_modal').value = codigoModal;
    document.getElementById('data_copy_modal').value = codigoModal;
});
    </script>

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

<div id="cupom-preview">
    <div class="cupom1" style="max-width: 70%; margin-inline: auto; background-color: #fff;">
        <div class="logo-desconto">
            <img id="cupom-logo" src="IMG/default-logo.webp" alt="LOGO DA LOJA">
            <p class="btn-desconto" id="cupom-desconto">Desconto aqui</p>
        </div>
        <div class="descricao1">
            <h1 id="cupom-titulo">Título do cupom</h1>
            <p class="text-descricao" id="cupom-descricao">Descrição do card</p>
            <p class="verify"><i class="fa-solid fa-check"></i>Verificado</p>
        </div>
        <div class="container">
            <p class="texto" id="cupom-codigo">Código aqui</p>
            <button class="botao" data-modal="modal-id">VER CUPOM</button>
        </div>
    </div>
</div>

<!-- "Modal" transformada em contêiner fixo -->
<div id="cupom-detalhes">
    <h2 id="detalhes-titulo">Título do modal</h2>
    <p id="detalhes-descricao">Descrição do modal</p>
    <p class="como-usar" id="detalhes-como-usar">Como usar aqui</p>
    <p class="btn-cupom">
        <span id="detalhes-codigo">Código do modal</span>
        <button class="copy-btn" id="detalhes-copy-btn">Copiar</button>
    </p><br>
    <!-- <a id="detalhes-link" href="#" target="_blank"> -->
        <button class="close-btn">Acessar site</button>
        <button class="close-btn">Fechar</button>
    </a>
</div>

<style>
    #cupom-preview {
    margin-bottom: 20px;
}

#cupom-detalhes {
    border: 1px solid #ddd;
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 8px;
    width: 50%;
    margin-inline: auto;
    text-align: center;
}

#cupom-detalhes h2 {
    font-size: 20px;
    color: #333;
    margin-bottom: 10px;
    font-family: Arial, Helvetica, sans-serif;
    padding-bottom: 1rem;
    padding-top: 1rem;
}

#cupom-detalhes p {
    font-size: 15px;
    color: #555;
    margin-bottom: 20px;
    font-family: Arial, Helvetica, sans-serif;
}

#cupom-detalhes .btn-cupom {
    display: flex;
    align-items: center;
    gap: 10px;
    max-width: 50%;
}

#cupom-detalhes .close-btn {
    padding: 10px 20px;
    font-size: 14px;
    background-color: #ff4d4d;
    color: white;
    border: none;
    border-radius: 30px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

#cupom-detalhes .close-btn:hover {
    background-color: #cc0000;
}

#cupom-detalhes .copy-btn {
    padding: 12px 25px;
    font-size: 16px;
    background-color: #28a745;
    color: white;
    border: none;
    border-radius: 30px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

#cupom-detalhes .copy-btn:hover {
    background-color: #218838;
    transform: scale(1.05);
}

@media screen and (max-width: 1300px) {

    #cupom-detalhes {
    border: 1px solid #ddd;
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 8px;
    min-width: 90% !important;
    /* margin-inline: auto; */
    text-align: center;
    }

    #cupom-detalhes .btn-cupom {
        border: dashed 1px black;
        min-width: 350px;
        margin-inline: auto;
        display: inline-flex;
        align-items: center;
        justify-content: space-between;
        gap: .5rem;
        padding: 1rem;
        border-radius: 30px;
        font-size: .8rem !important;
    }

    .cupom1 {
        min-width: 90%;
    }

}


</style>

<script>
    // Atualizar o preview do cupom e os detalhes em tempo real
document.querySelectorAll('#form-cupom input, #form-cupom textarea').forEach(field => {
    field.addEventListener('input', function () {
        const fieldId = this.id;
        const fieldValue = this.value;

        // Atualiza dinamicamente o cupom e os detalhes
        switch (fieldId) {
            case 'titulo_h1':
                document.getElementById('cupom-titulo').textContent = fieldValue || 'Título do cupom';
                document.getElementById('detalhes-titulo').textContent = fieldValue || 'Título do modal';
                break;
            case 'descricao_card':
                document.getElementById('cupom-descricao').textContent = fieldValue || 'Descrição do card';
                break;
            case 'desconto':
                document.getElementById('cupom-desconto').textContent = fieldValue || 'Desconto aqui';
                break;
            case 'codigo':
                document.getElementById('cupom-codigo').textContent = fieldValue || 'Código aqui';
                break;
            case 'titulo_modal':
                document.getElementById('detalhes-titulo').textContent = fieldValue || 'Título do modal';
                break;
            case 'descricao_modal':
                document.getElementById('detalhes-descricao').textContent = fieldValue || 'Descrição do modal';
                break;
            case 'como_usar':
                document.getElementById('detalhes-como-usar').textContent = fieldValue || 'Como usar aqui';
                break;
            case 'codigo_modal':
                document.getElementById('detalhes-codigo').textContent = fieldValue || 'Código do modal';
                break;
            case 'data_copy_modal':
                document.getElementById('detalhes-copy-btn').setAttribute('data-copy', fieldValue);
                break;
            case 'link_loja':
                const link = document.getElementById('detalhes-link');
                link.href = fieldValue || '#';
                link.textContent = `Acessar site da ${document.getElementById('loja_nome').value}`;
                break;
        }
    });
});

// Preenche automaticamente o campo loja_nome ao carregar a página
window.onload = function () {
    atualizarLojaNome();
};

</script>
    <!-- Exibição dos cupons -->
    <h2 style="text-align: center; padding-top: 2rem;">Cupons Existentes</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Loja</th>
                <th>Título</th>
                <th>Desconto</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cupons as $cupom): ?>
                <tr>
                    <td><?php echo $cupom['id']; ?></td>
                    <td><?php echo $cupom['loja_nome']; ?></td>
                    <td><?php echo $cupom['titulo_h1']; ?></td>
                    <td><?php echo $cupom['desconto']; ?></td>
                    <td>
                        <!-- Link para excluir -->
                        <a href="admin.php?delete=<?php echo $cupom['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                        <!-- Link para editar, pode ser implementado futuramente -->
                        <a href="edit.php?id=<?php echo $cupom['id']; ?>">Editar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
