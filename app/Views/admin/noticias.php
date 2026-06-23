<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<?php
$userNome = $_SESSION['usuario_nome'] ?? '';
$userCargo = $_SESSION['usuario_cargo'] ?? 'leitor';
$userFoto = $_SESSION['usuario_foto'] ?? 'img/avatar_admin.png';
$sucesso = $_SESSION['sucesso'] ?? null;
unset($_SESSION['sucesso']);
$isAdmin = $userCargo === 'administrador';
$isRevisor = in_array($userCargo, ['revisor', 'administrador']);

$noticiaSelecionada = null;
$noticiaId = $_GET['noticia'] ?? null;
if ($noticiaId) {
    foreach ($noticias as $n) {
        if ((int) $n['id'] === (int) $noticiaId) {
            $noticiaSelecionada = $n;
            break;
        }
    }
}

$statusLabels = [
    'RASCUNHO' => 'RASCUNHO',
    'EM_ANALISE' => 'EM ANÁLISE',
    'APROVADA' => 'APROVADA',
    'ARQUIVADA' => 'ARQUIVADA',
    'REJEITADA' => 'REJEITADA',
];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Notícias - Jornal Atlas</title>
    <link rel="icon" type="image/png" href="<?= asset('img/atlas.fav.png') ;?>">
    <link rel="stylesheet" href="<?= asset('css/style.css') ;?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body class="dashboard-body">

    <aside class="dash-sidebar">
        <div class="dash-sidebar-logo">
            <a href="<?= url('/') ;?>"><img src="<?= asset('img/atlas.png') ;?>" alt="Jornal Atlas"></a>
        </div>
        <nav class="dash-sidebar-nav">
            <a href="<?= url('/dashboard') ;?>" class="dash-nav-item">
                <i class="fa-solid fa-house"></i> Dashboard
            </a>
            <a href="<?= url('/admin/noticias') ;?>" class="dash-nav-item active">
                <i class="fa-solid fa-newspaper"></i> Notícias
            </a>
            <a href="<?= url('/revisao') ;?>" class="dash-nav-item">
                <i class="fa-solid fa-clock-rotate-left"></i> Revisões
            </a>
            <?php if ($isAdmin): ?>
            <a href="<?= url('/solicitacoes') ;?>" class="dash-nav-item">
                <i class="fa-solid fa-user-gear"></i> Solicitações de Cargo
            </a>
            <a href="<?= url('/admin/usuarios') ;?>" class="dash-nav-item">
                <i class="fa-solid fa-users"></i> Usuários
            </a>
            <?php endif; ?>
            <a href="<?= url('/perfil') ;?>" class="dash-nav-item">
                <i class="fa-solid fa-user-circle"></i> Perfil
            </a>
        </nav>
        <div class="dash-sidebar-quote">
            <p>"Informação de qualidade conecta o mundo ao que realmente importa."</p>
        </div>
    </aside>

    <div class="dash-main">

        <header class="dash-topbar">
            <h1 class="dash-title">Gerenciar Notícias</h1>
            <div class="dash-user">
                <img src="<?= asset($userFoto) ;?>" alt="Foto" class="dash-user-avatar">
                <div class="dash-user-info">
                    <span class="dash-user-name"><?= e($userNome) ;?></span>
                    <span class="dash-user-role"><?= ucfirst(e($userCargo)) ;?></span>
                </div>
                <a href="<?= url('/logout') ;?>" class="dash-logout" title="Sair">
                    <i class="fa-solid fa-right-from-bracket"></i> SAIR
                </a>
            </div>
        </header>

        <div class="dash-content">

            <?php if ($sucesso): ?>
                <div class="alert-sucesso" style="margin-bottom:20px;"><i class="fa-solid fa-circle-check"></i> <?= e($sucesso) ;?></div>
            <?php endif; ?>

            <?php if (!empty($_SESSION['erro'])): ?>
                <div class="alert-erro" style="margin-bottom:20px;"><i class="fa-solid fa-circle-exclamation"></i> <?= e($_SESSION['erro']) ;?></div>
                <?php unset($_SESSION['erro']); ?>
            <?php endif; ?>

            <div class="admin-noticias-layout">

                <div class="admin-noticias-lista">
                    <div class="dash-section-header">
                        <h2>Todas as Notícias (<?= count($noticias) ;?>)</h2>
                    </div>

                    <?php if (empty($noticias)): ?>
                        <div class="dash-empty">
                            <i class="fa-regular fa-newspaper"></i>
                            <p>Nenhuma notícia encontrada.</p>
                        </div>
                    <?php else: ?>
                        <table class="dash-table">
                            <thead>
                                <tr>
                                    <th>Notícia</th>
                                    <th>Autor</th>
                                    <th>Status</th>
                                    <th>Criada em</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($noticias as $n): ?>
                                <?php $isSelected = ($noticiaSelecionada && (int) $noticiaSelecionada['id'] === (int) $n['id']); ?>
                                <tr class="<?= $isSelected ? 'selecionada' : '' ;?>" onclick="window.location='<?= url('/admin/noticias?noticia=' . $n['id']) ;?>'">
                                    <td>
                                        <div class="dash-noticia-cell">
                                            <img src="<?= asset('img/' . ($n['imagem'] ?: 'default.jpg')) ;?>" alt="" class="dash-cell-thumb">
                                            <div>
                                                <span class="dash-noticia-titulo"><?= e($n['titulo']) ;?></span>
                                                <span class="dash-categoria-tag"><?= e($n['categoria']) ;?></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="dash-user-cell">
                                            <img src="<?= asset($n['autor_foto'] ?? 'img/avatar_admin.png') ;?>" alt="" class="dash-cell-avatar">
                                            <?= e($n['autor_nome'] ?? 'Desconhecido') ;?>
                                        </div>
                                    </td>
                                    <td><span class="dash-status <?= strtolower(str_replace('_', '-', $n['status'])) ;?>"><?= $statusLabels[$n['status']] ?? $n['status'] ;?></span></td>
                                    <td><?= date('d/m/Y', strtotime($n['dataCriacao'])) ;?><br><small><?= date('H:i', strtotime($n['dataCriacao'])) ;?></small></td>
                                    <td>
                                        <div class="dash-actions" onclick="event.stopPropagation()">
                                            <a href="<?= url('/noticia/' . $n['id']) ;?>" class="dash-action-btn view" title="Ver"><i class="fa-solid fa-eye"></i></a>
                                            <a href="<?= url('/noticia/' . $n['id'] . '/editar') ;?>" class="dash-action-btn approve" title="Editar"><i class="fa-solid fa-pen"></i></a>
                                            <?php if ($isAdmin): ?>
                                            <form method="POST" action="<?= url('/admin/noticias/excluir/' . $n['id']) ;?>" style="display:inline;" onsubmit="return confirm('Tem certeza que deseja excluir esta notícia? Esta ação não pode ser desfeita.');">
                                                <button type="submit" class="dash-action-btn reject" title="Excluir"><i class="fa-solid fa-trash"></i></button>
                                            </form>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>

                <div class="admin-noticias-preview">
                    <?php if ($noticiaSelecionada): ?>
                        <div class="preview-cabecalho">
                            <div>
                                <span class="preview-categoria"><?= e($noticiaSelecionada['categoria']) ;?></span>
                                <span class="preview-status-badge status-<?= strtolower(str_replace('_', '-', $noticiaSelecionada['status'])) ;?>"><?= $statusLabels[$noticiaSelecionada['status']] ?? $noticiaSelecionada['status'] ;?></span>
                            </div>
                        </div>

                        <h2 class="preview-titulo"><?= e($noticiaSelecionada['titulo']) ;?></h2>
                        <p class="preview-meta">
                            <i class="fa-regular fa-user"></i> <?= e($noticiaSelecionada['autor_nome'] ?? 'Desconhecido') ;?>
                            &nbsp;&bull;&nbsp;
                            <i class="fa-regular fa-calendar"></i> <?= date('d/m/Y \à\s H:i', strtotime($noticiaSelecionada['dataCriacao'])) ;?>
                        </p>

                        <?php if ($noticiaSelecionada['imagem']): ?>
                            <div class="preview-imagem">
                                <img src="<?= asset('img/' . $noticiaSelecionada['imagem']) ;?>" alt="<?= e($noticiaSelecionada['titulo']) ;?>">
                            </div>
                        <?php endif; ?>

                        <div class="preview-resumo">
                            <p><?= e($noticiaSelecionada['resumo']) ;?></p>
                        </div>

                        <div class="preview-conteudo">
                            <?= nl2br(e($noticiaSelecionada['conteudo'])) ;?>
                        </div>

                        <div class="admin-noticia-actions">
                            <a href="<?= url('/noticia/' . $noticiaSelecionada['id'] . '/editar') ;?>" class="dash-btn dash-btn-primary">
                                <i class="fa-solid fa-pen"></i> Editar Notícia
                            </a>
                            <a href="<?= url('/noticia/' . $noticiaSelecionada['id']) ;?>" class="dash-btn dash-btn-outline">
                                <i class="fa-solid fa-eye"></i> Visualizar
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="preview-vazio">
                            <i class="fa-regular fa-newspaper"></i>
                            <p>Selecione uma notícia para visualizar.</p>
                        </div>
                    <?php endif; ?>
                </div>

            </div>

        </div>

        <footer class="dash-footer">
            <p>&copy; 2026 Jornal Atlas. Todos os direitos reservados.</p>
            <div class="dash-footer-links">
                <a href="<?= url('/termos-de-uso') ;?>">Termos de Uso</a>
                <a href="<?= url('/politica-de-privacidade') ;?>">Política de Privacidade</a>
                <a href="<?= url('/suporte') ;?>">Suporte</a>
            </div>
        </footer>
    </div>
    <script src="<?= asset('js/script.js') ;?>"></script>
</body>
</html>
