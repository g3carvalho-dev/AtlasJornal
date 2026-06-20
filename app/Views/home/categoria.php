<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ======================================================================
// FUNÇÕES DE SIMULAÇÃO (Evita erros se rodar isolado no XAMPP)
// ======================================================================
if (!function_exists('asset')) { function asset($p) { return $p; } }
if (!function_exists('url')) { function url($p) { return $p; } }
if (!function_exists('e')) { function e($s) { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); } }

// 1. PEGAR A CATEGORIA DA URL (Ex: categoria.php?nome=Política)
// Se não vier nenhuma na URL, assume "Geral" como padrão
$categoria_atual = isset($_GET['nome']) ? $_GET['nome'] : 'Geral';

// 2. SIMULAÇÃO DE BANCO DE DADOS (Se as variáveis do seu colega não estiverem prontas)
if (!isset($noticias_categoria) || !is_array($noticias_categoria)) {
    class MockNoticiaCategoria {
        private $id; private $titulo; private $resumo; private $imagem; private $cat;
        public function __construct($id, $titulo, $resumo, $imagem, $cat) {
            $this->id = $id; $this->titulo = $titulo; $this->resumo = $resumo; $this->imagem = $imagem; $this->cat = $cat;
        }
        public function getId() { return $this->id; }
        public function getTitulo() { return $this->titulo; }
        public function getResumo() { return $this->resumo; }
        public function getImagem() { return $this->imagem; }
        public function getCategoria() { return $this->cat; }
    }

    // Criando algumas notícias fictícias para preencher o layout da categoria
    $noticias_categoria = [
        new MockNoticiaCategoria(1, "Primeira grande notícia de " . $categoria_atual, "Este é o resumo da primeira notícia de teste para a categoria que você acabou de clicar.", "noticia1.jpg", $categoria_atual),
        new MockNoticiaCategoria(2, "Segunda manchete importante sobre " . $categoria_atual, "Mais um resumo de exemplo para preencher o grid de blocos de notícias da categoria.", "noticia2.jpg", $categoria_atual),
        new MockNoticiaCategoria(3, "Análise profunda: O futuro de " . $categoria_atual, "Discussões e novidades impactando o cenário regional e nacional esta semana.", "noticia3.jpg", $categoria_atual),
        new MockNoticiaCategoria(4, "Dados consolidados mostram mudanças em " . $categoria_atual, "Estatísticas atualizadas revelam novos comportamentos do setor no mercado.", "noticia4.jpg", $categoria_atual),
    ];
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e(mb_strtoupper($categoria_atual)) ;?> - Jornal Atlas</title>
    <link rel="stylesheet" href="<?= asset('css/style.css') ;?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>

<body>

    <div class="topbar">
        <div class="topbar-left" id="data-atual"></div>
        <div class="topbar-right">
            <a href="#">Sobre nós</a><a href="#">Anuncie</a><a href="#">Contato</a>
            <div class="social-icons">
                <a href="#" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="#" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                <a href="#" aria-label="Twitter"><i class="fa-brands fa-x-twitter"></i></a>
                <a href="#" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a>
            </div>
        </div>
    </div>

    <header>
        <div class="search-box">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" placeholder="Buscar notícias...">
        </div>
        <div class="logo">
            <a href="app2.php"><img src="<?= asset('img/atlas.png') ;?>" alt="Jornal Atlas"></a>
        </div>
        <div class="header-buttons">
            <?php if (isset($_SESSION['usuario_logado']) && $_SESSION['usuario_logado'] === true): ?>
                <div class="logged-user-info">
                    <img src="<?= asset($_SESSION['usuario_foto']) ;?>" alt="Foto de perfil" class="user-avatar" style="width: 40px; height: 40px; border-radius: 50%; border: 2px solid #d4af37;">
                    <div class="user-details">
                        <span class="user-name"><?= e($_SESSION['usuario_nome']) ;?></span>
                        <span class="user-role-label" style="color: #d4af37; font-size: 0.8rem;"><?= ucfirst(e($_SESSION['usuario_cargo'])) ;?></span>
                    </div>
                </div>
            <?php else: ?>
                <a href="<?= url('/login') ;?>" class="btn-login">Entrar</a>
                <a href="<?= url('/cadastro') ;?>" class="btn-cadastro">Cadastrar</a>
            <?php endif; ?>
        </div>
    </header>

    <nav>
        <ul>
            <li><a href="categoria.php?nome=Politica">Política</a></li>
            <li><a href="categoria.php?nome=Tecnologia">Tecnologia</a></li>
            <li><a href="categoria.php?nome=Economia">Economia</a></li>
            <li><a href="categoria.php?nome=Esportes">Esportes</a></li>
            <li><a href="categoria.php?nome=Mundo">Mundo</a></li>
            <li><a href="categoria.php?nome=Cultura">Cultura</a></li>
        </ul>
    </nav>

    <main class="secao" style="padding: 40px 5%; min-height: 60vh;">
        
        <div class="category-header" style="border-bottom: 3px solid #081223; margin-bottom: 30px; padding-bottom: 10px;">
            <span style="font-family: 'Inter', sans-serif; font-size: 0.9rem; color: #d4af37; font-weight: 600; letter-spacing: 2px;">PROCURANDO POR:</span>
            <h2 style="margin: 5px 0 0 0; font-size: 2.5rem; font-family: 'Playfair Display', serif; color: #081223; text-transform: uppercase;">
                <?= e($categoria_atual) ;?>
            </h2>
        </div>

        <div class="cards">
            <?php if (count($noticias_categoria) > 0): ?>
                <?php foreach ($noticias_categoria as $noticia): ?>
                <div class="card-wrapper">
                    <a href="<?= url('/noticia/' . $noticia->getId()) ?>" class="card card-link">
                        <img src="<?= asset('img/' . $noticia->getImagem()) ;?>" alt="<?= e($noticia->getTitulo()) ;?>">
                        <h3><?= e($noticia->getTitulo()) ;?></h3>
                        <p><?= e($noticia->getResumo()) ;?></p>
                    </a>
                    
                    <?php if (isset($_SESSION['usuario_logado']) && $_SESSION['usuario_logado'] === true && in_array($_SESSION['usuario_cargo'], ['revisor', 'administrador'])): ?>
                        <div class="card-admin-footer" style="margin-top: 10px; border-top: 1px solid #eee; padding-top: 8px; display: flex; justify-content: flex-end;">
                            <button class="btn-card-manage" style="border: 1px solid #ccc; padding: 4px 10px; border-radius: 4px; font-size: 0.75rem; cursor: pointer;"><i class="fa-solid fa-gear"></i> Administrar</button>
                        </div>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="font-family: 'Inter', sans-serif; color: #666;">Nenhuma notícia publicada nesta categoria ainda.</p>
            <?php endif; ?>
        </div>

    </main>

    <footer>
        <div class="footer-container">
            <div class="footer-brand">
                <div class="footer-logo"><img src="img/atlas.png" alt="Jornal Atlas"></div>
                <p class="footer-tagline">Informação com profundidade, contexto e credibilidade para entender o mundo.</p>
            </div>
            <div class="footer-links-col">
                <h4>NAVEGAÇÃO</h4>
                <div class="links-grid">
                    <a class="footer-link-item" href="categoria.php?nome=Politica">Política</a>
                    <a class="footer-link-item" href="categoria.php?nome=Economia">Economia</a>
                    <a class="footer-link-item" href="categoria.php?nome=Esportes">Esportes</a>
                </div>
            </div>
            <div class="footer-newsletter">
                <h4>NEWSLETTER</h4>
                <p>Receba as principais notícias do dia no seu e-mail.</p>
                <form class="newsletter-form">
                    <input type="email" placeholder="Seu e-mail" required>
                    <button type="submit"><i class="fa-solid fa-paper-plane"></i></button>
                </form>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2026 Jornal Atlas. Todos os direitos reservados.</p>
        </div>
    </footer>

    <script>
    const data = new Date();
    const diasSemana = ["Domingo", "Segunda-feira", "Terça-feira", "Quarta-feira", "Quinta-feira", "Sexta-feira", "Sábado"];
    const meses = ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];
    document.getElementById("data-atual").textContent = `${diasSemana[data.getDay()]}, ${data.getDate()} de ${meses[data.getMonth()]} de ${data.getFullYear()}`;
    </script>
</body>
</html>