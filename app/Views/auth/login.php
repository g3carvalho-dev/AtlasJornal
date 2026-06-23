<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!function_exists('asset')) {
    function asset($path)
    {return 'assets/' . $path;}
}
if (!function_exists('url')) {
    function url($path)
    {return $path;}
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jornal Atlas - Entrar</title>
    <link rel="stylesheet" href="<?= asset('css/style.css') ;?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Inter:wght@300;400;500;600&display=swap"
        rel="stylesheet">
</head>

<body class="auth-body">

    <div class="auth-header">
        <div class="auth-logo">
            <img src="<?= asset('img/atlas.png') ;?>" alt="Jornal Atlas">
        </div>
        <div class="auth-nav">
            <a href="<?= url('/') ;?>">NOTÍCIAS</a>
            <span class="divider">•</span>
            <a href="<?= url('/categoria/' . urlencode('POLÍTICA')) ;?>">CATEGORIAS</a>
            <span class="divider">•</span>
            <a href="<?= url('/sobre') ;?>">SOBRE NÓS</a>
            <a href="<?= url('/') ;?>" class="btn-back-site"><i class="fa-solid fa-arrow-left"></i> VOLTAR AO SITE</a>
        </div>
    </div>

    <main class="auth-container">

        <section class="auth-sidebar login-left">
            <div class="sidebar-content">
                <span class="sidebar-subtitle">Bem-vindo ao</span>
                <h1 class="sidebar-title">JORNAL ATLAS</h1>
                <p class="sidebar-text">Jornalismo com visão global, compromisso local.</p>
                <p class="sidebar-highlight">Informação que conecta o mundo.</p>
            </div>
        </section>

        <section class="auth-form-container login-right">
            <div class="form-box">
                <h2>Entrar na sua conta</h2>
                <p class="form-subtitle">Acesse sua conta para continuar lendo as principais notícias do mundo.</p>

                <form action="<?= url('/login') ;?>" method="POST">

                    <?php if (!empty($_SESSION['errors'])): ?>
                    <div class="auth-errors">
                        <?php foreach ($_SESSION['errors'] as $err): ?>
                        <p><i class="fa-solid fa-circle-exclamation"></i> <?= e($err) ;?></p>
                        <?php endforeach; ?>
                    </div>
                    <?php unset($_SESSION['errors']); ?>
                    <?php endif; ?>

                    <?php if (!empty($_SESSION['sucesso'])): ?>
                    <div class="auth-success">
                        <p><i class="fa-solid fa-circle-check"></i> <?= e($_SESSION['sucesso']) ;?></p>
                    </div>
                    <?php unset($_SESSION['sucesso']); ?>
                    <?php endif; ?>

                    <div class="input-group">
                        <label for="email">E-mail</label>
                        <div class="input-field">
                            <i class="fa-regular fa-envelope"></i>
                            <input type="email" id="email" name="email" placeholder="seu@email.com"
                                value="<?= e($_SESSION['old']['email'] ?? '') ;?>" required>
                        </div>
                    </div>

                    <div class="input-group">
                        <label for="senha">Senha</label>
                        <div class="input-field">
                            <i class="fa-solid fa-lock"></i>
                            <input type="password" id="senha" name="senha" placeholder="••••••••" required>
                            <i class="fa-regular fa-eye toggle-password" id="toggleSenha"></i>
                        </div>
                        <div class="forgot-password-container">
                            <a href="#" class="forgot-password">Esqueci minha senha</a>
                        </div>
                    </div>

                    <button type="submit" class="btn-auth-submit">
                        <i class="fa-solid fa-user"></i> ENTRAR
                    </button>

                </form>

                <div class="auth-divider">
                    <span>ou</span>
                </div>

                <a href="<?= url('/cadastro') ;?>" class="btn-auth-secondary">
                    <i class="fa-solid fa-user-plus"></i> CRIAR UMA CONTA
                </a>

                <div class="auth-note">
                    <i class="fa-solid fa-shield-halved"></i>
                    <p>Para acesso institucional ou se você deseja se tornar redator(a) ou revisor(a), <b>preencha as
                            informações adicionais e solicite acesso no seu perfil após criar a conta.</b></p>
                </div>

            </div>
        </section>

    </main>

    <footer class="auth-footer">
        <p>&copy; 2026 Jornal Atlas. Todos os direitos reservados.</p>
        <div class="auth-footer-links">
            <a href="<?= url('/politica-de-privacidade') ;?>">Política de Privacidade</a>
            <span class="divider">•</span>
            <a href="<?= url('/termos-de-uso') ;?>">Termos de Uso</a>
            <span class="divider">•</span>
            <a href="<?= url('/contato') ;?>">Contato</a>
        </div>
    </footer>

    <script src="<?= asset('js/script.js') ;?>"></script>

</body>

</html>