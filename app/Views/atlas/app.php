<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Jornal Atlas</title>

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
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
            <img src="img/atlas.png" alt="Jornal Atlas">
        </div>

        <div class="header-buttons">
            <button class="btn-login">Entrar</button>
            <button class="btn-cadastro">Cadastrar</button>
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

            <article class="carousel-slide active">
                <div class="hero-image">
                    <img src="img/urna.jpg" alt="Urna eletrônica exibida em evento do Tribunal Regional Eleitoral do Rio de Janeiro (TRE-RJ), no Rio">
                </div>
                <div class="hero-content">
                    <span class="categoria">POLÍTICA</span>
                    <h1>Impulsionamento digital, adesivos, peças na TV: veja onde partidos devem gastar os R$ 4,9 bilhões do Fundo Eleitoral</h1>
                    <p>TSE distribuirá dinheiro a 30 partidos. Em 2022, o fundo bancou 87,9% das despesas dos presidenciáveis; despesas com TV e impulsionamento lideraram gastos.</p>
                    <button class="btn-materia">LER MATÉRIA COMPLETA</button>
                </div>
            </article>

            <article class="carousel-slide">
                <div class="hero-image">
                    <img src="img/copa.jpg" alt="Araújo marcou o gol do Uruguai na Copa do Mundo">
                </div>
                <div class="hero-content">
                    <span class="categoria">ESPORTES</span>
                    <h1>Copa: Uruguai desperta no 2º tempo e busca o empate contra a Arábia Saudita</h1>
                    <p>Apesar de sair atrás no placar, equipe de Bielsa conseguiu se recuperar e garantir o 1 a 1 em Miami; por pouco, não virou.</p>
                    <button class="btn-materia">LER MATÉRIA COMPLETA</button>
                </div>
            </article>

            <article class="carousel-slide">
                <div class="hero-image">
                    <img src="img/exame.jpg" alt="Tecnologia permite rastreio do câncer de mama pelo exame de sangue">
                </div>
                <div class="hero-content">
                    <span class="categoria">SAÚDE</span>
                    <h1>SUS incorpora novo tratamento para leucemia mieloide aguda em adultos</h1>
                    <p>Combinação de venetoclax e azacitidina será oferecida a adultos recém-diagnosticados com a doença; Ministério da Saúde tem até 180 dias para disponibilizar terapia na rede pública.</p>
                    <button class="btn-materia">LER MATÉRIA COMPLETA</button>
                </div>
            </article>

            <article class="carousel-slide">
                <div class="hero-image">
                    <img src="img/governo.jpg" alt="Foto do Palácio do Congresso Nacional em Brasília, onde está sendo debatida a reforma tributária e a taxação de compras internacionais.">
                </div>
                <div class="hero-content">
                    <span class="categoria">ECONOMIA</span>
                    <h1>'Taxa das blusinhas': governo volta a tributar compras internacionais de baixo valor em 2027, mas com imposto e alíquota diferentes</h1>
                    <p>No lugar do imposto de importação de 20%, será cobrado imposto federal sobre consumo criado na reforma tributária. Valor será definido no fim do ano; Fazenda não comenta.</p>
                    <button class="btn-materia">LER MATÉRIA COMPLETA</button>
                </div>
            </article>

        </div>

        <div class="carousel-controls">
            <div class="carousel-indicators">
                <span class="dot active" onclick="currentSlide(0)" aria-label="Acessar slide 1"></span>
                <span class="dot" onclick="currentSlide(1)" aria-label="Acessar slide 2"></span>
                <span class="dot" onclick="currentSlide(2)" aria-label="Acessar slide 3"></span>
                <span class="dot" onclick="currentSlide(3)" aria-label="Acessar slide 4"></span>
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

            <article class="card">
                <img src="img/noticia1.jpg" alt="Pescadores sendo autuados em local proibido">
                <h3>Pesca em local proibido termina com apreensão 85 kg de peixes e multa de R$ 5,7 mil no interior de SP</h3>
                <p>Ocorrência foi registrada nesta segunda-feira (15), próximo à Cachoeira Salto Botelho, em Lucélia (SP). O pescado apreendido foi doado ao Lar São Vicente de Paulo do município.</p>
            </article>

            <article class="card">
                <img src="img/noticia2.jpg" alt="Romeu Zema (no centro da imagem) participa de encontro no Rio">
                <h3>No Rio, Zema minimiza fala de Eduardo Bolsonaro sobre rompimento com o Novo e reafirma críticas a Flávio</h3>
                <p>Zema disse que não muda "nada" do que afirmou anteriormente sobre a relação de Flávio Bolsonaro e Daniel Vorcaro.</p>
            </article>

            <article class="card">
                <img src="img/noticia3.jpg" alt="A Alstroemeria durantei foi descrita pela ciência em 2026 e ocorre no Sul do Brasil">
                <h3>Nova espécie de flor descoberta no Brasil já nasce ameaçada de extinção</h3>
                <p>Registro feito durante uma trilha em Santa Catarina levou pesquisadores a identificar planta inédita para a ciência.</p>
            </article>

            <article class="card">
                <img src="img/noticia4.jpg" alt="Réplica de dinossauro brasileiro no Museu Nacional">
                <h3> Museu Nacional ganha réplica de dinossauro brasileiro com 15 metros</h3>
                <p>Oxalaia quilombensis viveu no Maranhão há 95 milhões de anos.</p>
            </article>

        </div>

    </section>

    <!-- INTERNACIONAL -->

    <section class="secao">

        <h2>Internacional</h2>

        <div class="cards">

            <article class="card">
                <img src="img/noticia5.jpg" alt="Foto de 15 de dezembro de 2016 de um restaurante da Pizza Hut, em Nova Orleans, EUA.">
                <h3>Pizza Hut será vendida por US$ 2,7 bilhões após anos de queda nas vendas e fechamento de lojas</h3>
                <p>Em fevereiro, a controladora Yum Brands disse que já estudava vender a rede e fechar 250 restaurantes nos EUA, em meio ao aumento da concorrência e lojas consideradas ultrapassadas.</p>
            </article>

            <article class="card">
                <img src="img/noticia6.jpg" alt="Mehdi Torabi (à frente) durante o aquecimento da partida contra a Nova Zelândia.">
                <h3>Irã na Copa: após empatar com Nova Zelândia, seleção iraniana enfrenta entraves ao deixar os EUA </h3>
                <p>Capitão da seleção, Mehdi Taremi, e um auxiliar da equipe foram retidos no aeroporto de Los Angeles, onde o time jogou contra a Nova Zelândia. Jogo terminou com empate de 2 a 2. Iranianos já retornaram ao México, onde estão hospedados, mas jogarão nos EUA nas 2 próximas partidas. </p>
            </article>

            <article class="card">
                <img src="img/noticia7.jpg" alt="Keiko Fujimori e Roberto Sánchez">
                <h3>Eleições no Peru: com 99% das urnas apuradas, Keiko lidera disputa contra Sánchez</h3>
                <p>Com mais de 99% das urnas apuradas, os candidatos Roberto Sánchez e Keiko Fujimori ainda registram diferença de menos de 1 ponto percentual.</p>
            </article>

            <article class="card">
                <img src="img/noticia8.jpg" alt="">
                <h3>G7 amplia pressão sobre Rússia e Trump promete agir por acordo para encerrar guerra na Ucrânia</h3>
                <p>Os líderes do G7 defenderam nesta terça-feira (16) em Evian, na França, o aumento da pressão sobre a Rússia para encerrar a guerra na Ucrânia, com novas sanções e reforço militar a Kiev. O presidente norte-americano, Donald Trump, prometeu intensificar sua atuação para um acordo e se reuniu com Volodymyr Zelensky.</p>
            </article>

        </div>

    </section>

    <!-- FOOTER -->

    <footer>
        <div class="footer-container">

            <div class="footer-brand">
                <div class="footer-logo">
                    <img src="img/atlas.png" alt="Jornal Atlas">
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
        const diasSemana = ["Domingo", "Segunda-feira", "Terça-feira", "Quarta-feira", "Quinta-feira", "Sexta-feira", "Sábado"];
        const meses = ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];
        document.getElementById("data-atual").textContent = `${diasSemana[data.getDay()]}, ${data.getDate()} de ${meses[data.getMonth()]} de ${data.getFullYear()}`;
    </script>

    <script>
        // Controle do carrossel
        let currentSlideIndex = 0;
        let carrosselTimer = null;
        const TEMPO_SLIDE = 4000; // Tempo entre os slides (4 segundos)

        const slides = document.querySelectorAll('.carousel-slide');
        const dots = document.querySelectorAll('.carousel-indicators .dot');

        function showSlide(index) {
            if (index >= slides.length) {
                currentSlideIndex = 0;
            } else if (index < 0) {
                currentSlideIndex = slides.length - 1;
            } else {
                currentSlideIndex = index;
            }

            slides.forEach(slide => slide.classList.remove('active'));
            dots.forEach(dot => dot.classList.remove('active'));

            if (slides[currentSlideIndex]) slides[currentSlideIndex].classList.add('active');
            if (dots[currentSlideIndex]) dots[currentSlideIndex].classList.add('active');
        }

        function changeSlide(direction) {
            pararAutoplay();
            showSlide(currentSlideIndex + direction);
            iniciarAutoplay();
        }

        function currentSlide(index) {
            pararAutoplay();
            showSlide(index);
            iniciarAutoplay();
        }

        function iniciarAutoplay() {
            if (!carrosselTimer) {
                carrosselTimer = setInterval(() => {
                    showSlide(currentSlideIndex + 1);
                }, TEMPO_SLIDE);
            }
        }

        function pararAutoplay() {
            if (carrosselTimer) {
                clearInterval(carrosselTimer);
                carrosselTimer = null;
            }
        }

        // Inicia o carrossel quando a página terminar de carregar
        window.onload = function() {
            iniciarAutoplay();
        };
    </script>
</body>

</html>

</body>

</html>