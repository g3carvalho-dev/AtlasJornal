<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<?php
use App\Core\StatusNoticia;
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
                <a href="https://facebook.com" target="_blank" rel="noopener noreferrer" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                <a href="https://twitter.com" target="_blank" rel="noopener noreferrer" aria-label="Twitter"><i class="fa-brands fa-x-twitter"></i></a>
                <a href="https://youtube.com" target="_blank" rel="noopener noreferrer" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a>
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
                <a href="<?= url('/logout') ;?>" class="btn-logout-icon" title="Sair" onclick="event.stopPropagation()"><i
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
                <?php
                $pendentesCount = 0;
                $revisadasCount = 0;
                $statusLabels = [
                    'RASCUNHO' => 'RASCUNHO',
                    'EM_ANALISE' => 'EM ANÁLISE',
                    'APROVADA' => 'APROVADA',
                    'ARQUIVADA' => 'ARQUIVADA',
                    'REJEITADA' => 'REJEITADA',
                ];
                $acaoLabels = [
                    'APROVAR' => 'Aprovada',
                    'REJEITAR' => 'Rejeitada',
                    'ARQUIVAR' => 'Arquivada',
                ];
                foreach ($noticias as $row) {
                    if ($row['status'] === StatusNoticia::ANALISE->value) {
                        $pendentesCount++;
                    } else {
                        $revisadasCount++;
                    }
                }
                ?>
                <div class="revisao-stats-bar">
                    <span class="rev-stat pendente"><i class="fa-regular fa-clock"></i> <?= $pendentesCount ;?>
                        pendentes</span>
                    <span class="rev-stat" style="margin-left:12px; color:#94a3b8;"><i class="fa-solid fa-check-double"></i> <?= $revisadasCount ;?>
                        revisadas</span>
                </div>

                <?php if (empty($noticias)): ?>
                <div class="revisao-vazio">
                    <i class="fa-regular fa-circle-check"></i>
                    <p>Nenhuma notícia pendente ou revisada.</p>
                </div>
                <?php else: ?>
                <table class="revisao-tabela">
                    <thead>
                        <tr>
                            <th>NOTÍCIA</th>
                            <th>AUTOR</th>
                            <th>STATUS</th>
                            <th>ÚLTIMA AÇÃO</th>
                            <th>DATA</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($noticias as $row):
                            $rev = $ultimaRevisaoPorNoticia[$row['id']] ?? null;
                        ?>
                        <tr class="<?= ($noticiaSelecionada && $noticiaSelecionada->getId() == $row['id']) ? 'selecionada' : '' ;?>"
                            onclick="window.location='<?= url('/revisao?noticia=' . $row['id']) ;?>'">
                            <td class="td-titulo">
                                <span class="td-titulo-texto"><?= e($row['titulo']) ;?></span>
                                <span class="dash-categoria-tag"><?= e($row['categoria']) ;?></span>
                            </td>
                            <td class="td-autor">
                                <span class="td-autor-texto"><?= e($row['autor_nome']) ;?></span>
                            </td>
                            <td>
                                <?php $statusCls = strtolower(str_replace('_', '-', $row['status'])); ?>
                                <span class="status-badge-status status-<?= $statusCls ;?>"><?= $statusLabels[$row['status']] ?? $row['status'] ;?></span>
                            </td>
                            <td>
                                <?php if ($rev): ?>
                                    <?= $acaoLabels[$rev['acaoRealizada']] ?? $rev['acaoRealizada'] ;?>
                                <?php else: ?>
                                    <span style="color:#64748b;">—</span>
                                <?php endif; ?>
                            </td>
                            <td class="td-data">
                                <?= date('d/m/Y', strtotime($row['dataCriacao'])) ;?>
                                <small><?= date('H:i', strtotime($row['dataCriacao'])) ;?></small>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php endif; ?>
            </div>

            <div class="revisao-preview">
                <?php if ($noticiaSelecionada): ?>
                <?php
                    $statusSelecionada = $noticiaSelecionada->getStatus()->value;
                    $statusClsSel = strtolower(str_replace('_', '-', $statusSelecionada));
                    $revSelecionada = $ultimaRevisaoPorNoticia[$noticiaSelecionada->getId()] ?? null;
                ?>
                <div class="preview-cabecalho">
                    <div>
                        <span class="preview-categoria"><?= e($noticiaSelecionada->getCategoria()) ;?></span>
                        <span class="preview-status-badge status-<?= $statusClsSel ;?>"><?= $statusLabels[$statusSelecionada] ?? $statusSelecionada ;?></span>
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
                    <?= $noticiaSelecionada->getConteudo() ;?>
                </div>

                <?php if (!empty($_SESSION['erro'])): ?>
                <div class="alert-erro"><i class="fa-solid fa-circle-exclamation"></i> <?= e($_SESSION['erro']) ;?>
                </div>
                <?php unset($_SESSION['erro']); ?>
                <?php endif; ?>

                <?php
                $todasRevisoes = \App\Repositories\RevisaoRepository::byNoticia($noticiaSelecionada->getId());
                ?>
                <?php if (!empty($todasRevisoes)): ?>
                <div style="margin-top:20px; margin-bottom:20px;">
                    <h3 style="font-family:'Playfair Display',serif; font-size:17px; margin-bottom:10px;">
                        <i class="fa-solid fa-clock-rotate-left"></i> Histórico de Revisões
                    </h3>
                    <?php foreach ($todasRevisoes as $revHistorico):
                        $acaoLabel = $acaoLabels[$revHistorico->getAcao()->value] ?? $revHistorico->getAcao()->value;
                        $revisor = \App\Repositories\UsuarioRepository::find($revHistorico->getRevisorId());
                    ?>
                    <div style="background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); border-radius:10px; padding:14px; margin-bottom:10px;">
                        <div style="display:flex; align-items:center; gap:10px; margin-bottom:6px;">
                            <img src="<?= asset($revisor ? $revisor->getFoto() : 'img/avatar_admin.png') ;?>" alt="" style="width:28px; height:28px; border-radius:50%; object-fit:cover;">
                            <strong style="font-size:13px;"><?= e($revisor ? $revisor->getNome() : 'Desconhecido') ;?></strong>
                            <span class="dash-status <?= strtolower(str_replace('_', '-', $revHistorico->getAcao()->value)) ;?>"><?= $acaoLabel ;?></span>
                            <span style="margin-left:auto; color:#94a3b8; font-size:12px;">
                                <?= format_date($revHistorico->getDataRevisao(), 'd/m/Y \à\s H:i') ;?>
                            </span>
                        </div>
                        <?php if ($revHistorico->getObservacao()): ?>
                        <p style="color:#cbd5e1; font-size:13px; margin:0; line-height:1.5;">
                            "<?= e($revHistorico->getObservacao()) ;?>"
                        </p>
                        <?php else: ?>
                        <p style="color:#64748b; font-size:12px; font-style:italic; margin:0;">
                            Nenhuma observação registrada.
                        </p>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <?php if ($statusSelecionada === StatusNoticia::ANALISE->value && $podeAprovar): ?>
                <form class="revisao-form" method="POST" action="<?= url('/revisao/aprovar/' . $noticiaSelecionada->getId()) ;?>">
                    <div class="revisao-observacao">
                        <label>Observação ao redator <span class="opcional">(opcional)</span></label>
                        <textarea name="observacao" rows="3"
                            placeholder="Deixe um comentário, solicite ajustes ou registre sua observação..."></textarea>
                        <small>Seu comentário será visível para o autor do artigo.</small>
                    </div>

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
                </form>
                <?php elseif ($statusSelecionada === StatusNoticia::ANALISE->value && !$podeAprovar): ?>
                    <div class="revisao-aviso" style="margin-top:16px;">
                        <i class="fa-solid fa-ban"></i>
                        <div>
                            <strong>Você é o autor deste artigo.</strong>
                            <span>A aprovação por outro revisor ou administrador é obrigatória.</span>
                        </div>
                    </div>
                <?php endif; ?>
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

    document.querySelectorAll('.revisao-form').forEach(function(form) {
        form.addEventListener('submit', function() {
            var btns = this.querySelectorAll('button[type="submit"]');
            btns.forEach(function(btn) { btn.disabled = true; });
        });
    });
    </script>
    <script src="<?= asset('js/script.js') ;?>"></script>
</body>

</html>