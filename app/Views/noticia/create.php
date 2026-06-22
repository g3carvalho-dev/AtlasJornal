<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Nova Notícia - Jornal Atlas</title>

    <link rel="stylesheet" href="<?= asset('css/style.css') ;?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Inter:wght@300;400;500;600&display=swap"
        rel="stylesheet">
</head>

<body>

    <!-- TOPO -->
    <div class="topbar">
        <div class="topbar-left" id="data-atual"></div>
        <div class="topbar-right">
            <a href="#">Sobre nós</a>
            <a href="#">Anuncie</a>
            <a href="#">Contato</a>
            <div class="social-icons">
                <a href="#" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="#" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                <a href="#" aria-label="Twitter"><i class="fa-brands fa-x-twitter"></i></a>
                <a href="#" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a>
            </div>
        </div>
    </div>

    <!-- HEADER -->
    <header>
        <div class="search-box">
            <i class="fa-solid fa-magnifying-glass"></i>
            <form action="<?= url('/busca') ;?>" method="GET">
                <input type="hidden" name="url" value="busca">
                <input type="text" name="q" placeholder="Buscar notícias...">
            </form>
        </div>
        <div class="logo">
            <a href="<?= url('/') ;?>"><img src="<?= asset('img/atlas.png') ;?>" alt="Jornal Atlas"></a>
        </div>
        <div class="header-buttons">
            <?php $userLogado = isset($_SESSION['usuario_logado']) && $_SESSION['usuario_logado'] === true; ?>
            <?php if ($userLogado): ?>
                <div class="logged-user-info" style="cursor:pointer" onclick="window.location='<?= url('/perfil') ;?>'">
                    <img src="<?= asset($_SESSION['usuario_foto'] ?? 'img/avatar_admin.png') ;?>" alt="Foto de perfil" class="user-avatar">
                    <div class="user-details">
                        <span class="user-name"><?= e($_SESSION['usuario_nome'] ?? '') ;?></span>
                        <span class="user-role-label"><?= ucfirst(e($_SESSION['usuario_cargo'] ?? '')) ;?></span>
                    </div>
                    <a href="<?= url('/logout') ;?>" class="btn-logout-icon" title="Sair do sistema"><i class="fa-solid fa-right-from-bracket"></i></a>
                </div>
            <?php else: ?>
                <a href="<?= url('/login') ;?>" class="btn-login">Entrar</a>
                <a href="<?= url('/cadastro') ;?>" class="btn-cadastro">Cadastrar</a>
            <?php endif; ?>
        </div>
    </header>

    <!-- MENU -->
    <nav>
        <ul>
            <li><a href="#">Política</a></li>
            <li><a href="#">Tecnologia</a></li>
            <li><a href="#">Economia</a></li>
            <li><a href="#">Esportes</a></li>
            <li><a href="#">Mundo</a></li>
            <li><a href="#">Cultura</a></li>
        </ul>
    </nav>

    <!-- CONTEUDO -->
    <main class="create-pagina">

        <!-- BREADCRUMB -->
        <div class="breadcrumb">
            <a href="<?= url('/') ;?>">Home</a>
            <span>/</span>
            <span>Nova notícia</span>
        </div>

        <?php if (!empty($_SESSION['errors'])): ?>
        <div class="alert alert-erro">
            <i class="fa-solid fa-circle-exclamation"></i>
            <ul>
                <?php foreach ($_SESSION['errors'] as $erro): ?>
                <li><?= e($erro) ;?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php unset($_SESSION['errors']);endif; ?>

        <?php
$old = $_SESSION['old'] ?? [];
unset($_SESSION['old']);
?>

        <form action="<?= url('/noticia/nova') ;?>" method="POST" enctype="multipart/form-data" class="create-layout"
            id="form-noticia">

            <!-- FORM PRINCIPAL -->
            <div class="create-form">

                <div class="create-header">
                    <h1><i class="fa-solid fa-wand-magic-sparkles"></i> Nova notícia</h1>
                </div>

                <!-- TITULO -->
                <div class="form-grupo">
                    <label class="form-label">TÍTULO <span class="obrigatorio">*</span></label>
                    <input type="text" name="titulo" class="form-input"
                        placeholder="Digite um título claro, informativo e atraente"
                        value="<?= e($old['titulo'] ?? '') ;?>" required>
                </div>

                <!-- CATEGORIA + SECAO -->
                <div class="form-row">
                    <div class="form-grupo">
                        <label class="form-label">CATEGORIA <span class="obrigatorio">*</span></label>
                        <select name="categoria" class="form-select" required>
                            <option value="">Selecione uma categoria</option>
                            <?php
$cats = ['POLÍTICA', 'ECONOMIA', 'ESPORTES', 'SAÚDE', 'CIÊNCIA', 'CULTURA', 'TECNOLOGIA', 'MUNDO'];
$selected = $old['categoria'] ?? '';
foreach ($cats as $cat):
?>
                            <option value="<?= $cat ;?>" <?= $selected === $cat ? 'selected' : '' ;?>><?= $cat ;?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-grupo">
                        <label class="form-label">SEÇÃO <span class="obrigatorio">*</span></label>
                        <select name="secao" class="form-select" required>
                            <option value="">Selecione uma seção</option>
                            <?php
$secs = ['hero' => 'Destaques (Hero)', 'nacional' => 'Nacional', 'internacional' => 'Internacional'];
$selectedSec = $old['secao'] ?? '';
foreach ($secs as $val => $label):
?>
                            <option value="<?= $val ;?>" <?= $selectedSec === $val ? 'selected' : '' ;?>><?= $label ;?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <!-- RESUMO -->
                <div class="form-grupo">
                    <label class="form-label">RESUMO <span class="obrigatorio">*</span></label>
                    <textarea name="resumo" class="form-textarea" rows="3" maxlength="300"
                        placeholder="Escreva um resumo curto que aparecerá nos destaques e nas buscas do site..."
                        required id="resumo"><?= e($old['resumo'] ?? '') ;?></textarea>
                    <div class="form-contador"><span id="resumo-contador">0</span>/300 caracteres</div>
                </div>

                <!-- IMAGEM DE CAPA -->
                <div class="form-grupo">
                    <label class="form-label">IMAGEM DE CAPA</label>
                    <div class="upload-area" id="upload-area">
                        <input type="file" name="imagem" id="input-imagem" accept="image/*" class="upload-input">
                        <div class="upload-placeholder" id="upload-placeholder">
                            <i class="fa-solid fa-cloud-arrow-up"></i>
                            <p>Arraste uma imagem aqui ou clique para enviar</p>
                            <span>Recomendado: 16:9 • JPG ou WebP • Até 5MB</span>
                        </div>
                        <div class="upload-preview" id="upload-preview" style="display:none;">
                            <img id="preview-img" src="" alt="Preview">
                            <button type="button" class="upload-remover" id="remover-imagem">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- CONTEUDO -->
                <div class="form-grupo">
                    <label class="form-label">CONTEÚDO <span class="obrigatorio">*</span></label>
                    <textarea name="conteudo" class="form-textarea-conteudo" rows="15"
                        placeholder="Comece a escrever sua notícia aqui..." required
                        id="conteudo-campo"><?= e($old['conteudo'] ?? '') ;?></textarea>
                    <div class="form-contador">Contagem de palavras: <span id="palavras-contador">0</span></div>
                </div>

            </div>

            <!-- SIDEBAR -->
            <aside class="create-sidebar">

                <!-- PUBLICACAO -->
                <div class="sidebar-card">
                    <h3 class="sidebar-titulo">PUBLICAÇÃO</h3>
                    <div class="sidebar-campo">
                        <label>Status</label>
                        <div class="status-badge status-rascunho">
                            <i class="fa-solid fa-pen"></i> RASCUNHO / ESCRITA
                        </div>
                    </div>
                    <div class="sidebar-campo">
                        <label><i class="fa-regular fa-user"></i> Autor</label>
                        <span>Redator (logado)</span>
                    </div>
                    <div class="sidebar-campo">
                        <label><i class="fa-regular fa-clock"></i> Última edição</label>
                        <span id="data-edicao"></span>
                    </div>
                </div>

                <!-- LISTA DE VERIFICACAO -->
                <div class="sidebar-card">
                    <h3 class="sidebar-titulo">LISTA DE VERIFICAÇÃO</h3>
                    <ul class="checklist">
                        <li id="check-titulo"><i class="fa-regular fa-circle"></i> Título claro e objetivo</li>
                        <li id="check-resumo"><i class="fa-regular fa-circle"></i> Resumo preenchido</li>
                        <li id="check-imagem"><i class="fa-regular fa-circle"></i> Imagem de capa definida</li>
                        <li id="check-conteudo"><i class="fa-regular fa-circle"></i> Conteúdo com no mínimo 10 palavras
                        </li>
                        <li id="check-categoria"><i class="fa-regular fa-circle"></i> Categoria e seção definidas</li>
                    </ul>
                </div>

                <!-- SECAO / DESTAQUE -->
                <div class="sidebar-card">
                    <h3 class="sidebar-titulo">SEÇÃO / DESTAQUE</h3>
                    <div class="sidebar-campo">
                        <label>Seção principal</label>
                        <p class="sidebar-info">Definido no formulário acima</p>
                    </div>
                </div>

            </aside>

            <!-- BOTOES DE ACAO -->
            <div class="create-actions">
                <a href="<?= url('/') ;?>" class="btn-action btn-cancelar">
                    <i class="fa-solid fa-xmark"></i> CANCELAR
                </a>
                <div class="create-actions-direita">
                    <button type="submit" name="acao" value="salvar" class="btn-action btn-salvar">
                        <i class="fa-regular fa-floppy-disk"></i> SALVAR RASCUNHO
                    </button>
                    <button type="button" class="btn-action btn-visualizar" id="btn-preview">
                        <i class="fa-regular fa-eye"></i> VISUALIZAR
                    </button>
                    <button type="submit" name="acao" value="enviar" class="btn-action btn-enviar">
                        ENVIAR PARA REVISÃO <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </div>
            </div>

        </form>

    </main>

    <!-- FOOTER -->
    <footer>
        <div class="footer-container">
            <div class="footer-brand">
                <div class="footer-logo">
                    <img src="<?= asset('img/atlas.png') ;?>" alt="Jornal Atlas">
                </div>
                <p class="footer-tagline">
                    Informação com profundidade, contexto e credibilidade para entender o mundo.
                </p>
                <div class="footer-social">
                    <a href="#" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" aria-label="Twitter"><i class="fa-brands fa-x-twitter"></i></a>
                    <a href="#" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a>
                </div>
            </div>
            <div class="footer-links-col">
                <h4>NAVEGAÇÃO</h4>
                <div class="links-grid">
                    <a class="footer-link-item" href="#">Política</a>
                    <a class="footer-link-item" href="#">Culinária</a>
                    <a class="footer-link-item" href="#">Artes</a>
                    <a class="footer-link-item" href="#">Lifestyle</a>
                    <a class="footer-link-item" href="#">Games</a>
                    <a class="footer-link-item" href="#">Business</a>
                </div>
            </div>
            <div class="footer-links-col">
                <h4>INSTITUCIONAL</h4>
                <div class="links-grid">
                    <a class="footer-link-item" href="#">Sobre nós</a>
                    <a class="footer-link-item" href="#">Anuncie</a>
                    <a class="footer-link-item" href="#">Código de ética</a>
                    <a class="footer-link-item" href="#">Fale conosco</a>
                    <a class="footer-link-item" href="#">Trabalhe conosco</a>
                    <a class="footer-link-item" href="#">Termos de uso</a>
                </div>
            </div>
            <div class="footer-newsletter">
                <h4>NEWSLETTER</h4>
                <p>Receba as principais notícias do dia no seu e-mail.</p>
                <form class="newsletter-form">
                    <input type="email" placeholder="Seu e-mail" required>
                    <button type="submit" aria-label="Enviar"><i class="fa-solid fa-paper-plane"></i></button>
                </form>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2026 Jornal Atlas. Todos os direitos reservados.</p>
        </div>
    </footer>

    <!-- SCRIPTS -->
    <script>
    // Data atual na topbar
    const data = new Date();
    const diasSemana = ["Domingo", "Segunda-feira", "Terça-feira", "Quarta-feira", "Quinta-feira", "Sexta-feira",
        "Sábado"
    ];
    const meses = ["janeiro", "fevereiro", "março", "abril", "maio", "junho", "julho", "agosto", "setembro", "outubro",
        "novembro", "dezembro"
    ];
    document.getElementById("data-atual").textContent =
        `${diasSemana[data.getDay()]}, ${data.getDate()} de ${meses[data.getMonth()]} de ${data.getFullYear()}`;

    // Data da última edição
    document.getElementById("data-edicao").textContent =
        `${data.getDate()} de ${meses[data.getMonth()]} de ${data.getFullYear()} às ${String(data.getHours()).padStart(2,'0')}:${String(data.getMinutes()).padStart(2,'0')}`;

    // Contador de caracteres do resumo
    const resumo = document.getElementById('resumo');
    const resumoContador = document.getElementById('resumo-contador');
    resumoContador.textContent = resumo.value.length;
    resumo.addEventListener('input', () => {
        resumoContador.textContent = resumo.value.length;
        updateChecklist();
    });

    // Upload de imagem com preview
    const inputImagem = document.getElementById('input-imagem');
    const uploadArea = document.getElementById('upload-area');
    const uploadPlaceholder = document.getElementById('upload-placeholder');
    const uploadPreview = document.getElementById('upload-preview');
    const previewImg = document.getElementById('preview-img');
    const removerBtn = document.getElementById('remover-imagem');

    uploadArea.addEventListener('click', (e) => {
        if (e.target !== removerBtn && !removerBtn.contains(e.target)) {
            inputImagem.click();
        }
    });

    inputImagem.addEventListener('change', (e) => {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (ev) => {
                previewImg.src = ev.target.result;
                uploadPlaceholder.style.display = 'none';
                uploadPreview.style.display = 'flex';
                updateChecklist();
            };
            reader.readAsDataURL(file);
        }
    });

    removerBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        inputImagem.value = '';
        previewImg.src = '';
        uploadPlaceholder.style.display = 'flex';
        uploadPreview.style.display = 'none';
        updateChecklist();
    });

    // Contador de palavras do conteúdo
    const conteudoCampo = document.getElementById('conteudo-campo');
    const palavrasContador = document.getElementById('palavras-contador');

    function contarPalavras(texto) {
        const limpo = texto.replace(/<[^>]*>/g, '').trim();
        if (limpo === '') return 0;
        return limpo.split(/\s+/).length;
    }

    function updateContadorPalavras() {
        const texto = conteudoCampo.value || '';
        palavrasContador.textContent = contarPalavras(texto);
    }

    conteudoCampo.addEventListener('input', () => {
        updateContadorPalavras();
        updateChecklist();
    });

    // Checklist dinâmica
    function updateChecklist() {
        const titulo = document.querySelector('input[name="titulo"]').value.trim();
        const resumoVal = document.getElementById('resumo').value.trim();
        const categoria = document.querySelector('select[name="categoria"]').value;
        const secao = document.querySelector('select[name="secao"]').value;
        const imagemDefinida = inputImagem.files.length > 0;
        const conteudoTexto = conteudoCampo.value || '';
        const palavras = contarPalavras(conteudoTexto);

        setCheck('check-titulo', titulo.length > 0);
        setCheck('check-resumo', resumoVal.length > 0);
        setCheck('check-imagem', imagemDefinida);
        setCheck('check-conteudo', palavras >= 10);
        setCheck('check-categoria', categoria !== '' && secao !== '');
    }

    function setCheck(id, ok) {
        const el = document.getElementById(id);
        if (ok) {
            el.innerHTML = '<i class="fa-solid fa-circle-check"></i> ' + el.textContent.replace(/^.*?\s/, '');
            el.classList.add('check-ok');
        } else {
            el.innerHTML = '<i class="fa-regular fa-circle"></i> ' + el.textContent.replace(/^.*?\s/, '');
            el.classList.remove('check-ok');
        }
    }

    // Atualizar checklist nos campos de título, categoria e seção
    document.querySelector('input[name="titulo"]').addEventListener('input', updateChecklist);
    document.querySelector('select[name="categoria"]').addEventListener('change', updateChecklist);
    document.querySelector('select[name="secao"]').addEventListener('change', updateChecklist);

    // Preview em nova aba
    document.getElementById('btn-preview').addEventListener('click', () => {
        const titulo = document.querySelector('input[name="titulo"]').value || 'Sem título';
        const resumoVal = document.getElementById('resumo').value || '';
        const conteudoHtml = conteudoCampo.value || '';

        let imgHtml = '';
        if (uploadPreview.style.display !== 'none') {
            imgHtml = '<img src="' + previewImg.src +
                '" style="max-width:100%;border-radius:10px;margin:20px 0;">';
        }

        const preview = `
            <!DOCTYPE html>
            <html lang="pt-BR">
            <head>
                <meta charset="UTF-8">
                <title>${titulo} - Preview</title>
                <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
                <style>
                    body { font-family: 'Inter', sans-serif; max-width: 800px; margin: 40px auto; padding: 20px; color: #222; }
                    h1 { font-family: 'Playfair Display', serif; font-size: 2.4rem; color: #011838; margin-bottom: 15px; }
                    .resumo { font-size: 18px; color: #444; font-weight: 500; border-bottom: 1px solid #eee; padding-bottom: 20px; margin-bottom: 20px; }
                    .conteudo { line-height: 1.8; font-size: 16px; }
                </style>
            </head>
            <body>
                <h1>${titulo}</h1>
                <div class="resumo">${resumoVal}</div>
                ${imgHtml}
                <div class="conteudo">${conteudoHtml}</div>
            </body>
            </html>`;

        const w = window.open('', '_blank');
        w.document.write(preview);
        w.document.close();
    });

    // Checklist inicial
    updateChecklist();
    updateContadorPalavras();

    // Prevenir duplo envio
    document.getElementById('form-noticia').addEventListener('submit', function() {
        const btns = this.querySelectorAll('button[type="submit"]');
        btns.forEach(function(btn) {
            btn.disabled = true;
        });
    });
    </script>

</body>

</html>