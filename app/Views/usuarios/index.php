<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<?php
$userNome = $_SESSION['usuario_nome'] ?? '';
$userCargo = $_SESSION['usuario_cargo'] ?? 'leitor';
$userFoto = $_SESSION['usuario_foto'] ?? 'img/avatar_admin.png';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Usuários - Jornal Atlas</title>
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
            <a href="<?= url('/admin/noticias') ;?>" class="dash-nav-item">
                <i class="fa-solid fa-newspaper"></i> Notícias
            </a>
            <a href="<?= url('/revisao') ;?>" class="dash-nav-item">
                <i class="fa-solid fa-clock-rotate-left"></i> Revisões
            </a>
            <a href="<?= url('/solicitacoes') ;?>" class="dash-nav-item">
                <i class="fa-solid fa-user-gear"></i> Solicitações de Cargo
            </a>
            <a href="<?= url('/admin/usuarios') ;?>" class="dash-nav-item active">
                <i class="fa-solid fa-users"></i> Usuários
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
            <h1 class="dash-title">Gerenciar Usuários</h1>
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

            <div class="dash-section">
                <div class="dash-section-header">
                    <h2>Todos os Usuários (<?= count($usuarios) ;?>)</h2>
                </div>

                <table class="dash-table">
                    <thead>
                        <tr>
                            <th>Usuário</th>
                            <th>Formação</th>
                            <th>Cargo</th>
                            <th>Notícias</th>
                            <th>Revisões</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $u): ?>
                        <?php $isCurrentUser = ((int) $u->getId() === (int) ($_SESSION['usuario_id'] ?? 0)); ?>
                        <tr>
                            <td>
                                <div class="dash-user-cell">
                                    <img src="<?= asset($u->getFoto()) ;?>" alt="" class="dash-cell-avatar">
                                    <div>
                                        <span class="dash-user-cell-name"><?= e($u->getNome()) ;?></span>
                                        <span class="dash-user-cell-email"><?= e($u->getEmail()) ;?></span>
                                    </div>
                                </div>
                            </td>
                            <td><?= e($u->getFormacao()) ?: '—' ;?></td>
                            <td><span class="cargo-badge cargo-<?= strtolower($u->getCargo()) ;?>"><?= strtoupper($u->getCargo()) ;?></span></td>
                            <td class="dash-count-cell"><?= $stats[$u->getId()]['noticias'] ;?></td>
                            <td class="dash-count-cell"><?= $stats[$u->getId()]['revisoes'] ;?></td>
                            <td>
                                <?php if ($isCurrentUser): ?>
                                    <span style="color:#aaa; font-size:12px;">Conta atual</span>
                                <?php else: ?>
                                    <form method="POST" action="<?= url('/admin/usuarios/excluir/' . $u->getId()) ;?>" style="display:inline;" onsubmit="return confirm('Tem certeza que deseja excluir o usuário <?= e($u->getNome()) ;?>? Esta ação não pode ser desfeita.');">
                                        <button type="submit" class="dash-action-btn reject" title="Excluir">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
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