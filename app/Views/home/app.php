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

    <title>Jornal Atlas</title>

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

                <a href="#" aria-label="Facebook">
                    <i class="fa-brands fa-facebook-f"></i>
                </a>

                <a href="#" aria-label="Instagram">
                    <i class="fa-brands fa-instagram"></i>
                </a>

                <a href="#" aria-label="Twitter">
                    <i class="fa-brands fa-x-twitter"></i>
                </a>

                <a href="#" aria-label="YouTube">
                    <i class="fa-brands fa-youtube"></i>
                </a>

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

            <li><a href="<?= url('/categoria/' . urlencode('POLÍTICA')) ;?>">Política</a></li>
            <li><a href="<?= url('/categoria/' . urlencode('TECNOLOGIA')) ;?>">Tecnologia</a></li>
            <li><a href="<?= url('/categoria/' . urlencode('ECONOMIA')) ;?>">Economia</a></li>
            <li><a href="<?= url('/categoria/' . urlencode('ESPORTES')) ;?>">Esportes</a></li>
            <li><a href="<?= url('/categoria/' . urlencode('MUNDO')) ;?>">Mundo</a></li>
            <li><a href="<?= url('/categoria/' . urlencode('CULTURA')) ;?>">Cultura</a></li>
            <li><a href="<?= url('/categoria/' . urlencode('SAÚDE')) ;?>">Saúde</a></li>
            <li><a href="<?= url('/categoria/' . urlencode('CIÊNCIA')) ;?>">Ciência</a></li>

        </ul>

    </nav>

    <!-- PAINEL ADMIN -->
    <?php if ($userLogado && $userCargo !== 'leitor'): ?>
    <div class="admin-panel-topbar">
        <div class="admin-actions-container">

            <?php if ($isRedator): ?>
            <a href="<?= url('/noticia/nova') ;?>" class="admin-btn-box">
                <i class="fa-solid fa-pen-to-square"></i>
                <div>
                    <strong>Escrever notícia</strong>
                    <span>Criar uma nova publicação</span>
                </div>
            </a>
            <?php endif; ?>

            <?php if ($isRevisor): ?>
            <a href="<?= url('/revisao') ;?>" class="admin-btn-box">
                <i class="fa-solid fa-list-check"></i>
                <div>
                    <strong>Revisar pendentes <span
                            class="admin-badge"><?= $isAdmin ? $pendentesRevisao : $meusPendentes ;?></span></strong>
                    <span><?= $isAdmin ? 'Todas as notícias pendentes' : 'Seus itens aguardando revisão' ;?></span>
                </div>
            </a>
            <?php endif; ?>

            <?php if ($isRedator): ?>
            <a href="<?= url('/noticia/minhas') ;?>" class="admin-btn-box">
                <i class="fa-solid fa-book-open"></i>
                <div>
                    <strong>Minhas notícias</strong>
                    <span>Gerenciar suas publicações</span>
                </div>
            </a>
            <?php endif; ?>

            <?php if ($isAdmin): ?>
            <a href="<?= url('/solicitacoes') ;?>" class="admin-btn-box">
                <i class="fa-solid fa-user-gear"></i>
                <div>
                    <strong>Solicitações de cargo <span
                            class="admin-badge badge-amber"><?= $solicitacoesPendentesCount ;?></span></strong>
                    <span>Analisar pedidos de colaboradores</span>
                </div>
            </a>
            <?php endif; ?>

            <?php if ($isRedator): ?>
            <a href="<?= url('/dashboard') ;?>" class="admin-btn-full-panel">
                <i class="fa-solid fa-chart-line"></i> Ver painel completo <i class="fa-solid fa-chevron-right"></i>
            </a>
            <?php endif; ?>

        </div>
    </div>

    <?php endif; ?>

    <!-- DESTAQUE -->

    <section class="hero">
        <div class="hero-carousel">

            <?php foreach ($hero as $i => $noticia): ?>
            <article class="carousel-slide <?= $i === 0 ? 'active' : '' ;?>">
                <div class="hero-image">
                    <img src="<?= asset('img/' . $noticia->getImagem()) ;?>" alt="<?= e($noticia->getTitulo()) ;?>">
                </div>
                <div class="hero-content">
                    <a href="<?= url('/categoria/' . urlencode($noticia->getCategoria())) ;?>" class="categoria"
                        style="text-decoration:none;"><?= e($noticia->getCategoria()) ;?></a>

                    <?php if (($userLogado && $isRedator && $noticia->getRedatorId() == ($_SESSION['usuario_id'] ?? 0)) || $isRevisor): ?>
                    <div class="inline-management-actions">
                        <?php if ($noticia->getRedatorId() == ($_SESSION['usuario_id'] ?? 0) || $isRevisor): ?>
                        <a href="<?= url('/noticia/' . $noticia->getId() . '/editar') ;?>" class="btn-inline-edit"><i
                                class="fa-solid fa-pen"></i> Editar</a>
                        <?php endif; ?>
                        <?php if ($isAdmin): ?>
                        <a href="<?= url('/admin/noticias?noticia=' . $noticia->getId()) ;?>"
                            class="btn-inline-admin"><i class="fa-solid fa-shield-halved"></i> Administrar</a>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>

                    <h1><?= e($noticia->getTitulo()) ;?></h1>
                    <p><?= e($noticia->getResumo()) ;?></p>
                    <a href="<?= url('/noticia/' . $noticia->getId()) ;?>" class="btn-materia">LER MATÉRIA COMPLETA</a>
                </div>
            </article>
            <?php endforeach; ?>

        </div>

        <div class="carousel-controls">
            <div class="carousel-indicators">
                <?php foreach ($hero as $i => $noticia): ?>
                <span class="dot <?= $i === 0 ? 'active' : '' ;?>" onclick="currentSlide(<?= $i ;?>)"
                    aria-label="Acessar slide <?= $i + 1 ;?>"></span>
                <?php endforeach; ?>
            </div>

            <div class="carousel-navigation">
                <button class="prev-btn" onclick="changeSlide(-1)" aria-label="Slide Anterior">
                    <i class="fa-solid fa-arrow-left"></i>
                </button>
                <button class="next-btn" onclick="changeSlide(1)" aria-label="Próximo Slide">
                    <i class="fa-solid fa-arrow-right"></i>
                </button>
            </div>
        </div>
    </section>

    <!-- NACIONAL -->

    <section class="secao">

        <h2>Nacional</h2>

        <div class="cards">

            <?php foreach ($nacional as $noticia): ?>
            <div class="card-wrapper">
                <a href="<?= url('/noticia/' . $noticia->getId()) ;?>" class="card card-link">
                    <div class="card-img-wrapper">
                        <img src="<?= asset('img/' . $noticia->getImagem()) ;?>" alt="<?= e($noticia->getTitulo()) ;?>">
                        <span class="card-categoria-tag"><?= e($noticia->getCategoria()) ;?></span>
                    </div>
                    <div class="card-body">
                        <h3><?= e($noticia->getTitulo()) ;?></h3>
                        <p><?= e($noticia->getResumo()) ;?></p>
                    </div>
                </a>

                <?php if ($userLogado && $isRevisor): ?>
                <div class="card-admin-footer">
                    <a href="<?= url('/noticia/' . $noticia->getId() . '/editar') ;?>" class="btn-card-manage"><i
                            class="fa-solid fa-gear"></i> Editar</a>
                </div>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>

        </div>

    </section>

    <!-- INTERNACIONAL -->

    <section class="secao">

        <h2>Internacional</h2>

        <div class="cards">

            <?php foreach ($internacional as $noticia): ?>
            <div class="card-wrapper">
                <a href="<?= url('/noticia/' . $noticia->getId()) ;?>" class="card card-link">
                    <div class="card-img-wrapper">
                        <img src="<?= asset('img/' . $noticia->getImagem()) ;?>" alt="<?= e($noticia->getTitulo()) ;?>">
                        <span class="card-categoria-tag"><?= e($noticia->getCategoria()) ;?></span>
                    </div>
                    <div class="card-body">
                        <h3><?= e($noticia->getTitulo()) ;?></h3>
                        <p><?= e($noticia->getResumo()) ;?></p>
                    </div>
                </a>

                <?php if ($userLogado && $isRevisor): ?>
                <div class="card-admin-footer">
                    <a href="<?= url('/noticia/' . $noticia->getId() . '/editar') ;?>" class="btn-card-manage"><i
                            class="fa-solid fa-gear"></i> Editar</a>
                </div>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>

        </div>

    </section>

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
                    <a class="footer-link-item" href="<?= url('/categoria/' . urlencode('POLÍTICA')) ;?>">Política</a>
                    <a class="footer-link-item" href="<?= url('/categoria/' . urlencode('ECONOMIA')) ;?>">Economia</a>
                    <a class="footer-link-item" href="<?= url('/categoria/' . urlencode('ESPORTES')) ;?>">Esportes</a>
                    <a class="footer-link-item" href="<?= url('/categoria/' . urlencode('CULTURA')) ;?>">Cultura</a>
                    <a class="footer-link-item" href="<?= url('/categoria/' . urlencode('MUNDO')) ;?>">Mundo</a>
                    <a class="footer-link-item"
                        href="<?= url('/categoria/' . urlencode('TECNOLOGIA')) ;?>">Tecnologia</a>
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

    <!-- SCRIPT -->
    <script src="<?= asset('js/script.js') ;?>"></script>
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
</body>

</html>