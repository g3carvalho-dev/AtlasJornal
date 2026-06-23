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
    <title>Sobre nós - Jornal Atlas</title>
    <link rel="icon" type="image/png" href="<?= asset('img/atlas.fav.png') ;?>">
    <link rel="stylesheet" href="<?= asset('css/style.css') ;?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>

<body>
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

    <header>
        <div class="search-box">
            <i class="fa-solid fa-magnifying-glass"></i>
            <form action="<?= url('/busca') ;?>" method="GET">
                <input type="hidden" name="url" value="busca">
                <input type="text" name="q" placeholder="Buscar notícias...">
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

    <main class="sobre-pagina">
        <section class="sobre-hero">
            <span class="categoria">INSTITUCIONAL</span>
            <h1>Sobre o Jornal Atlas</h1>
            <p>Um jornal acadêmico feito para treinar informação clara, visual organizado e compromisso com bons textos.</p>
        </section>

        <section class="sobre-conteudo">
            <div class="sobre-texto">
                <h2>Nossa história</h2>
                <p>O Jornal Atlas nasceu como um projeto acadêmico.</p>
                <p>O nome Atlas foi escolhido porque lembra mapas, caminhos e contexto. Assim como um atlas ajuda alguém a se localizar no mundo, o jornal busca apresentar assuntos importantes de forma direta, com linguagem acessível e espaço para várias editorias.</p>
            </div>

            <aside class="sobre-card">
                <i class="fa-regular fa-newspaper"></i>
                <h3>O que buscamos</h3>
                <p>Informar com clareza, praticar jornalismo responsável e transformar aprendizado em uma experiência real de site.</p>
            </aside>
        </section>

        <section class="sobre-valores">
            <article>
                <i class="fa-solid fa-magnifying-glass-chart"></i>
                <h3>Contexto</h3>
                <p>Notícias organizadas para ajudar o leitor a entender o assunto sem complicação.</p>
            </article>
            <article>
                <i class="fa-solid fa-pen-nib"></i>
                <h3>Clareza</h3>
                <p>Textos simples, objetivos e pensados para uma leitura rápida no dia a dia.</p>
            </article>
            <article>
                <i class="fa-solid fa-user-check"></i>
                <h3>Responsabilidade</h3>
                <p>Um fluxo de revisão que simula o cuidado editorial antes da publicação.</p>
            </article>
        </section>
    </main>

    <footer>
        <div class="footer-container">
            <div class="footer-brand">
                <div class="footer-logo"><img src="<?= asset('img/atlas.png') ;?>" alt="Jornal Atlas"></div>
                <p class="footer-tagline">Informação com profundidade, contexto e credibilidade para entender o mundo.</p>
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
                    <a class="footer-link-item" href="<?= url('/categoria/' . urlencode('POLÍTICA')) ;?>">Política</a>
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

    <script src="<?= asset('js/script.js') ;?>"></script>
    <script>
    const data = new Date();
    const diasSemana = ["Domingo", "Segunda-feira", "Terça-feira", "Quarta-feira", "Quinta-feira", "Sexta-feira", "Sábado"];
    const meses = ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];
    document.getElementById("data-atual").textContent =
        `${diasSemana[data.getDay()]}, ${data.getDate()} de ${meses[data.getMonth()]} de ${data.getFullYear()}`;
    </script>
</body>

</html>
