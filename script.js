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

// Obtém o nome da loja a partir do nome do arquivo na URL
const lojaNome = window.location.pathname.split('/').pop().split('.')[0].replace('cupons-', '');

// Verifica qual loja está sendo carregada
console.log('Loja carregada:', lojaNome);

// A partir daqui, você pode usar a variável lojaNome na sua requisição fetch
fetch(`api/cupons.php?loja=${lojaNome}`)
    .then(response => {
        if (!response.ok) {
            throw new Error('Erro ao buscar cupons: ' + response.statusText);
        }
        return response.json();
    })
    .then(cupons => {
        console.log(cupons); // Verifica os cupons recebidos
        const cupomContainer = document.getElementById('cupons');
        const modalContainer = document.getElementById('modals');

        cupons.forEach(cupom => {
            // Exibe os cupons na página
            cupomContainer.innerHTML += `
                <div class="cupom1">
                    <div class="logo-desconto">
                        <img src="IMG/logo-${cupom.loja}.webp" alt="logo-${cupom.loja}">
                        <p class="btn-desconto">${cupom.desconto}</p>
                    </div>
                    <div class="descricao1">
                        <h1>${cupom.titulo_h1}</h1>
                        <p class="text-descricao">${cupom.descricao_card}</p>
                        <p class="verify"><i class="fa-solid fa-check"></i>Verificado</p>
                    </div>
                    <div class="container">
                        <p class="texto">${cupom.codigo}</p>
                        <button class="botao" data-modal="modal${cupom.id}">VER CUPOM</button>
                    </div>
                </div>
                <br>
            `;

            modalContainer.innerHTML += `
                <div class="modal-overlay" id="modal${cupom.id}">
                    <div class="modal">
                        <h2>${cupom.titulo_modal}</h2>
                        <p>${cupom.descricao_modal}</p>
                        <p class="como-usar">${cupom.como_usar}</p>
                        <p class="btn-cupom">${cupom.codigo_modal}
                            <button class="copy-btn" data-copy="${cupom.data_copy_modal}">Copiar</button>
                        </p><br>
                        <a href="${cupom.link_loja}" target="_blank">
                            <button class="close-btn">Acessar site da ${cupom.loja_nome}</button>
                        </a>
                        <button class="close-btn">Fechar</button>
                    </div>
                </div>
            `;
        });

        // Reaplica os eventos de modal após o carregamento dinâmico
        adicionarEventosModais();
    })
    .catch(error => {
        console.error('Erro ao carregar os cupons e modais:', error);
    });
