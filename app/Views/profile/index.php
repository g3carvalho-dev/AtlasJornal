<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<?php
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
    <title>Meu Perfil - Jornal Atlas</title>
    <link rel="stylesheet" href="<?= asset('css/style.css') ;?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Inter:wght@300;400;500;600&display=swap"
        rel="stylesheet">
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
            <div class="logged-user-info">
                <img src="<?= asset($userFoto) ;?>" alt="Foto de perfil" class="user-avatar">
                <div class="user-details">
                    <span class="user-name"><?= e($userNome) ;?></span>
                    <span class="user-role-label"><?= ucfirst(e($userCargo)) ;?></span>
                </div>
                <a href="<?= url('/logout') ;?>" class="btn-logout-icon" title="Sair"><i
                        class="fa-solid fa-right-from-bracket"></i></a>
            </div>
            <?php else: ?>
            <a href="<?= url('/login') ;?>" class="btn-login">Entrar</a>
            <a href="<?= url('/cadastro') ;?>" class="btn-cadastro">Cadastrar</a>
            <?php endif; ?>
        </div>
    </header>

    <nav>
        <ul>
            <?php $cats = ['Política' => 'POLÍTICA', 'Tecnologia' => 'TECNOLOGIA', 'Economia' => 'ECONOMIA', 'Esportes' => 'ESPORTES', 'Mundo' => 'MUNDO', 'Cultura' => 'CULTURA', 'Saúde' => 'SAÚDE', 'Ciência' => 'CIÊNCIA'];foreach ($cats as $l => $v): ?>
            <li><a href="<?= url('/categoria/' . urlencode($v)) ;?>"><?= $l ;?></a></li>
            <?php endforeach; ?>
        </ul>
    </nav>

    <main class="perfil-pagina">
        <div class="perfil-container">

            <div class="perfil-header">
                <img src="<?= asset($usuario->getFoto()) ;?>" alt="Foto de perfil" class="perfil-avatar">
                <div class="perfil-header-info">
                    <h1><?= e($usuario->getNome()) ;?></h1>
                    <span
                        class="perfil-cargo cargo-badge cargo-<?= strtolower($usuario->getCargo()) ;?>"><?= strtoupper($usuario->getCargo()) ;?></span>
                    <span class="perfil-email"><?= e($usuario->getEmail()) ;?></span>
                </div>
            </div>

            <?php if ($sucesso): ?>
            <div class="alert-sucesso"><i class="fa-solid fa-circle-check"></i> <?= e($sucesso) ;?></div>
            <?php endif; ?>

            <?php if ($erro): ?>
            <div class="alert-erro"><i class="fa-solid fa-circle-exclamation"></i> <?= e($erro) ;?></div>
            <?php endif; ?>

            <div class="perfil-layout">
                <div class="perfil-form-section">
                    <h2><i class="fa-solid fa-user-pen"></i> Informações Pessoais</h2>
                    <form method="POST" action="<?= url('/perfil') ;?>" class="perfil-form">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="nome">Nome completo</label>
                                <input type="text" id="nome" name="nome" value="<?= e($usuario->getNome()) ;?>"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="email">E-mail</label>
                                <input type="email" id="email" name="email" value="<?= e($usuario->getEmail()) ;?>"
                                    required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="nascimento">Data de nascimento</label>
                                <input type="date" id="nascimento" name="nascimento"
                                    value="<?= $usuario->getDataNascimento()->format('Y-m-d') ;?>" required>
                            </div>
                            <div class="form-group">
                                <label for="formacao">Formação</label>
                                <input type="text" id="formacao" name="formacao"
                                    value="<?= e($usuario->getFormacao()) ;?>"
                                    placeholder="Ex: Jornalismo, Comunicação Social...">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="assinatura">Assinatura (nome para publicação)</label>
                            <input type="text" id="assinatura" name="assinatura"
                                value="<?= e($usuario->getAssinatura()) ;?>" placeholder="Ex: João Silva">
                        </div>
                        <button type="submit" class="perfil-btn salvar">
                            <i class="fa-solid fa-check"></i> Salvar Alterações
                        </button>
                    </form>
                </div>

                <div class="perfil-cargo-section">
                    <h2><i class="fa-solid fa-shield-halved"></i> Cargo</h2>

                    <div class="perfil-cargo-atual">
                        <span class="perfil-cargo-label">Cargo atual</span>
                        <span
                            class="perfil-cargo-valor cargo-badge cargo-<?= strtolower($usuario->getCargo()) ;?>"><?= strtoupper($usuario->getCargo()) ;?></span>
                    </div>

                    <?php if ($temPendente): ?>
                    <div class="perfil-solicitacao-pendente">
                        <i class="fa-regular fa-clock"></i>
                        <p>Você já possui uma solicitação de cargo pendente. Aguarde a análise.</p>
                    </div>
                    <?php elseif ($usuario->getCargo() === 'administrador' || $usuario->getCargo() === 'revisor'): ?>
                    <div class="perfil-cargo-max">
                        <i class="fa-solid fa-star"></i>
                        <p>Você já possui o cargo máximo disponível.</p>
                    </div>
                    <?php else: ?>
                    <?php if ($usuario->getFormacao() === '' || $usuario->getAssinatura() === ''): ?>
                    <div class="perfil-cargo-blocked">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        <p>Preencha <strong>formação</strong> e <strong>assinatura</strong> nas informações pessoais
                            antes de solicitar um cargo.</p>
                    </div>
                    <?php else: ?>
                    <div class="perfil-solicitar">
                        <?php if ($usuario->getCargo() === 'leitor'): ?>
                        <p>Solicitando: <strong>Redator</strong></p>
                        <small>Crie e publique notícias no sistema.</small>
                        <?php else: ?>
                        <p>Solicitando: <strong>Revisor</strong></p>
                        <small>Revise e aprove notícias de outros redatores.</small>
                        <?php endif; ?>
                        <form method="POST" action="<?= url('/perfil/solicitar') ;?>">
                            <button type="submit" class="perfil-btn solicitar">
                                <i class="fa-solid fa-paper-plane"></i> Solicitar Cargo
                            </button>
                        </form>
                    </div>
                    <?php endif; ?>
                    <?php endif; ?>

                    <?php if (count($solicitacoes) > 0): ?>
                    <div class="perfil-historico">
                        <h3>Histórico de Solicitações</h3>
                        <div class="sol-monitor-list">
                            <?php foreach ($solicitacoes as $sol): ?>
                            <div class="sol-monitor-card sol-monitor-<?= strtolower($sol['status']) ;?>">
                                <div class="sol-monitor-header">
                                    <div class="sol-monitor-cargo">
                                        <i class="fa-solid fa-id-badge"></i>
                                        <?= e($sol['cargo']) ;?>
                                    </div>
                                    <?php if ($sol['status'] === 'EM_ANALISE'): ?>
                                        <span class="sol-status-badge sol-pendente">PENDENTE</span>
                                    <?php elseif ($sol['status'] === 'APROVADA'): ?>
                                        <span class="sol-status-badge sol-aprovada">APROVADA</span>
                                    <?php else: ?>
                                        <span class="sol-status-badge sol-rejeitada">REJEITADA</span>
                                    <?php endif; ?>
                                </div>

                                <div class="sol-monitor-datas">
                                    <div class="sol-monitor-data-item">
                                        <span class="sol-monitor-label">Solicitado em</span>
                                        <span class="sol-monitor-valor">
                                            <i class="fa-regular fa-calendar"></i>
                                            <?= (new DateTime($sol['dataSolicitacao']))->format('d/m/Y \à\s H:i') ;?>
                                        </span>
                                    </div>
                                    <?php if ($sol['dataResposta']): ?>
                                    <div class="sol-monitor-data-item">
                                        <span class="sol-monitor-label">Respondido em</span>
                                        <span class="sol-monitor-valor">
                                            <i class="fa-regular fa-clock"></i>
                                            <?= (new DateTime($sol['dataResposta']))->format('d/m/Y \à\s H:i') ;?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>

                                <?php if ($sol['status'] !== 'EM_ANALISE' && $sol['admin_nome']): ?>
                                <div class="sol-monitor-admin">
                                    <span class="sol-monitor-label">Analisado por</span>
                                    <div class="sol-monitor-admin-info">
                                        <img src="<?= asset($sol['admin_foto'] ?: 'img/avatar_admin.png') ;?>" alt="Admin" class="sol-monitor-admin-avatar">
                                        <span><?= e($sol['admin_nome']) ;?></span>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <?php if ($sol['observacao']): ?>
                                <div class="sol-monitor-obs">
                                    <span class="sol-monitor-label">Observação</span>
                                    <p><?= e($sol['observacao']) ;?></p>
                                </div>
                                <?php endif; ?>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <?php if (!empty($minhasNoticias)): ?>
            <div class="perfil-secao">
                <h2><i class="fa-solid fa-newspaper"></i> Notícias que escrevi</h2>
                <div class="perfil-carousel">
                    <div class="perfil-carousel-track" id="carousel-escritas">
                        <?php foreach ($minhasNoticias as $noticia): ?>
                        <a href="<?= url('/noticia/' . $noticia->getId()) ;?>" class="perfil-carousel-card">
                            <?php if ($noticia->getImagem()): ?>
                            <div class="perfil-card-img">
                                <img src="<?= asset('img/' . $noticia->getImagem()) ;?>"
                                    alt="<?= e($noticia->getTitulo()) ;?>">
                            </div>
                            <?php endif; ?>
                            <div class="perfil-card-body">
                                <span
                                    class="perfil-card-status status-<?= strtolower($noticia->getStatus()->value) ;?>"><?= e($noticia->getStatus()->value) ;?></span>
                                <h3><?= e($noticia->getTitulo()) ;?></h3>
                                <small><?= $noticia->getDataCriacao()->format('d/m/Y') ;?></small>
                            </div>
                        </a>
                        <?php endforeach; ?>
                    </div>
                    <?php if (count($minhasNoticias) > 3): ?>
                    <button class="perfil-carousel-btn prev" onclick="scrollCarousel('carousel-escritas', -1)"><i
                            class="fa-solid fa-chevron-left"></i></button>
                    <button class="perfil-carousel-btn next" onclick="scrollCarousel('carousel-escritas', 1)"><i
                            class="fa-solid fa-chevron-right"></i></button>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>

            <?php if (!empty($revisoesFeitas)): ?>
            <div class="perfil-secao">
                <h2><i class="fa-solid fa-clock-rotate-left"></i> Notícias que revisou</h2>
                <div class="perfil-carousel">
                    <div class="perfil-carousel-track" id="carousel-revisoes">
                        <?php foreach ($revisoesFeitas as $rev): ?>
                        <a href="<?= url('/noticia/' . $rev['noticia_id']) ;?>" class="perfil-carousel-card">
                            <?php if ($rev['imagem']): ?>
                            <div class="perfil-card-img">
                                <img src="<?= asset('img/' . $rev['imagem']) ;?>" alt="<?= e($rev['titulo']) ;?>">
                            </div>
                            <?php endif; ?>
                            <div class="perfil-card-body">
                                <span
                                    class="perfil-card-acao acao-<?= strtolower($rev['acaoRealizada']) ;?>"><?= e($rev['acaoRealizada']) ;?></span>
                                <h3><?= e($rev['titulo']) ;?></h3>
                                <small><?= date('d/m/Y', strtotime($rev['dataRevisao'])) ;?></small>
                            </div>
                        </a>
                        <?php endforeach; ?>
                    </div>
                    <?php if (count($revisoesFeitas) > 3): ?>
                    <button class="perfil-carousel-btn prev" onclick="scrollCarousel('carousel-revisoes', -1)"><i
                            class="fa-solid fa-chevron-left"></i></button>
                    <button class="perfil-carousel-btn next" onclick="scrollCarousel('carousel-revisoes', 1)"><i
                            class="fa-solid fa-chevron-right"></i></button>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>

        </div>
    </main>

    <footer>
        <div class="footer-container">
            <div class="footer-brand">
                <div class="footer-logo"><img src="<?= asset('img/atlas.png') ;?>" alt="Jornal Atlas"></div>
                <p class="footer-tagline">Informação com profundidade, contexto e credibilidade para entender o mundo.
                </p>
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
                    <a class="footer-link-item" href="<?= url('/sobre') ;?>">Sobre nós</a>
                    <a class="footer-link-item" href="<?= url('/anuncie') ;?>">Anuncie</a>
                    <a class="footer-link-item" href="<?= url('/contato') ;?>">Fale conosco</a>
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

    function scrollCarousel(id, dir) {
        const track = document.getElementById(id);
        const cardWidth = track.querySelector('.perfil-carousel-card').offsetWidth + 16;
        track.scrollBy({
            left: dir * cardWidth * 2,
            behavior: 'smooth'
        });
    }
    </script>
    <script src="<?= asset('js/script.js') ;?>"></script>
</body>

</html>