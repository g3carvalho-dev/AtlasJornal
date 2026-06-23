<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$userLogado = isset($_SESSION['usuario_logado']) && $_SESSION['usuario_logado'] === true;
$userCargo = $_SESSION['usuario_cargo'] ?? 'leitor';
$userNome = $_SESSION['usuario_nome'] ?? '';
$userFoto = $_SESSION['usuario_foto'] ?? 'img/avatar_admin.png';
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Busca: <?= e($termo) ;?> - Jornal Atlas</title>

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
            <a href="<?= url('/sobre') ;?>">Sobre nós</a>
            <a href="<?= url('/anuncie') ;?>">Anuncie</a>
            <a href="<?= url('/contato') ;?>">Contato</a>
            <div class="social-icons">
                <a href="https://facebook.com" target="_blank" rel="noopener noreferrer" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                <a href="https://twitter.com" target="_blank" rel="noopener noreferrer" aria-label="Twitter"><i class="fa-brands fa-x-twitter"></i></a>
                <a href="https://youtube.com" target="_blank" rel="noopener noreferrer" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a>
            </div>
        </div>
    </div>

    <!-- HEADER -->
    <header>
        <div class="search-box">
            <i class="fa-solid fa-magnifying-glass"></i>
            <form action="<?= url('/busca') ;?>" method="GET">
                <input type="hidden" name="url" value="busca">
                <input type="text" name="q" placeholder="Buscar notícias..." value="<?= e($termo) ;?>">
            </form>
        </div>
        <div class="logo">
            <a href="<?= url('/') ;?>"><img src="<?= asset('img/atlas.png') ;?>" alt="Jornal Atlas"></a>
        </div>
        <div class="header-buttons">
            <?php if ($userLogado): ?>
            <div class="logged-user-info" style="cursor:pointer" onclick="window.location='<?= url('/perfil') ;?>'">
                <img src="<?= asset($userFoto) ;?>" alt="Foto de perfil" class="user-avatar">
                <div class="user-details">
                    <span class="user-name"><?= e($userNome) ;?></span>
                    <span class="user-role-label"><?= ucfirst(e($userCargo)) ;?></span>
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
            <?php $cats = ['Política' => 'POLÍTICA', 'Tecnologia' => 'TECNOLOGIA', 'Economia' => 'ECONOMIA', 'Esportes' => 'ESPORTES', 'Mundo' => 'MUNDO', 'Cultura' => 'CULTURA', 'Saúde' => 'SAÚDE', 'Ciência' => 'CIÊNCIA'];foreach ($cats as $l => $v): ?>
            <li><a href="<?= url('/categoria/' . urlencode($v)) ;?>"><?= $l ;?></a></li>
            <?php endforeach; ?>
        </ul>
    </nav>

    <!-- RESULTADOS DA BUSCA -->
    <main class="busca-pagina">
        <div class="busca-container">

            <a href="<?= url('/') ;?>" class="noticia-voltar">
                <i class="fa-solid fa-arrow-left"></i> Voltar para a Home
            </a>

            <h1 class="busca-titulo">
                <i class="fa-solid fa-magnifying-glass"></i>
                Resultados para: "<?= e($termo) ;?>"
            </h1>

            <p class="busca-contador">
                <?= count($resultados) ;?>
                <?= count($resultados) === 1 ? 'notícia encontrada' : 'notícias encontradas' ;?>
            </p>

            <?php if (empty($resultados)): ?>
            <div class="busca-vazio">
                <i class="fa-regular fa-face-frown"></i>
                <p>Nenhuma notícia foi encontrada para o termo "<strong><?= e($termo) ;?></strong>".</p>
                <p>Tente buscar com outras palavras.</p>
            </div>
            <?php else: ?>
            <div class="busca-resultados">
                <?php foreach ($resultados as $r): ?>
                <a href="<?= url('/noticia/' . $r['id']) ;?>" class="busca-card">
                    <div class="busca-card-img">
                        <?php if ($r['imagem']): ?>
                        <img src="<?= asset('img/' . $r['imagem']) ;?>" alt="<?= e($r['titulo']) ;?>">
                        <?php else: ?>
                        <div class="busca-card-sem-img"><i class="fa-regular fa-newspaper"></i></div>
                        <?php endif; ?>
                    </div>
                    <div class="busca-card-body">
                        <span class="busca-card-categoria"><?= e($r['categoria']) ;?></span>
                        <h3><?= e($r['titulo']) ;?></h3>
                        <p><?= e($r['resumo']) ;?></p>
                        <div class="busca-card-meta">
                            <span><i class="fa-solid fa-user-pen"></i>
                                <?= e($r['autor_nome'] ?? 'Desconhecido') ;?></span>
                            <?php if ($r['dataPublicacao']): ?>
                            <span><i class="fa-regular fa-calendar"></i>
                                <?= format_date(new DateTime($r['dataPublicacao']), 'd/m/Y') ;?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

        </div>
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
                    <a href="https://facebook.com" target="_blank" rel="noopener noreferrer" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                    <a href="https://twitter.com" target="_blank" rel="noopener noreferrer" aria-label="Twitter"><i class="fa-brands fa-x-twitter"></i></a>
                    <a href="https://youtube.com" target="_blank" rel="noopener noreferrer" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a>
                </div>
            </div>

            <div class="footer-links-col">
                <h4>NAVEGAÇÃO</h4>
                <div class="links-grid">
                    <a class="footer-link-item" href="<?= url('/categoria/' . urlencode('POLITICA')) ;?>">Política</a>
                    <a class="footer-link-item" href="<?= url('/categoria/' . urlencode('ECONOMIA')) ;?>">Economia</a>
                    <a class="footer-link-item" href="<?= url('/categoria/' . urlencode('ESPORTES')) ;?>">Esportes</a>
                    <a class="footer-link-item" href="<?= url('/categoria/' . urlencode('CULTURA')) ;?>">Cultura</a>
                    <a class="footer-link-item" href="<?= url('/categoria/' . urlencode('MUNDO')) ;?>">Mundo</a>
                    <a class="footer-link-item" href="<?= url('/categoria/' . urlencode('TECNOLOGIA')) ;?>">Tecnologia</a>
                </div>
            </div>

            <div class="footer-links-col">
                <h4>INSTITUCIONAL</h4>
                <div class="links-grid">
                    <a class="footer-link-item" href="<?= url('/sobre') ;?>">Sobre nós</a>
                    <a class="footer-link-item" href="<?= url('/anuncie') ;?>">Anuncie</a>
                    <a class="footer-link-item" href="<?= url('/codigo-de-etica') ;?>">Código de ética</a>
                    <a class="footer-link-item" href="<?= url('/contato') ;?>">Fale conosco</a>
                    <a class="footer-link-item" href="<?= url('/trabalhe-conosco') ;?>">Trabalhe conosco</a>
                    <a class="footer-link-item" href="<?= url('/termos-de-uso') ;?>">Termos de uso</a>
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

    <!-- SCRIPT -->
    <script>
    const data = new Date();
    const diasSemana = ["Domingo", "Segunda-feira", "Terça-feira", "Quarta-feira", "Quinta-feira", "Sexta-feira",
        "Sábado"
    ];
    const meses = ["janeiro", "fevereiro", "março", "abril", "maio", "junho", "julho", "agosto", "setembro", "outubro",
        "novembro", "dezembro"
    ];
    document.getElementById("data-atual").textContent =
        `${diasSemana[data.getDay()]}, ${data.getDate()} de ${meses[data.getMonth()]} de ${data.getFullYear()}`;
    </script>
    <script src="<?= asset('js/script.js') ;?>"></script>
</body>

</html>