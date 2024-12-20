<?php
include 'conexao.php';

// Consulta para pegar os 5 cupons mais recentes
$stmt = $pdo->query("SELECT * FROM cupons ORDER BY data_adicao DESC LIMIT 5");
$cuponsRecentes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Promo Cupom - Cupons de Desconto</title>
    <script src="https://kit.fontawesome.com/43b36f20b7.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="CSS/index.css">
</head>
<body>
    <style>
        @media screen and (max-width:700px) {
            .container {
        position: relative; /* Garante que os elementos filhos respeitem a posição */
        display: inline-block; /* Ajusta o tamanho ao conteúdo */
        padding: 1rem 0;
        text-align: center;
        border: dashed 1px #ddd;
        border-radius: 30px;
        width: 300px;
        max-height: 80px;
        text-align: end;
        align-items: center;
        justify-content: center;
        margin-left: 2rem;
    }
    
    /* Texto */
    .texto {
        font-size: 18px;
        color: #333;
        margin: 0;
        white-space: nowrap;
    }
    
    .cupom1 {
        padding: 1.5rem;
    }

    /* Botão */
    .botao {
        position: absolute; /* Posiciona o botão sobre o texto */
        bottom: -1px;
        left: 40%; /* Centraliza horizontalmente */
        transform: translateX(-50%); /* Corrige o centro */
        padding: 1.1rem;
        background-color: #ff7e5f;
        color: white;
        border: 1px solid #ff7e5f;
        border-radius: 30px;
        cursor: pointer;
        transition: transform 0.3s ease; /* Suaviza a animação */
        white-space: nowrap;
        font-size: 18px;
        width: 300px;
    }
    
    /* Efeito hover no botão */
    .botao:hover {
        transform: translateX(-50%) translateX(-10px); /* Move apenas o botão para o lado */
        background-color: #feb47b; /* Cor opcional ao passar o mouse */
    }
        }
    </style>
    
    <div class="banner"></div>
    
    
    <section class="categories">
        <p>Economize em suas compras online usandos os melhores <b>CUPONS DE DESCONTO!</b></p>
    </section>
    
    <section class="products">
        <a href="cupons-cea.html?loja=cea">
        <div class="product">
            <img src="IMG/logo-cea.webp" alt="Produto 1" style="object-fit: cover;">
        </div>
        </a>
        <a href="cupons-rchlo.html?loja=rchlo">
        <div class="product">
            <img src="IMG/logo-rchlo.webp" alt="Produto 2" style="object-fit: cover;">    
        </div>
        </a>
        <a href="cupons-renner.html?loja=renner">
        <div class="product">
            <img src="IMG/logo-renner.webp" alt="Produto 3" style="object-fit: cover;">
        </div>
        </a>
        <a href="cupons-camicado.html?loja=camicado">
        <div class="product">
            <img src="IMG/logo-camicado.webp" alt="Produto 4" style="object-fit: cover;">
        </div>
        </a>
        <a href="cupons-zzmall.html?loja=zzmall">
        <div class="product">
            <img src="IMG/logo-zzmall.webp" alt="Produto 5" style="object-fit: cover;">
        </div>
        </a>
        <a href="cupons-youcom.html?loja=youcom">
            <div class="product">
                <img src="IMG/logo-youcom.webp" alt="Produto 6" style="object-fit: cover;">
            </div>
        </a>
    </section>
    <br>
    <a href="">
        <button class="botao-flutuante1">
            <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="Ícone WhatsApp">
            Faça parte do nosso grupo de ofertas
        </button>
    </a>

    <section class="cupons" style="padding-bottom: 5rem;">
        <p class="recentes">Cupons de descontos <b>mais recentes</b></p>

        <br>
        <!-- Seção de Cupons Recentes -->
    <div id="cupons-recentes">
        <div class="cupons" style="max-width: 100%; margin-inline: auto;">
            <?php foreach ($cuponsRecentes as $cupom): ?>
                <div class="cupom1">
                    <div class="logo-desconto">
                        <img src="IMG/logo-<?php echo $cupom['loja']; ?>.webp" alt="logo-<?php echo $cupom['loja']; ?>">
                        <p class="btn-desconto"><?php echo $cupom['desconto']; ?></p>
                    </div>
                    <div class="descricao1">
                        <h1><?php echo $cupom['titulo_h1']; ?></h1>
                        <p class="text-descricao"><?php echo $cupom['descricao_card']; ?></p>
                        <p class="verify"><i class="fa-solid fa-check"></i>Verificado</p>
                    </div>
                    <div class="container">
                        <p class="texto"><?php echo $cupom['codigo']; ?></p>
                        <button class="botao" data-modal="modal<?php echo $cupom['id']; ?>">VER CUPOM</button>
                    </div>
                </div><br>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Modais para os Cupons -->
    <div id="modals">
        <?php foreach ($cuponsRecentes as $cupom): ?>
            <div class="modal-overlay" id="modal<?php echo $cupom['id']; ?>">
                <div class="modal">
                    <h2><?php echo $cupom['titulo_modal']; ?></h2>
                    <p><?php echo $cupom['descricao_modal']; ?></p>
                    <p class="como-usar"><?php echo $cupom['como_usar']; ?></p>
                    <p class="btn-cupom"><?php echo $cupom['codigo_modal']; ?>
                        <button class="copy-btn" data-copy="<?php echo $cupom['data_copy_modal']; ?>">Copiar</button>
                    </p><br>
                    <a href="<?php echo $cupom['link_loja']; ?>" target="_blank">
                        <button class="close-btn">Acessar site da <?php echo $cupom['loja_nome']; ?></button>
                    </a>
                    <button class="close-btn">Fechar</button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Script para Adicionar Funcionalidades de Modais e Copiar -->
    <script>
        // Função para adicionar ouvintes de evento aos botões da modal
        function adicionarEventosModais() {
            // Delegação de evento para os botões de abrir as modais
            document.querySelector('.cupons').addEventListener('click', (event) => {
                if (event.target.classList.contains('botao')) {
                    const modalId = event.target.getAttribute('data-modal');
                    const modal = document.getElementById(modalId);
                    if (modal) {
                        modal.style.display = 'block'; // Exibe a modal
                    }
                }
            });

            // Delegação de evento para os botões de fechar modal
            document.querySelector('.cupons').addEventListener('click', (event) => {
                if (event.target.classList.contains('close-btn')) {
                    const modalOverlay = event.target.closest('.modal-overlay');
                    if (modalOverlay) {
                        modalOverlay.style.display = 'none'; // Fecha a modal
                    }
                }
            });

            // Fecha a modal ao clicar fora do conteúdo
            document.querySelectorAll('.modal-overlay').forEach(overlay => {
                overlay.addEventListener('click', (e) => {
                    if (e.target === overlay) {
                        overlay.style.display = 'none'; // Fecha a modal
                    }
                });
            });

            // Delegação de evento para os botões de copiar texto
            document.querySelector('.cupons').addEventListener('click', (event) => {
                if (event.target.classList.contains('copy-btn')) {
                    const textToCopy = event.target.getAttribute('data-copy');
                    navigator.clipboard.writeText(textToCopy).then(() => {
                        event.target.textContent = 'Copiado'; // Altera o texto do botão
                        event.target.classList.add('copied'); // Adiciona uma classe para mudar o estilo
                        event.target.disabled = true; // Desativa o botão após copiar
                        setTimeout(() => {
                            event.target.textContent = 'Copiar'; // Restaura o texto após 3 segundos
                            event.target.classList.remove('copied');
                            event.target.disabled = false; // Reativa o botão
                        }, 3000);
                    }).catch(err => {
                        console.error('Falha ao copiar o texto: ', err);
                    });
                }
            });
        }

        // Chama a função para adicionar os eventos de modais
        adicionarEventosModais();
    </script>

    <div class="modal-overlay" id="modal20">
        <div class="modal">
            <h2>Política de Privacidade</h2>
            <p style="text-align: justify;">Última atualização: 18/12/2024 <br><br>
                A sua privacidade é muito importante para nós. Esta política de privacidade descreve como coletamos, utilizamos e protegemos suas informações pessoais ao acessar o site Promo Cupom, que disponibiliza cupons de desconto para lojas como C&A, Riachuelo, Renner, Camicado, ZZ Mall e Youcom.
                <br><br>
                <b>1. Coleta de Informações:</b>
                <br>
                Ao acessar o nosso site, podemos coletar automaticamente informações sobre sua navegação, incluindo seu endereço de IP. Essas informações são usadas apenas para fins de segurança, análise de tráfego e melhoria da experiência do usuário.
                <br><br>
                <b>2. Uso das Informações:</b>
                <br>
                O endereço de IP coletado será utilizado para:
                <br><br>
                Analisar a quantidade de acessos ao site e a origem do tráfego. <br>
                Identificar possíveis abusos ou fraudes. <br>
                Melhorar o desempenho e a segurança do site. <br><br>
                <b>3. Cookies e Tecnologias de Rastreamento:</b>
                <br>
                Nosso site utiliza cookies para melhorar a experiência de navegação. Os cookies são arquivos pequenos armazenados no seu dispositivo que ajudam a personalizar sua visita ao site. Você pode desabilitar os cookies nas configurações do seu navegador, mas isso pode afetar a funcionalidade do site.
                <br><br>
                <b>4. Compartilhamento de Informações:</b>
                <br>
                Não compartilhamos ou vendemos suas informações pessoais. O endereço de IP é usado internamente para fins de análise e segurança e não será compartilhado com terceiros, exceto quando exigido por lei ou para proteger os direitos do site.
                <br><br>
                <b>5. Segurança das Informações:</b>
                <br>
                Tomamos medidas de segurança adequadas para proteger as informações coletadas contra acessos não autorizados. No entanto, é importante lembrar que nenhuma transmissão de dados pela internet é completamente segura, e não podemos garantir segurança absoluta.
                <br><br>
                <b>6. Seus Direitos:</b>
                <br>
                Como o único dado pessoal coletado é o endereço de IP, não há necessidade de você fornecer outras informações. Caso deseje, você pode alterar as configurações de seu navegador para bloquear cookies, conforme mencionado acima.
                <br><br>
                <b>7. Alterações na Política de Privacidade:</b>
                <br>
                Podemos atualizar esta Política de Privacidade periodicamente. Caso haja alterações significativas, informaremos você por meio de aviso no nosso site. Recomendamos que revise nossa política de privacidade periodicamente para se manter informado.
                <br><br>
                <b>8. Contato:</b>
                <br>
                Se tiver alguma dúvida ou preocupação sobre esta Política de Privacidade, entre em contato conosco através do e-mail <a href="">contato@promocupom.com.br</a>.</p>
            <button class="close-btn">Fechar</button>
        </div>
    </div>

    

    <footer>
        <p>&copy; 2024 Promo Cupom | Todos os direitos reservados.</p>
        <p>Contato: contato@promocupom.com.br</p>
        <button class="botao1" data-modal="modal20">Política de Privacidade</button>
        <a href="admin.php"><button class="botao1">Painel do Administrador</button></a>
        <a class="logo-desen" href="https://www.mswebwork.com.br" target="_blank" rel="noopener noreferrer"><img src="IMG/Sem título.webp" alt="logo do desenvolvedor"></a>
    </footer>
    
    <script>
        // Seleciona todos os botões e adiciona evento de clique
        document.querySelectorAll('.botao').forEach(button => {
            button.addEventListener('click', () => {
                const modalId = button.getAttribute('data-modal'); // Obtém o ID da modal do atributo data-modal
                const modal = document.getElementById(modalId); // Seleciona a modal correspondente
                if (modal) {
                    modal.style.display = 'block'; // Exibe a modal
                }
            });
        });

        // Seleciona todos os botões e adiciona evento de clique
        document.querySelectorAll('.botao1').forEach(button => {
            button.addEventListener('click', () => {
                const modalId = button.getAttribute('data-modal'); // Obtém o ID da modal do atributo data-modal
                const modal = document.getElementById(modalId); // Seleciona a modal correspondente
                if (modal) {
                    modal.style.display = 'block'; // Exibe a modal
                }
            });
        });

        // Fecha a modal ao clicar no botão de fechar
        document.querySelectorAll('.close-btn').forEach(button => {
            button.addEventListener('click', () => {
                button.closest('.modal-overlay').style.display = 'none'; // Fecha a modal atual
            });
        });

        // Fecha a modal ao clicar fora do conteúdo
        document.querySelectorAll('.modal-overlay').forEach(overlay => {
            overlay.addEventListener('click', (e) => {
                if (e.target === overlay) {
                    overlay.style.display = 'none'; // Fecha a modal
                }
            });
        });

        // Copiar texto ao clicar no botão
        document.querySelectorAll('.copy-btn').forEach(button => {
            button.addEventListener('click', () => {
                const textToCopy = button.getAttribute('data-copy'); // Obtém o texto a ser copiado
                navigator.clipboard.writeText(textToCopy).then(() => {
                    button.textContent = 'Copiado'; // Altera o texto do botão
                    button.classList.add('copied'); // Adiciona uma classe para mudar o estilo
                    button.disabled = true; // Desativa o botão após copiar
                    setTimeout(() => {
                        button.textContent = 'Copiar'; // Restaura o texto após 3 segundos
                        button.classList.remove('copied');
                        button.disabled = false; // Reativa o botão
                    }, 3000);
                }).catch(err => {
                    console.error('Falha ao copiar o texto: ', err);
                });
            });
        });
    </script>

    </body>
    </html>
    