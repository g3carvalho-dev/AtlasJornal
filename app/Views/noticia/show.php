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
            <a href="#">Sobre nós</a>
            <a href="#">Anuncie</a>
            <a href="#">Contato</a>
            <div class="social-icons">
                <a href="#" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="#" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                <a href="#" aria-label="Twitter"><i class="fa-brands fa-x-twitter"></i></a>
                <a href="#" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a>
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
            <a href="<?= url('/') ;?>"><img src="<?= asset('img/atlas.png') ;?>" alt="Jornal Atlas"></a>
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

    <!-- CONTEUDO DA NOTICIA -->
    <main class="noticia-pagina">

        <div class="noticia-container">

            <a href="<?= url('/') ;?>" class="noticia-voltar">
                <i class="fa-solid fa-arrow-left"></i> Voltar para a Home
            </a>

            <article class="noticia-conteudo">

                <span class="noticia-categoria"><?= e($noticia->getCategoria()) ;?></span>

                <h1 class="noticia-titulo"><?= e($noticia->getTitulo()) ;?></h1>

                <div class="noticia-meta">
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
                    <?= nl2br(e($noticia->getConteudo())) ;?>
                </div>

            </article>

        </div>

    </main>

    <!-- RELACIONADAS -->
    <?php
$relacionadasFiltradas = array_filter($relacionadas, fn($r) => $r->getId() !== $noticia->getId());
$relacionadasFiltradas = array_slice($relacionadasFiltradas, 0, 3);
?>

    <?php if (count($relacionadasFiltradas) > 0): ?>
    <section class="secao">
        <h2>Mais notícias</h2>
        <div class="cards">
            <?php foreach ($relacionadasFiltradas as $rel): ?>
            <a href="<?= url('/noticia/' . $rel->getId()) ;?>" class="card card-link">
                <img src="<?= asset('img/' . $rel->getImagem()) ;?>" alt="<?= e($rel->getTitulo()) ;?>">
                <h3><?= e($rel->getTitulo()) ;?></h3>
                <p><?= e($rel->getResumo()) ;?></p>
            </a>
            <?php endforeach; ?>
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