<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<?php
$errors = $_SESSION['errors'] ?? [];
unset($_SESSION['errors']);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Notícia - Jornal Atlas</title>
    <link rel="stylesheet" href="<?= asset('css/style.css') ;?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <div class="search-box"><i class="fa-solid fa-magnifying-glass"></i>
            <form action="<?= url('/busca') ;?>" method="GET">
                <input type="hidden" name="url" value="busca">
                <input type="text" name="q" placeholder="Buscar notícias...">
            </form>
        </div>
        <div class="logo"><a href="<?= url('/') ;?>"><img src="<?= asset('img/atlas.png') ;?>" alt="Jornal Atlas"></a></div>
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

    <div class="create-pagina">
        <div class="breadcrumb">
            <a href="<?= url('/') ;?>">Início</a>
            <span>/</span>
            <a href="<?= url('/noticia/minhas') ;?>">Minhas Notícias</a>
            <span>/</span>
            Editar
        </div>

        <?php if (!empty($errors)): ?>
            <div class="alert-erro">
                <i class="fa-solid fa-circle-exclamation"></i>
                <ul>
                    <?php foreach ($errors as $err): ?>
                        <li><?= e($err) ;?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?= url('/noticia/' . $noticia->getId() . '/editar') ;?>" method="POST" enctype="multipart/form-data">
            <div class="create-layout">
                <div class="create-form">
                    <div class="create-header">
                        <h1><i class="fa-solid fa-pen-to-square"></i> Editar Notícia</h1>
                    </div>

                    <div class="form-grupo">
                        <label class="form-label">Título <span class="obrigatorio">*</span></label>
                        <input type="text" class="form-input" name="titulo" value="<?= e($noticia->getTitulo()) ;?>" required>
                    </div>

                    <div class="form-row">
                        <div class="form-grupo">
                            <label class="form-label">Categoria <span class="obrigatorio">*</span></label>
                            <select class="form-select" name="categoria" required>
                                <option value="">Selecione</option>
                                <?php foreach (['Política','Tecnologia','Economia','Esportes','Mundo','Cultura','Educação','Saúde','Entretenimento'] as $cat): ?>
                                    <option value="<?= $cat ;?>" <?= $noticia->getCategoria() === $cat ? 'selected' : '' ;?> ><?= $cat ;?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-grupo">
                            <label class="form-label">Seção <span class="obrigatorio">*</span></label>
                            <select class="form-select" name="secao" required>
                                <option value="">Selecione</option>
                                <option value="hero" <?= $noticia->getSecao() === 'hero' ? 'selected' : '' ;?> >Destaques (Hero)</option>
                                <option value="nacional" <?= $noticia->getSecao() === 'nacional' ? 'selected' : '' ;?> >Nacional</option>
                                <option value="internacional" <?= $noticia->getSecao() === 'internacional' ? 'selected' : '' ;?> >Internacional</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-grupo">
                        <label class="form-label">Resumo <span class="obrigatorio">*</span></label>
                        <textarea class="form-textarea" name="resumo" maxlength="300" rows="3" required><?= e($noticia->getResumo()) ;?></textarea>
                        <div class="form-contador"><span id="contadorResumo"><?= strlen($noticia->getResumo()) ;?>/300</span></div>
                    </div>

                    <div class="form-grupo">
                        <label class="form-label">Imagem da Matéria</label>
                        <div class="upload-area" id="uploadArea">
                            <input type="file" class="upload-input" id="inputImagem" name="imagem" accept="image/*">
                            <div class="upload-placeholder" id="uploadPlaceholder">
                                <i class="fa-solid fa-cloud-arrow-up"></i>
                                <p>Clique ou arraste uma imagem aqui</p>
                                <span>JPG, PNG ou WebP (max. 5MB)</span>
                            </div>
                            <div class="upload-preview" id="uploadPreview" style="display:none;">
                                <img id="previewImg" src="" alt="Preview">
                                <button type="button" class="upload-remover" id="removerImagem">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="form-grupo">
                        <label class="form-label">Conteúdo <span class="obrigatorio">*</span></label>
                        <textarea class="form-textarea-conteudo" name="conteudo" rows="15" required><?= e($noticia->getConteudo()) ;?></textarea>
                    </div>

                    <div class="create-actions">
                        <a href="<?= url('/noticia/minhas') ;?>" class="btn-action btn-cancelar">
                            <i class="fa-solid fa-xmark"></i> Cancelar
                        </a>
                        <div class="create-actions-direita">
                            <a href="<?= url('/noticia/' . $noticia->getId()) ;?>" class="btn-action btn-visualizar" target="_blank">
                                <i class="fa-solid fa-eye"></i> Visualizar
                            </a>
                            <?php if ($noticia->getStatus()->value === 'RASCUNHO'): ?>
                            <a href="<?= url('/noticia/' . $noticia->getId() . '/excluir-rascunho') ;?>" class="btn-action btn-excluir-rascunho" onclick="return confirm('Tem certeza que deseja excluir este rascunho?')">
                                <i class="fa-solid fa-trash"></i> Excluir Rascunho
                            </a>
                            <a href="<?= url('/noticia/' . $noticia->getId() . '/publicar') ;?>" class="btn-action btn-publicar" onclick="return confirm('Enviar esta notícia para revisão?')">
                                <i class="fa-solid fa-paper-plane"></i> Publicar
                            </a>
                            <?php endif; ?>
                            <button type="submit" class="btn-action btn-salvar">
                                <i class="fa-solid fa-floppy-disk"></i> Salvar Alterações
                            </button>
                        </div>
                    </div>
                </div>

                <div class="create-sidebar">
                    <div class="sidebar-card">
                        <div class="sidebar-titulo">Status</div>
                        <div class="sidebar-campo">
                            <?php $statusCls = strtolower(str_replace('_', '-', $noticia->getStatus()->value)); ?>
                            <span class="status-badge status-<?= $statusCls ;?>">
                                <i class="fa-regular fa-pen-to-square"></i>
                                <?= $noticia->getStatus()->value ;?>
                            </span>
                        </div>
                    </div>
                    <div class="sidebar-card">
                        <div class="sidebar-titulo">Publicado em</div>
                        <div class="sidebar-campo">
                            <span><?= $noticia->getDataCriacao()->format('d/m/Y H:i') ;?></span>
                        </div>
                        <?php if ($noticia->getDataEdicao()): ?>
                        <div class="sidebar-campo">
                            <label><i class="fa-regular fa-clock"></i> Última edição</label>
                            <span><?= $noticia->getDataEdicao()->format('d/m/Y H:i') ;?></span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
    const textarea = document.querySelector('textarea[name="resumo"]');
    const contador = document.getElementById('contadorResumo');
    if (textarea && contador) {
        textarea.addEventListener('input', () => {
            contador.textContent = textarea.value.length + '/300';
        });
    }

    const uploadArea = document.getElementById('uploadArea');
    const inputImagem = document.getElementById('inputImagem');
    const uploadPlaceholder = document.getElementById('uploadPlaceholder');
    const uploadPreview = document.getElementById('uploadPreview');
    const previewImg = document.getElementById('previewImg');
    const removerImagem = document.getElementById('removerImagem');

    if (uploadArea) {
        uploadArea.addEventListener('click', (e) => {
            if (e.target !== removerImagem && !removerImagem.contains(e.target)) {
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
                };
                reader.readAsDataURL(file);
            }
        });
        removerImagem.addEventListener('click', (e) => {
            e.stopPropagation();
            inputImagem.value = '';
            previewImg.src = '';
            uploadPlaceholder.style.display = 'block';
            uploadPreview.style.display = 'none';
        });
    }
    </script>
</body>
</html>