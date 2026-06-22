<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<?php
$userCargo = $_SESSION['usuario_cargo'] ?? 'leitor';
$userNome = $_SESSION['usuario_nome'] ?? '';
$userFoto = $_SESSION['usuario_foto'] ?? 'img/avatar_admin.png';
$sucesso = $_SESSION['sucesso'] ?? null;
unset($_SESSION['sucesso']);

$statusLabels = [
    'RASCUNHO' => 'RASCUNHO',
    'EM_ANALISE' => 'EM ANÁLISE',
    'APROVADA' => 'APROVADA',
    'ARQUIVADA' => 'ARQUIVADA',
    'REJEITADA' => 'REJEITADA',
];
$acaoLabels = [
    'APROVAR' => ['Aprovada', 'aprovada'],
    'REJEITAR' => ['Rejeitada', 'rejeitada'],
    'ARQUIVAR' => ['Arquivada', 'arquivada'],
];
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Revisões - Jornal Atlas</title>
    <link rel="stylesheet" href="<?= asset('css/style.css') ;?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Inter:wght@300;400;500;600&display=swap"
        rel="stylesheet">
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
            <a href="<?= url('/revisao') ;?>" class="dash-nav-item active">
                <i class="fa-solid fa-clock-rotate-left"></i> Revisões
            </a>
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
            <h1 class="dash-title">Minhas Revisões</h1>
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

            <div class="dash-stats" style="margin-bottom:24px;">
                <div class="dash-stat-card">
                    <div class="dash-stat-icon"><i class="fa-regular fa-newspaper"></i></div>
                    <div class="dash-stat-text">
                        <span class="dash-stat-num"><?= count($minhasNoticias) ;?></span>
                        <span class="dash-stat-label">Total de Notícias</span>
                    </div>
                </div>
                <div class="dash-stat-card">
                    <div class="dash-stat-icon"><i class="fa-solid fa-circle-check"></i></div>
                    <div class="dash-stat-text">
                        <span class="dash-stat-num"><?= count(array_filter($minhasNoticias, fn($n) => $n->getStatus()->value === 'APROVADA')) ;?></span>
                        <span class="dash-stat-label">Aprovadas</span>
                    </div>
                </div>
                <div class="dash-stat-card">
                    <div class="dash-stat-icon"><i class="fa-regular fa-clock"></i></div>
                    <div class="dash-stat-text">
                        <span class="dash-stat-num"><?= count(array_filter($minhasNoticias, fn($n) => $n->getStatus()->value === 'EM_ANALISE')) ;?></span>
                        <span class="dash-stat-label">Em Análise</span>
                    </div>
                </div>
                <div class="dash-stat-card">
                    <div class="dash-stat-icon"><i class="fa-solid fa-xmark"></i></div>
                    <div class="dash-stat-text">
                        <span class="dash-stat-num"><?= count(array_filter($minhasNoticias, fn($n) => $n->getStatus()->value === 'REJEITADA')) ;?></span>
                        <span class="dash-stat-label">Rejeitadas</span>
                    </div>
                </div>
            </div>

            <div class="admin-noticias-layout">

                <div class="admin-noticias-lista">
                    <div class="dash-section-header">
                        <h2>Minhas Notícias</h2>
                    </div>

                    <?php if (empty($minhasNoticias)): ?>
                        <div class="dash-empty">
                            <i class="fa-regular fa-newspaper"></i>
                            <p>Nenhuma notícia encontrada.</p>
                        </div>
                    <?php else: ?>
                        <table class="dash-table">
                            <thead>
                                <tr>
                                    <th>Notícia</th>
                                    <th>Status</th>
                                    <th>Última Revisão</th>
                                    <th>Enviado em</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($minhasNoticias as $n):
                                    $ultimaRevisao = $revisoesPorNoticia[$n->getId()][0] ?? null;
                                ?>
                                <tr class="<?= ($noticiaSelecionada && $noticiaSelecionada->getId() == $n->getId()) ? 'selecionada' : '' ;?>"
                                    onclick="window.location='<?= url('/revisao?noticia=' . $n->getId()) ;?>'">
                                    <td>
                                        <div class="dash-noticia-cell">
                                            <img src="<?= asset('img/' . ($n->getImagem() ?: 'default.jpg')) ;?>" alt="" class="dash-cell-thumb">
                                            <div>
                                                <span class="dash-noticia-titulo"><?= e($n->getTitulo()) ;?></span>
                                                <span class="dash-categoria-tag"><?= e($n->getCategoria()) ;?></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="dash-status <?= strtolower(str_replace('_', '-', $n->getStatus()->value)) ;?>"><?= $statusLabels[$n->getStatus()->value] ?? $n->getStatus()->value ;?></span></td>
                                    <td>
                                        <?php if ($ultimaRevisao):
                                            $acaoInfo = $acaoLabels[$ultimaRevisao->getAcao()->value] ?? ['Desconhecido', ''];
                                        ?>
                                            <span class="dash-status <?= $acaoInfo[1] ;?>"><?= $acaoInfo[0] ;?></span>
                                        <?php else: ?>
                                            <span style="color:#94a3b8;">—</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= date('d/m/Y', strtotime($n->getDataCriacao()->format('Y-m-d H:i:s'))) ;?><br><small><?= date('H:i', strtotime($n->getDataCriacao()->format('Y-m-d H:i:s'))) ;?></small></td>
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
                                <span class="preview-categoria"><?= e($noticiaSelecionada->getCategoria()) ;?></span>
                                <span class="preview-status-badge status-<?= strtolower(str_replace('_', '-', $noticiaSelecionada->getStatus()->value)) ;?>"><?= $statusLabels[$noticiaSelecionada->getStatus()->value] ?? $noticiaSelecionada->getStatus()->value ;?></span>
                            </div>
                        </div>

                        <h2 class="preview-titulo"><?= e($noticiaSelecionada->getTitulo()) ;?></h2>
                        <p class="preview-meta">
                            <i class="fa-regular fa-calendar"></i>
                            <?= format_date($noticiaSelecionada->getDataCriacao(), 'd/m/Y \à\s H:i') ;?>
                        </p>

                        <?php if ($noticiaSelecionada->getImagem()): ?>
                            <div class="preview-imagem">
                                <img src="<?= asset('img/' . $noticiaSelecionada->getImagem()) ;?>" alt="<?= e($noticiaSelecionada->getTitulo()) ;?>">
                            </div>
                        <?php endif; ?>

                        <div class="preview-resumo">
                            <p><?= e($noticiaSelecionada->getResumo()) ;?></p>
                        </div>

                        <div class="preview-conteudo">
                            <?= nl2br(e($noticiaSelecionada->getConteudo())) ;?>
                        </div>

                        <div class="admin-noticia-actions" style="margin-top:20px;">
                            <a href="<?= url('/noticia/' . $noticiaSelecionada->getId() . '/editar') ;?>" class="dash-btn dash-btn-primary">
                                <i class="fa-solid fa-pen"></i> Editar
                            </a>
                            <a href="<?= url('/noticia/' . $noticiaSelecionada->getId()) ;?>" class="dash-btn dash-btn-outline">
                                <i class="fa-solid fa-eye"></i> Visualizar
                            </a>
                        </div>

                        <?php if (!empty($revisoesNoticia)): ?>
                        <div style="margin-top:24px;">
                            <h3 style="font-family:'Playfair Display',serif; font-size:18px; margin-bottom:12px;">
                                <i class="fa-solid fa-clock-rotate-left"></i> Histórico de Revisões
                            </h3>
                            <?php foreach ($revisoesNoticia as $rev):
                                $acaoInfo = $acaoLabels[$rev->getAcao()->value] ?? ['Desconhecido', ''];
                                $revisor = \App\Repositories\UsuarioRepository::find($rev->getRevisorId());
                            ?>
                            <div style="background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); border-radius:10px; padding:16px; margin-bottom:12px;">
                                <div style="display:flex; align-items:center; gap:10px; margin-bottom:8px;">
                                    <img src="<?= asset($revisor ? $revisor->getFoto() : 'img/avatar_admin.png') ;?>" alt="" style="width:32px; height:32px; border-radius:50%; object-fit:cover;">
                                    <div>
                                        <strong style="font-size:14px;"><?= e($revisor ? $revisor->getNome() : 'Desconhecido') ;?></strong>
                                        <span class="dash-status <?= $acaoInfo[1] ;?>" style="margin-left:6px;"><?= $acaoInfo[0] ;?></span>
                                    </div>
                                    <span style="margin-left:auto; color:#94a3b8; font-size:12px;">
                                        <?= format_date($rev->getDataRevisao(), 'd/m/Y \à\s H:i') ;?>
                                    </span>
                                </div>
                                <?php if ($rev->getObservacao()): ?>
                                <p style="color:#cbd5e1; font-size:14px; margin:0; line-height:1.5;">
                                    "<?= e($rev->getObservacao()) ;?>"
                                </p>
                                <?php else: ?>
                                <p style="color:#64748b; font-size:13px; font-style:italic; margin:0;">
                                    Nenhuma observação registrada.
                                </p>
                                <?php endif; ?>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>

                    <?php else: ?>
                        <div class="preview-vazio">
                            <i class="fa-regular fa-newspaper"></i>
                            <p>Selecione uma notícia para ver detalhes e revisões.</p>
                        </div>
                    <?php endif; ?>
                </div>

            </div>

        </div>

        <footer class="dash-footer">
            <p>&copy; 2026 Jornal Atlas. Todos os direitos reservados.</p>
            <div class="dash-footer-links">
                <a href="#">Termos de Uso</a>
                <a href="#">Política de Privacidade</a>
                <a href="#">Suporte</a>
            </div>
        </footer>
    </div>

</body>
</html>
