<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$userLogado = isset($_SESSION['usuario_logado']) && $_SESSION['usuario_logado'] === true;
$userCargo = $_SESSION['usuario_cargo'] ?? 'leitor';
$userNome = $_SESSION['usuario_nome'] ?? '';
$userFoto = $_SESSION['usuario_foto'] ?? 'img/avatar_admin.png';

$paginas = [
    'codigo-de-etica' => [
        'titulo' => 'Código de Ética',
        'icon' => 'fa-solid fa-scale-balanced',
        'conteudo' => [
            ['subtitle' => 'Compromisso com a verdade', 'text' => 'Todo conteúdo publicado no Jornal Atlas segue rigorosamente os princípios da veracidade e da checagem de fontes. Nosso compromisso é apresentar fatos verificados, contextualizados e imparciais.'],
            ['subtitle' => 'Respeito e dignidade', 'text' => 'Não toleramos conteúdo que promova ódio, discriminação, assédio ou qualquer forma de violação dos direitos humanos. Cada matéria é revisada com foco no respeito às pessoas e aos grupos sociais.'],
            ['subtitle' => 'Transparência editorial', 'text' => 'As decisões editoriais são tomadas de forma ética e transparente. Conflitos de interesse, patrocínios ou qualquer vínculo comercial são sempre divulgados ao leitor.'],
            ['subtitle' => 'Responsabilidade com o leitor', 'text' => 'Valorizamos a confiança do nosso público. Por isso, mantemos correções rápidas e honestas sempre que um erro é identificado, e mantemos um canal aberto para manifestações e sugestões.'],
            ['subtitle' => 'Independência', 'text' => 'O Jornal Atlas é um projeto acadêmico independente. Nossa linha editorial não é influenciada por interesses políticos, comerciais ou pessoais — o jornalismo é o nosso único compromisso.'],
        ]
    ],
    'trabalhe-conosco' => [
        'titulo' => 'Trabalhe Conosco',
        'icon' => 'fa-solid fa-handshake',
        'conteudo' => [
            ['subtitle' => 'Faça parte do Atlas', 'text' => 'O Jornal Atlas está sempre aberto a novos talentos. Se você é estudante ou profissional da área de comunicação, jornalismo ou design e quer ganhar experiência prática, esta é a sua oportunidade.'],
            ['subtitle' => 'Vagas disponíveis', 'text' => 'Redatores — Escreva matérias para as diferentes editorias do jornal, desde política até ciência. Você aprende o fluxo completo de produção editorial.'],
            ['subtitle' => 'Revisores', 'text' => 'Ajude a garantir a qualidade do conteúdo. Revisores verificam fatos, linguagem e estrutura antes da publicação final.'],
            ['subtitle' => 'Como se candidatar', 'text' => 'Crie sua conta no Jornal Atlas, complete seu perfil e solicite o cargo desejado diretamente pela página de perfil. Nossa equipe analisará sua solicitação e entrará em contato.'],
            ['subtitle' => 'O que oferecemos', 'text' => 'Experiência prática em um ambiente de redação real, portfólio de publicações, carta de recomendação e networking com profissionais da área.'],
        ]
    ],
    'termos-de-uso' => [
        'titulo' => 'Termos de Uso',
        'icon' => 'fa-solid fa-file-contract',
        'conteudo' => [
            ['subtitle' => 'Aceitação dos termos', 'text' => 'Ao acessar e utilizar o Jornal Atlas, você concorda com estes Termos de Uso. Caso não concorde com algum dos termos, recomendamos que não utilize o site.'],
            ['subtitle' => 'Uso do conteúdo', 'text' => 'Todo o conteúdo publicado no Jornal Atlas é protegido por direitos autorais. Você pode ler, compartilhar e citar o conteúdo, desde que a fonte seja devidamente creditada.'],
            ['subtitle' => 'Cadastro de usuários', 'text' => 'Para acessar funcionalidades como comentários e áreas restritas, é necessário criar uma conta. Você é responsável por manter a confidencialidade de suas credenciais.'],
            ['subtitle' => 'Conduta do usuário', 'text' => 'Os usuários devem utilizar o site de forma ética e respeitosa. É proibido publicar conteúdo ofensivo, difamatório, spam ou qualquer material que viole leis vigentes.'],
            ['subtitle' => 'Isenção de responsabilidade', 'text' => 'O Jornal Atlas é um projeto acadêmico. Embora nos esforcemos para manter informações precisas, não garantimos completude absoluta de todo o conteúdo publicado.'],
        ]
    ],
    'politica-de-privacidade' => [
        'titulo' => 'Política de Privacidade',
        'icon' => 'fa-solid fa-shield-halved',
        'conteudo' => [
            ['subtitle' => 'Dados coletados', 'text' => 'Coletamos apenas os dados necessários para o funcionamento do site: nome, e-mail e foto de perfil (opcional). Essas informações são fornecidas voluntariamente pelo usuário durante o cadastro.'],
            ['subtitle' => 'Uso dos dados', 'text' => 'Seus dados são utilizados exclusivamente para personalizar sua experiência, gerenciar sua conta e melhorar o conteúdo do jornal. Não compartilhamos dados com terceiros para fins comerciais.'],
            ['subtitle' => 'Segurança', 'text' => 'Adotamos medidas de segurança para proteger suas informações pessoais. Senhas são armazenadas de forma criptografada e não são acessíveis nem pela equipe do jornal.'],
            ['subtitle' => 'Cookies', 'text' => 'Utilizamos cookies apenas para manter sua sessão ativa e lembrar suas preferências (como tema claro/escuro). Não utilizamos cookies de rastreamento ou publicitários.'],
            ['subtitle' => 'Seus direitos', 'text' => 'Você pode solicitar a exclusão da sua conta e dos seus dados a qualquer momento, entrando em contato conosco ou através da página de perfil.'],
        ]
    ],
    'suporte' => [
        'titulo' => 'Suporte',
        'icon' => 'fa-solid fa-headset',
        'conteudo' => [
            ['subtitle' => 'Precisa de ajuda?', 'text' => 'Se você encontrou algum problema no site, tem dúvidas sobre sua conta ou sugestões de melhoria, estamos aqui para ajudar.'],
            ['subtitle' => 'Problemas com a conta', 'text' => 'Se esqueceu sua senha, não consegue fazer login ou tem problemas com seu perfil, acesse a página de login e clique em "Esqueci minha senha" ou entre em contato pelo formulário de contato.'],
            ['subtitle' => 'Reportar conteúdo', 'text' => 'Se encontrou conteúdo incorreto, ofensivo ou que viola nosso código de ética, entre em contato conosco imediatamente. Levamos essas denúncias muito a sério.'],
            ['subtitle' => 'Sugestões e melhorias', 'text' => 'Suas ideias são importantes! Se tem sugestões de pautas, melhorias no site ou novas funcionalidades, utilize a página de contato para nos enviar.'],
            ['subtitle' => 'Canais de atendimento', 'text' => 'Utilize nossa página de contato para enviar mensagens. Responderemos o mais breve possível durante os dias úteis.'],
        ]
    ],
];

$pagina = $paginas[$paginaSlug] ?? null;
if (!$pagina) {
    header('Location: ' . url('/'));
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pagina['titulo'] ;?> - Jornal Atlas</title>
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

    <main class="institucional-pagina">
        <section class="institucional-hero">
            <span class="categoria">INSTITUCIONAL</span>
            <h1><i class="<?= $pagina['icon'] ;?>"></i> <?= $pagina['titulo'] ;?></h1>
            <p>Informação com profundidade, contexto e credibilidade.</p>
        </section>

        <section class="institucional-blocos">
            <?php foreach ($pagina['conteudo'] as $bloco): ?>
            <div class="institucional-bloco">
                <h2><?= $bloco['subtitle'] ;?></h2>
                <p><?= $bloco['text'] ;?></p>
            </div>
            <?php endforeach; ?>
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
