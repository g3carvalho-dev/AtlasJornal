<?php
if (session_status() === PHP_SESSION_NONE) session_start();

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
    <title><?= e(mb_strtoupper($categoriaAtual)) ;?> - Jornal Atlas</title>
    <link rel="stylesheet" href="<?= asset('css/style.css') ;?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>

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

    <header>
        <div class="search-box">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" placeholder="Buscar notícias...">
        </div>
        <div class="logo">
            <a href="<?= url('/') ;?>"><img src="<?= asset('img/atlas.png') ;?>" alt="Jornal Atlas"></a>
        </div>
        <div class="header-buttons">
            <?php if ($userLogado): ?>
                <div class="logged-user-info">
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
            <?php
            $categoriasNav = [
                'Política' => 'POLÍTICA',
                'Tecnologia' => 'TECNOLOGIA',
                'Economia' => 'ECONOMIA',
                'Esportes' => 'ESPORTES',
                'Mundo' => 'MUNDO',
                'Cultura' => 'CULTURA',
                'Saúde' => 'SAÚDE',
                'Ciência' => 'CIÊNCIA',
            ];
            foreach ($categoriasNav as $label => $valor):
            ?>
                <li><a href="<?= url('/categoria/' . urlencode($valor)) ;?>" class="<?= $categoriaAtual === $valor ? 'active' : '' ;?>"><?= $label ;?></a></li>
            <?php endforeach; ?>
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
                            <strong>Revisar pendentes <span class="admin-badge">0</span></strong>
                            <span>Itens aguardando revisão</span>
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
                            <strong>Solicitações de cargo <span class="admin-badge badge-amber">0</span></strong>
                            <span>Analisar pedidos de colaboradores</span>
                        </div>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <main class="secao" style="padding: 40px 5%; min-height: 60vh;">

        <div class="category-header" style="border-bottom: 3px solid var(--azul); margin-bottom: 30px; padding-bottom: 10px;">
            <span style="font-size: 0.9rem; color: var(--dourado); font-weight: 600; letter-spacing: 2px;">PROCURANDO POR:</span>
            <h2 style="margin: 5px 0 0 0; font-size: 2.5rem; font-family: 'Playfair Display', serif; color: var(--azul); text-transform: uppercase;">
                <?= e($categoriaAtual) ;?>
            </h2>
        </div>

        <?php if (!empty($noticias)): ?>
            <div class="cards">
            <?php foreach ($noticias as $noticia): ?>
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
                        <a href="<?= url('/noticia/' . $noticia->getId() . '/editar') ;?>" class="btn-card-manage"><i class="fa-solid fa-gear"></i> Administrar</a>
                    </div>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="card" style="padding: 50px; text-align: center; max-width: 500px; margin: 0 auto;">
                <i class="fa-regular fa-newspaper" style="font-size: 40px; color: var(--dourado); margin-bottom: 15px; display: block;"></i>
                <p style="color: #666; font-size: 16px;">Nenhuma notícia publicada nesta categoria ainda.</p>
            </div>
        <?php endif; ?>

    </main>

    <footer>
        <div class="footer-container">
            <div class="footer-brand">
                <div class="footer-logo">
                    <img src="<?= asset('img/atlas.png') ;?>" alt="Jornal Atlas">
                </div>
                <p class="footer-tagline">Informação com profundidade, contexto e credibilidade para entender o mundo.</p>
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
                    <a class="footer-link-item" href="<?= url('/categoria/' . urlencode('TECNOLOGIA')) ;?>">Tecnologia</a>
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

    <script>
    const data = new Date();
    const diasSemana = ["Domingo", "Segunda-feira", "Terça-feira", "Quarta-feira", "Quinta-feira", "Sexta-feira", "Sábado"];
    const meses = ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];
    document.getElementById("data-atual").textContent = `${diasSemana[data.getDay()]}, ${data.getDate()} de ${meses[data.getMonth()]} de ${data.getFullYear()}`;
    </script>
</body>
</html>