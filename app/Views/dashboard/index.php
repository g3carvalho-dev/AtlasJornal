<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<?php
$userLogado = isset($_SESSION['usuario_logado']) && $_SESSION['usuario_logado'] === true;
$userCargo = $_SESSION['usuario_cargo'] ?? 'leitor';
$userNome = $_SESSION['usuario_nome'] ?? '';
$userFoto = $_SESSION['usuario_foto'] ?? 'img/avatar_admin.png';
$userEmail = $_SESSION['usuario_email'] ?? '';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo - Jornal Atlas</title>
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
            <a href="<?= url('/dashboard') ;?>" class="dash-nav-item active">
                <i class="fa-solid fa-house"></i> Dashboard
            </a>
            <a href="<?= url('/admin/noticias') ;?>" class="dash-nav-item">
                <i class="fa-solid fa-newspaper"></i> Notícias
            </a>
            <a href="<?= url('/revisao') ;?>" class="dash-nav-item">
                <i class="fa-solid fa-clock-rotate-left"></i> Revisões
            </a>
            <?php if (($_SESSION['usuario_cargo'] ?? '') === 'administrador'): ?>
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
            <h1 class="dash-title">Painel Administrativo - Jornal Atlas</h1>
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

            <div class="dash-stats">
                <div class="dash-stat-card">
                    <div class="dash-stat-icon"><i class="fa-regular fa-newspaper"></i></div>
                    <div class="dash-stat-text">
                        <span class="dash-stat-num"><?= $total ;?></span>
                        <span class="dash-stat-label">Total de Notícias</span>
                        <span class="dash-stat-sub">Publicadas no sistema</span>
                    </div>
                </div>
                <div class="dash-stat-card">
                    <div class="dash-stat-icon"><i class="fa-regular fa-clock"></i></div>
                    <div class="dash-stat-text">
                        <span class="dash-stat-num"><?= $pendentes ;?></span>
                        <span class="dash-stat-label">Pendentes de Revisão</span>
                        <span class="dash-stat-sub">Aguardando análise</span>
                    </div>
                </div>
                <div class="dash-stat-card">
                    <div class="dash-stat-icon"><i class="fa-solid fa-circle-check"></i></div>
                    <div class="dash-stat-text">
                        <span class="dash-stat-num"><?= $aprovadas ;?></span>
                        <span class="dash-stat-label">Aprovadas</span>
                        <span class="dash-stat-sub">Publicadas no total</span>
                    </div>
                </div>
                <div class="dash-stat-card">
                    <div class="dash-stat-icon"><i class="fa-solid fa-pen-nib"></i></div>
                    <div class="dash-stat-text">
                        <span class="dash-stat-num"><?= $redatores ;?></span>
                        <span class="dash-stat-label">Redatores</span>
                        <span class="dash-stat-sub">Ativos</span>
                    </div>
                </div>
                <div class="dash-stat-card">
                    <div class="dash-stat-icon"><i class="fa-solid fa-shield-halved"></i></div>
                    <div class="dash-stat-text">
                        <span class="dash-stat-num"><?= $revisores ;?></span>
                        <span class="dash-stat-label">Revisores</span>
                        <span class="dash-stat-sub">Ativos</span>
                    </div>
                </div>
            </div>

            <div class="dash-section">
                <div class="dash-section-header">
                    <h2>Fila de Revisão</h2>
                    <div class="dash-section-actions">
                        <a href="<?= url('/revisao') ;?>" class="dash-btn dash-btn-primary">
                            <i class="fa-solid fa-eye"></i> VER TODAS
                        </a>
                    </div>
                </div>

                <?php if (empty($filaRevisao)): ?>
                    <div class="dash-empty">
                        <i class="fa-regular fa-circle-check"></i>
                        <p>Nenhuma notícia pendente de revisão.</p>
                    </div>
                <?php else: ?>
                    <table class="dash-table">
                        <thead>
                            <tr>
                                <th>Título</th>
                                <th>Redator</th>
                                <th>Status</th>
                                <th>Data de Envio</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($filaRevisao as $row): ?>
                            <tr>
                                <td>
                                    <span class="dash-noticia-titulo"><?= e($row['titulo']) ;?></span>
                                    <span class="dash-categoria-tag"><?= e($row['categoria']) ;?></span>
                                </td>
                                <td>
                                    <div class="dash-user-cell">
                                        <img src="<?= asset($row['autor_foto'] ?? 'img/avatar_admin.png') ;?>" alt="" class="dash-cell-avatar">
                                        <?= e($row['autor_nome'] ?? 'Desconhecido') ;?>
                                    </div>
                                </td>
                                <td><span class="dash-status pendente">PENDENTE</span></td>
                                <td><?= date('d/m/Y', strtotime($row['dataCriacao'])) ;?><br><small><?= date('H:i', strtotime($row['dataCriacao'])) ;?></small></td>
                                <td>
                                    <div class="dash-actions">
                                        <a href="<?= url('/noticia/' . $row['id']) ;?>" class="dash-action-btn view" title="Ver"><i class="fa-solid fa-eye"></i></a>
                                        <a href="<?= url('/revisao?noticia=' . $row['id']) ;?>" class="dash-action-btn approve" title="Aprovar"><i class="fa-solid fa-check"></i></a>
                                        <a href="<?= url('/revisao?noticia=' . $row['id']) ;?>" class="dash-action-btn reject" title="Rejeitar"><i class="fa-solid fa-xmark"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>

            <div class="dash-section">
                <div class="dash-section-header">
                    <h2>Solicitações de Cargo</h2>
                    <a href="<?= url('/solicitacoes') ;?>" class="dash-btn dash-btn-outline">
                        VER TODAS <i class="fa-solid fa-chevron-right"></i>
                    </a>
                </div>

                <?php if (empty($solicitacoes)): ?>
                    <div class="dash-empty">
                        <i class="fa-regular fa-folder-open"></i>
                        <p>Nenhuma solicitação de cargo pendente.</p>
                    </div>
                <?php else: ?>
                    <table class="dash-table">
                        <thead>
                            <tr>
                                <th>Candidato</th>
                                <th>Cargo Solicitado</th>
                                <th>Data da Solicitação</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($solicitacoes as $sol): ?>
                            <tr>
                                <td>
                                    <div class="dash-user-cell">
                                        <img src="<?= asset($sol['usuario_foto'] ?? 'img/avatar_admin.png') ;?>" alt="" class="dash-cell-avatar">
                                        <div>
                                            <span class="dash-user-cell-name"><?= e($sol['usuario_nome']) ;?></span>
                                            <span class="dash-user-cell-email"><?= e($sol['usuario_email']) ;?></span>
                                        </div>
                                    </div>
                                </td>
                                <td><?= e($sol['cargo']) ;?></td>
                                <td><?= date('d/m/Y', strtotime($sol['dataSolicitacao'])) ;?><br><small><?= date('H:i', strtotime($sol['dataSolicitacao'])) ;?></small></td>
                                <td><span class="dash-status pendente">PENDENTE</span></td>
                                <td>
                                    <div class="dash-actions">
                                        <a href="<?= url('/solicitacoes?id=' . $sol['id']) ;?>" class="dash-action-btn view" title="Ver"><i class="fa-solid fa-eye"></i></a>
                                        <a href="<?= url('/solicitacoes?id=' . $sol['id']) ;?>" class="dash-action-btn approve" title="Aprovar"><i class="fa-solid fa-check"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
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