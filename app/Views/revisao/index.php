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
    <title>Revisar Notícias - Jornal Atlas</title>
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

    <main class="revisao-pagina">
        <div class="revisao-header">
            <div>
                <h1>Revisar notícias pendentes</h1>
                <p>Analise, edite e aprove os conteúdos enviados pelos redatores.</p>
            </div>
            <?php if ($userCargo !== 'administrador'): ?>
            <div class="revisao-aviso">
                <i class="fa-solid fa-triangle-exclamation"></i>
                <div>
                    <strong>Você não pode aprovar seu próprio artigo.</strong>
                    <span>A aprovação por outro revisor ou administrador é obrigatória.</span>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <?php if ($sucesso): ?>
        <div class="alert-sucesso"><i class="fa-solid fa-circle-check"></i> <?= e($sucesso) ;?></div>
        <?php endif; ?>

        <div class="revisao-layout">
            <div class="revisao-lista">
                <div class="revisao-stats-bar">
                    <span class="rev-stat pendente"><i class="fa-regular fa-clock"></i> <?= count($noticias) ;?>
                        pendentes</span>
                </div>

                <?php if (empty($noticias)): ?>
                <div class="revisao-vazio">
                    <i class="fa-regular fa-circle-check"></i>
                    <p>Nenhuma notícia pendente de revisão.</p>
                </div>
                <?php else: ?>
                <table class="revisao-tabela">
                    <thead>
                        <tr>
                            <th>TÍTULO</th>
                            <th>CATEGORIA</th>
                            <th>AUTOR</th>
                            <th>ENVIADO EM</th>
                            <th>STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($noticias as $row): ?>
                        <tr class="<?= ($noticiaSelecionada && $noticiaSelecionada->getId() == $row['id']) ? 'selecionada' : '' ;?>"
                            onclick="window.location='<?= url('/revisao?noticia=' . $row['id']) ;?>'">
                            <td class="td-titulo"><?= e($row['titulo']) ;?></td>
                            <td><?= e($row['categoria']) ;?></td>
                            <td><?= e($row['autor_nome']) ;?></td>
                            <td><?= date('d/m/Y', strtotime($row['dataCriacao'])) ;?><br><small><?= date('H:i', strtotime($row['dataCriacao'])) ;?></small>
                            </td>
                            <td><span class="status-badge-status status-em-analise">EM ANÁLISE</span></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php endif; ?>
            </div>

            <div class="revisao-preview">
                <?php if ($noticiaSelecionada): ?>
                <div class="preview-cabecalho">
                    <div>
                        <span class="preview-categoria"><?= e($noticiaSelecionada->getCategoria()) ;?></span>
                        <span class="preview-status-badge">EM ANÁLISE</span>
                    </div>
                </div>

                <h2 class="preview-titulo"><?= e($noticiaSelecionada->getTitulo()) ;?></h2>
                <p class="preview-meta">
                    <i class="fa-regular fa-user"></i>
                    <?= $autorNoticia ? e($autorNoticia->getNome()) : 'Desconhecido' ;?>
                    &nbsp;&bull;&nbsp;
                    <i class="fa-regular fa-calendar"></i>
                    <?= format_date($noticiaSelecionada->getDataCriacao(), 'd/m/Y \à\s H:i') ;?>
                </p>

                <?php if ($noticiaSelecionada->getImagem()): ?>
                <div class="preview-imagem">
                    <img src="<?= asset('img/' . $noticiaSelecionada->getImagem()) ;?>"
                        alt="<?= e($noticiaSelecionada->getTitulo()) ;?>">
                </div>
                <?php endif; ?>

                <div class="preview-resumo">
                    <p><?= e($noticiaSelecionada->getResumo()) ;?></p>
                </div>

                <div class="preview-conteudo">
                    <?= nl2br(e($noticiaSelecionada->getConteudo())) ;?>
                </div>

                <?php if (!empty($_SESSION['erro'])): ?>
                <div class="alert-erro"><i class="fa-solid fa-circle-exclamation"></i> <?= e($_SESSION['erro']) ;?>
                </div>
                <?php unset($_SESSION['erro']); ?>
                <?php endif; ?>

                <form class="revisao-form" method="POST" action="">
                    <div class="revisao-observacao">
                        <label>Observação ao redator <span class="opcional">(opcional)</span></label>
                        <textarea name="observacao" rows="3"
                            placeholder="Deixe um comentário, solicite ajustes ou registre sua observação..."></textarea>
                        <small>Seu comentário será visível para o autor do artigo.</small>
                    </div>

                    <?php if ($podeAprovar): ?>
                    <div class="revisao-botoes">
                        <a href="<?= url('/noticia/' . $noticiaSelecionada->getId() . '/editar') ;?>"
                            class="btn-rev btn-editar">
                            <i class="fa-solid fa-pen"></i> EDITAR ANTES DE APROVAR
                        </a>
                        <button type="submit"
                            formaction="<?= url('/revisao/arquivar/' . $noticiaSelecionada->getId()) ;?>"
                            class="btn-rev btn-arquivar">
                            <i class="fa-solid fa-box-archive"></i> ARQUIVAR
                        </button>
                        <button type="submit"
                            formaction="<?= url('/revisao/rejeitar/' . $noticiaSelecionada->getId()) ;?>"
                            class="btn-rev btn-rejeitar">
                            <i class="fa-solid fa-xmark"></i> REJEITAR
                        </button>
                        <button type="submit"
                            formaction="<?= url('/revisao/aprovar/' . $noticiaSelecionada->getId()) ;?>"
                            class="btn-rev btn-aprovar">
                            <i class="fa-solid fa-check"></i> APROVAR
                        </button>
                    </div>
                    <?php else: ?>
                    <div class="revisao-aviso" style="margin-top:16px;">
                        <i class="fa-solid fa-ban"></i>
                        <div>
                            <strong>Você é o autor deste artigo.</strong>
                            <span>A aprovação por outro revisor ou administrador é obrigatória.</span>
                        </div>
                    </div>
                    <?php endif; ?>
                </form>
                <?php else: ?>
                <div class="preview-vazio">
                    <i class="fa-regular fa-newspaper"></i>
                    <p>Selecione uma notícia para visualizar.</p>
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
                    <a class="footer-link-item" href="#">Sobre nós</a>
                    <a class="footer-link-item" href="#">Anuncie</a>
                    <a class="footer-link-item" href="#">Fale conosco</a>
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
    const diasSemana = ["Domingo", "Segunda-feira", "Terça-feira", "Quarta-feira", "Quinta-feira", "Sexta-feira",
        "Sábado"
    ];
    const meses = ["janeiro", "fevereiro", "março", "abril", "maio", "junho", "julho", "agosto", "setembro", "outubro",
        "novembro", "dezembro"
    ];;
    document.getElementById("data-atual").textContent =
        `${diasSemana[data.getDay()]}, ${data.getDate()} de ${meses[data.getMonth()]} de ${data.getFullYear()}`;
    </script>
</body>

</html>