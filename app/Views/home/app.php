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
            <input type="text" placeholder="Buscar notícias...">
        </div>

        <div class="logo">
            <img src="<?= asset('img/atlas.png') ;?>" alt="Jornal Atlas">
        </div>

        <div class="header-buttons">
            <a href="<?= url('/login') ;?>" class="btn-login">Entrar</a>
            <a href="<?= url('/cadastro') ;?>" class="btn-cadastro">Cadastrar</a>
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

    <!-- DESTAQUE -->

    <section class="hero">
        <div class="hero-carousel">

            <?php foreach ($hero as $i => $noticia): ?>
            <article class="carousel-slide <?= $i === 0 ? 'active' : '' ;?>">
                <div class="hero-image">
                    <img src="<?= asset('img/' . $noticia->getImagem()) ;?>" alt="<?= e($noticia->getTitulo()) ;?>">
                </div>
                <div class="hero-content">
                    <span class="categoria"><?= e($noticia->getCategoria()) ;?></span>
                    <h1><?= e($noticia->getTitulo()) ;?></h1>
                    <p><?= e($noticia->getResumo()) ;?></p>
                    <button class="btn-materia">LER MATÉRIA COMPLETA</button>
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
            <article class="card">
                <img src="<?= asset('img/' . $noticia->getImagem()) ;?>" alt="<?= e($noticia->getTitulo()) ;?>">
                <h3><?= e($noticia->getTitulo()) ;?></h3>
                <p><?= e($noticia->getResumo()) ;?></p>
            </article>
            <?php endforeach; ?>

        </div>

    </section>

    <!-- INTERNACIONAL -->

    <section class="secao">

        <h2>Internacional</h2>

        <div class="cards">

            <?php foreach ($internacional as $noticia): ?>
            <article class="card">
                <img src="<?= asset('img/' . $noticia->getImagem()) ;?>" alt="<?= e($noticia->getTitulo()) ;?>">
                <h3><?= e($noticia->getTitulo()) ;?></h3>
                <p><?= e($noticia->getResumo()) ;?></p>
            </article>
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

    <!-- SCRIPT -->
    <script src="<?= asset('js/script.js') ;?>"></script>
    <script>
    const data = new Date();
    const diasSemana = ["Domingo", "Segunda-feira", "Terça-feira", "Quarta-feira", "Quinta-feira", "Sexta-feira",
        "Sábado"
    ];
    const meses = ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro",
        "Novembro", "Dezembro"
    ];
    document.getElementById("data-atual").textContent =
        `${diasSemana[data.getDay()]}, ${data.getDate()} de ${meses[data.getMonth()]} de ${data.getFullYear()}`;
    </script>
</body>

</html>