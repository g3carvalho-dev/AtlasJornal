<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$userLogado = isset($_SESSION['usuario_logado']) && $_SESSION['usuario_logado'] === true;
$userCargo = $_SESSION['usuario_cargo'] ?? 'leitor';
$userNome = $_SESSION['usuario_nome'] ?? '';
$userFoto = $_SESSION['usuario_foto'] ?? 'img/avatar_admin.png';
$isRedator = in_array($userCargo, ['redator', 'revisor', 'administrador']);
$isRevisor = in_array($userCargo, ['revisor', 'administrador']);
$isAdmin = $userCargo === 'administrador';
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= e($noticia->getTitulo()) ;?> - Jornal Atlas</title>

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
                <a href="https://www.facebook.com" target="_blank" rel="noopener noreferrer" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="https://www.instagram.com" target="_blank" rel="noopener noreferrer" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                <a href="https://www.twitter.com" target="_blank" rel="noopener noreferrer" aria-label="Twitter"><i class="fa-brands fa-x-twitter"></i></a>
                <a href="https://www.youtube.com" target="_blank" rel="noopener noreferrer" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a>
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
            <a href="<?= url('/') ;?>">
                <img src="<?= asset('img/atlas.png') ;?>" alt="Jornal Atlas">
            </a>
        </div>

        <div class="header-buttons">
            <?php if ($userLogado): ?>
            <div class="logged-user-info" style="cursor:pointer" onclick="window.location='<?= url('/perfil') ;?>'">
                <img src="<?= asset($userFoto) ;?>" alt="Foto de perfil" class="user-avatar">
                <div class="user-details">
                    <span class="user-name"><?= e($userNome) ;?></span>
                    <span class="user-role-label"><?= ucfirst(e($userCargo)) ;?></span>
                </div>
                <a href="<?= url('/logout') ;?>" class="btn-logout-icon" title="Sair do sistema"><i
                        class="fa-solid fa-right-from-bracket"></i></a>
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

    <!-- CONTEUDO DA NOTICIA -->
    <main class="noticia-pagina">

        <div class="noticia-container">

            <a href="<?= url('/') ;?>" class="noticia-voltar">
                <i class="fa-solid fa-arrow-left"></i> Voltar para a Home
            </a>

            <article class="noticia-conteudo">

                <a href="<?= url('/categoria/' . urlencode($noticia->getCategoria())) ;?>" class="noticia-categoria"
                    style="text-decoration:none;"><?= e($noticia->getCategoria()) ;?></a>

                <span class="noticia-secao">
                    <i class="fa-regular fa-folder"></i> <?= e($noticia->getSecao()) ;?>
                </span>

                <h1 class="noticia-titulo"><?= e($noticia->getTitulo()) ;?></h1>

                <div class="noticia-meta">
                    <span class="noticia-autor">
                        <i class="fa-solid fa-user-pen"></i>
                        <?= e($autor->getNome()) ;?>
                    </span>
                    <span class="noticia-data">
                        <i class="fa-regular fa-calendar"></i>
                        Publicado em <?= format_date($noticia->getDataPublicacao(), 'd/m/Y \à\s H:i') ;?>
                    </span>
                    <?php if ($noticia->getDataEdicao()): ?>
                    <span class="noticia-data">
                        <i class="fa-regular fa-pen-to-square"></i>
                        Atualizado em <?= format_date($noticia->getDataEdicao(), 'd/m/Y \à\s H:i') ;?>
                    </span>
                    <?php endif; ?>
                    <button type="button" class="btn-compartilhar" data-share-title="<?= e($noticia->getTitulo()) ;?>">
                        <i class="fa-solid fa-share-nodes"></i> Compartilhar
                    </button>
                </div>

                <?php if ($noticia->getImagem()): ?>
                <div class="noticia-imagem-principal">
                    <img src="<?= asset('img/' . $noticia->getImagem()) ;?>" alt="<?= e($noticia->getTitulo()) ;?>">
                </div>
                <?php endif; ?>

                <div class="noticia-resumo">
                    <?= e($noticia->getResumo()) ;?>
                </div>

                <div class="noticia-texto">
                    <?= $noticia->getConteudo() ;?>
                </div>

            </article>

        </div>

    </main>

    <!-- RELACIONADAS -->
    <?php
$relacionadasFiltradas = array_values(array_filter($relacionadas, fn($r) => $r->getId() !== $noticia->getId()));
    $relacionadasPaginas = array_chunk($relacionadasFiltradas, 4);
$relacionadasTotal = count($relacionadasPaginas);
?>

    <?php if (count($relacionadasFiltradas) > 0): ?>
    <section class="secao">
        <h2>Mais notícias</h2>

        <div class="section-carousel" id="carousel-relacionadas">
            <div class="section-carousel-viewport">
                <?php foreach ($relacionadasPaginas as $pi => $pagina): ?>
                <div class="section-carousel-page <?= $pi === 0 ? 'active' : '' ;?>">
                    <div class="cards">
                        <?php foreach ($pagina as $rel): ?>
                        <a href="<?= url('/noticia/' . $rel->getId()) ;?>" class="card card-link">
                            <div class="card-img-wrapper">
                                <img src="<?= asset('img/' . $rel->getImagem()) ;?>" alt="<?= e($rel->getTitulo()) ;?>">
                            </div>
                            <div class="card-body">
                                <h3><?= e($rel->getTitulo()) ;?></h3>
                                <p><?= e($rel->getResumo()) ;?></p>
                            </div>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <?php if ($relacionadasTotal > 1): ?>
            <div class="section-carousel-controls">
                <button class="section-carousel-btn section-carousel-prev" data-carousel="carousel-relacionadas" aria-label="Anterior">
                    <i class="fa-solid fa-arrow-left"></i>
                </button>
                <div class="section-carousel-dots">
                    <?php for ($d = 0; $d < $relacionadasTotal; $d++): ?>
                    <span class="section-dot <?= $d === 0 ? 'active' : '' ;?>" data-carousel="carousel-relacionadas" data-index="<?= $d ;?>"></span>
                    <?php endfor; ?>
                </div>
                <button class="section-carousel-btn section-carousel-next" data-carousel="carousel-relacionadas" aria-label="Próximo">
                    <i class="fa-solid fa-arrow-right"></i>
                </button>
            </div>
            <?php endif; ?>
        </div>

    </section>
    <?php endif; ?>

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
                    <a href="https://www.facebook.com" target="_blank" rel="noopener noreferrer" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="https://www.instagram.com" target="_blank" rel="noopener noreferrer" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                    <a href="https://www.twitter.com" target="_blank" rel="noopener noreferrer" aria-label="Twitter"><i class="fa-brands fa-x-twitter"></i></a>
                    <a href="https://www.youtube.com" target="_blank" rel="noopener noreferrer" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a>
                </div>
            </div>

            <div class="footer-links-col">
                <h4>NAVEGAÇÃO</h4>
                <div class="links-grid">
                    <a class="footer-link-item" href="<?= url('/categoria/' . urlencode('Política')) ;?>">Política</a>
                    <a class="footer-link-item" href="<?= url('/categoria/' . urlencode('Economia')) ;?>">Economia</a>
                    <a class="footer-link-item" href="<?= url('/categoria/' . urlencode('Esportes')) ;?>">Esportes</a>
                    <a class="footer-link-item" href="<?= url('/categoria/' . urlencode('Cultura')) ;?>">Cultura</a>
                    <a class="footer-link-item" href="<?= url('/categoria/' . urlencode('Mundo')) ;?>">Mundo</a>
                    <a class="footer-link-item" href="<?= url('/categoria/' . urlencode('Tecnologia')) ;?>">Tecnologia</a>
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