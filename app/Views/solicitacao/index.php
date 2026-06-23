<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<?php
$userLogado = isset($_SESSION['usuario_logado']) && $_SESSION['usuario_logado'] === true;
$userCargo = $_SESSION['usuario_cargo'] ?? 'leitor';
$userNome = $_SESSION['usuario_nome'] ?? '';
$userFoto = $_SESSION['usuario_foto'] ?? 'img/avatar_admin.png';
$sucesso = $_SESSION['sucesso'] ?? null;
unset($_SESSION['sucesso']);
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitações de Cargo - Jornal Atlas</title>
    <link rel="icon" type="image/png" href="<?= asset('img/atlas.fav.png') ;?>">
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

    <nav>
        <ul>
            <?php $cats = ['Política' => 'POLÍTICA', 'Tecnologia' => 'TECNOLOGIA', 'Economia' => 'ECONOMIA', 'Esportes' => 'ESPORTES', 'Mundo' => 'MUNDO', 'Cultura' => 'CULTURA', 'Saúde' => 'SAÚDE', 'Ciência' => 'CIÊNCIA'];foreach ($cats as $l => $v): ?>
            <li><a href="<?= url('/categoria/' . urlencode($v)) ;?>"><?= $l ;?></a></li>
            <?php endforeach; ?>
        </ul>
    </nav>

    <main class="solicitacao-pagina">
        <div class="breadcrumb">
            <a href="<?= url('/') ;?>">Home</a>
            <span>/</span>
            <a href="<?= url('/admin') ;?>">Painel administrativo</a>
            <span>/</span>
            <span class="atual">Solicitações de cargo</span>
        </div>

        <div class="solicitacao-header">
            <div>
                <h1>Solicitações de cargo</h1>
                <p>Gerencie os pedidos de upgrade de cargo dos usuários do sistema.</p>
            </div>
        </div>

        <?php if ($sucesso): ?>
        <div class="alert-sucesso"><i class="fa-solid fa-circle-check"></i> <?= e($sucesso) ;?></div>
        <?php endif; ?>

        <div class="solicitacao-stats">
            <div class="sol-stat-card pendente">
                <div class="sol-stat-icon"><i class="fa-regular fa-clock"></i></div>
                <div class="sol-stat-info">
                    <span class="sol-stat-numero"><?= $stats['pendentes'] ;?></span>
                    <span class="sol-stat-label">PENDENTES</span>
                </div>
            </div>
            <div class="sol-stat-card aprovada">
                <div class="sol-stat-icon"><i class="fa-solid fa-check"></i></div>
                <div class="sol-stat-info">
                    <span class="sol-stat-numero"><?= $stats['aprovadas'] ;?></span>
                    <span class="sol-stat-label">APROVADAS</span>
                </div>
            </div>
            <div class="sol-stat-card rejeitada">
                <div class="sol-stat-icon"><i class="fa-solid fa-xmark"></i></div>
                <div class="sol-stat-info">
                    <span class="sol-stat-numero"><?= $stats['rejeitadas'] ;?></span>
                    <span class="sol-stat-label">REJEITADAS</span>
                </div>
            </div>
            <div class="sol-stat-card total">
                <div class="sol-stat-icon"><i class="fa-solid fa-layer-group"></i></div>
                <div class="sol-stat-info">
                    <span class="sol-stat-numero"><?= $stats['total'] ;?></span>
                    <span class="sol-stat-label">TOTAL DE SOLICITAÇÕES</span>
                </div>
            </div>
        </div>

        <div class="solicitacao-layout">
            <div class="solicitacao-lista">
                <?php if (empty($solicitacoes)): ?>
                <div class="solicitacao-vazio">
                    <i class="fa-regular fa-folder-open"></i>
                    <p>Nenhuma solicitação de cargo registrada.</p>
                </div>
                <?php else: ?>
                <table class="solicitacao-tabela">
                    <thead>
                        <tr>
                            <th>USUÁRIO</th>
                            <th>CARGO ATUAL</th>
                            <th>CARGO SOLICITADO</th>
                            <th>DATA DA SOLICITAÇÃO</th>
                            <th>STATUS</th>
                            <th>AÇÕES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($solicitacoes as $sol): ?>
                        <?php
$solId = $sol['id'];
$solUser = $sol['usuario_nome'];
$solUserFoto = $sol['usuario_foto'] ?? 'img/avatar_admin.png';
$solCargoAtual = 'leitor';
if (!empty($sol['podeRedigir'])) {
    $solCargoAtual = 'redator';
}

if (!empty($sol['podeRevisar'])) {
    $solCargoAtual = 'revisor';
}

if (!empty($sol['isAdmin'])) {
    $solCargoAtual = 'administrador';
}

$solCargoSolicitado = $sol['cargo'];
$solData = date('d/m/Y', strtotime($sol['dataSolicitacao']));
$solStatus = $sol['status'];
$solResolvida = ($solStatus !== 'EM_ANALISE');
?>
                        <tr class="<?= ($selecionada && $selecionada->getId() == $solId) ? 'selecionada' : '' ;?> <?= $solResolvida ? 'resolvida' : '' ;?>"
                            onclick="window.location='<?= url('/solicitacoes?id=' . $solId) ;?>'">
                            <td class="td-usuario">
                                <img src="<?= asset($solUserFoto) ;?>" alt="<?= e($solUser) ;?>" class="sol-user-thumb">
                                <?= e($solUser) ;?>
                            </td>
                            <td><span
                                    class="cargo-badge cargo-<?= $solCargoAtual ;?>"><?= strtoupper($solCargoAtual) ;?></span>
                            </td>
                            <td><span
                                    class="cargo-badge cargo-<?= strtolower($solCargoSolicitado) ;?>"><?= e($solCargoSolicitado) ;?></span>
                            </td>
                            <td><?= $solData ;?></td>
                            <td>
                                <?php if ($solStatus === 'EM_ANALISE'): ?>
                                <span class="sol-status-badge sol-pendente"><i class="fa-regular fa-clock"></i> EM
                                    ANÁLISE</span>
                                <?php elseif ($solStatus === 'APROVADA'): ?>
                                <span class="sol-status-badge sol-aprovada"><i class="fa-solid fa-check"></i>
                                    APROVADA</span>
                                <?php else: ?>
                                <span class="sol-status-badge sol-rejeitada"><i class="fa-solid fa-xmark"></i>
                                    REJEITADA</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (!$solResolvida && $userCargo === 'administrador'): ?>
                                <a href="<?= url('/solicitacoes?id=' . $solId) ;?>" class="sol-btn-detalhes"
                                    title="Ver detalhes"><i class="fa-solid fa-eye"></i></a>
                                <?php else: ?>
                                <span class="sol-btn-detalhes disabled"><i class="fa-solid fa-eye"></i></span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php endif; ?>
            </div>

            <div class="solicitacao-preview">
                <?php if ($selecionada && $selecionadaUser): ?>
                <?php
$cargoAtualLabel = $selecionadaUser->getCargo();
$cargoSolicitadoLabel = $selecionada->getCargo()->value;
$jaResolvida = $selecionada->getStatus()->value !== 'EM_ANALISE';
?>
                <div class="preview-perfil">
                    <img src="<?= asset($selecionadaUser->getFoto()) ;?>" alt="Foto" class="preview-avatar">
                    <div class="preview-perfil-info">
                        <span class="preview-perfil-nome"><?= e($selecionadaUser->getNome()) ;?></span>
                        <span class="preview-perfil-email"><?= e($selecionadaUser->getEmail()) ;?></span>
                    </div>
                </div>

                <div class="preview-campos">
                    <div class="preview-campo">
                        <label>Cargo Atual</label>
                        <span
                            class="cargo-badge cargo-<?= strtolower($cargoAtualLabel) ;?>"><?= strtoupper($cargoAtualLabel) ;?></span>
                    </div>
                    <div class="preview-campo">
                        <label>Cargo Solicitado</label>
                        <span
                            class="cargo-badge cargo-<?= strtolower($cargoSolicitadoLabel) ;?>"><?= e($cargoSolicitadoLabel) ;?></span>
                    </div>
                    <div class="preview-campo">
                        <label>Data da Solicitação</label>
                        <span><?= date('d/m/Y \à\s H:i', strtotime($selecionada->getDataSolicitacao()->format('Y-m-d H:i:s'))) ;?></span>
                    </div>
                </div>

                <?php if ($jaResolvida): ?>
                <div class="preview-resolvido">
                    <div class="preview-campo">
                        <label>Status</label>
                        <?php if ($selecionada->getStatus()->value === 'APROVADA'): ?>
                        <span class="sol-status-badge sol-aprovada"><i class="fa-solid fa-check"></i> APROVADA</span>
                        <?php else: ?>
                        <span class="sol-status-badge sol-rejeitada"><i class="fa-solid fa-xmark"></i> REJEITADA</span>
                        <?php endif; ?>
                    </div>
                    <?php if ($selecionada->getDataResposta()): ?>
                    <div class="preview-campo">
                        <label>Respondido em</label>
                        <span><?= date('d/m/Y \à\s H:i', $selecionada->getDataResposta()->getTimestamp()) ;?></span>
                    </div>
                    <?php endif; ?>
                    <?php if ($selecionada->getObservacao()): ?>
                    <div class="preview-campo">
                        <label>Observação do Administrador</label>
                        <p class="preview-observacao"><?= e($selecionada->getObservacao()) ;?></p>
                    </div>
                    <?php endif; ?>
                </div>
                <?php else: ?>
                <form class="solicitacao-form" method="POST" action="">
                    <div class="sol-observacao">
                        <label>Observação para o usuário <span class="opcional">(opcional)</span></label>
                        <textarea name="observacao" rows="3"
                            placeholder="Justifique sua decisão ou deixe um feedback para o solicitante..."></textarea>
                    </div>

                    <div class="sol-botoes">
                        <button type="submit"
                            formaction="<?= url('/solicitacoes/rejeitar/' . $selecionada->getId()) ;?>"
                            class="sol-btn sol-btn-rejeitar">
                            <i class="fa-solid fa-xmark"></i> REJEITAR
                        </button>
                        <button type="submit" formaction="<?= url('/solicitacoes/aprovar/' . $selecionada->getId()) ;?>"
                            class="sol-btn sol-btn-aprovar">
                            <i class="fa-solid fa-check"></i> APROVAR
                        </button>
                    </div>
                </form>
                <?php endif; ?>
                <?php else: ?>
                <div class="preview-vazio">
                    <i class="fa-regular fa-hand-pointer"></i>
                    <p>Selecione uma solicitação para visualizar os detalhes.</p>
                </div>
                <?php endif; ?>
            </div>
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

    document.querySelectorAll('.solicitacao-form').forEach(function(form) {
        form.addEventListener('submit', function() {
            var btns = this.querySelectorAll('button[type="submit"]');
            btns.forEach(function(btn) {
                btn.disabled = true;
            });
        });
    });
    </script>
    <script src="<?= asset('js/script.js') ;?>"></script>
</body>

</html>