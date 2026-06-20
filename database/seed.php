<?php

use App\Core\Database;

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/Core/Database.php';
require_once __DIR__ . '/../app/Core/Autoloader.php';

App\Core\Autoloader::register();

$pdo = Database::getConnection();

// ==================== USUARIOS ====================

$adminSenha = password_hash('admin123', PASSWORD_DEFAULT);

$pdo->exec("
    INSERT INTO Usuario (nome, nascimento, formacao, assinatura, email, senha, foto, podeRedigir, podeRevisar, isAdmin)
    VALUES ('Eduardo P.', '1990-05-15', 'Jornalismo', 'Admin', 'admin@jornalatlas.com', '$adminSenha', NULL, TRUE, TRUE, TRUE)
");

$redatorSenha = password_hash('redator123', PASSWORD_DEFAULT);

$pdo->exec("
    INSERT INTO Usuario (nome, nascimento, formacao, assinatura, email, senha, foto, podeRedigir, podeRevisar, isAdmin)
    VALUES ('Maria Silva', '1995-08-22', 'Comunicação Social', 'Redatora', 'redator@jornalatlas.com', '$redatorSenha', NULL, TRUE, FALSE, FALSE)
");

// ==================== NOTICIAS (HERO) ====================

$stmt = $pdo->prepare("
    INSERT INTO Noticia (redator_id, titulo, resumo, conteudo, imagem, categoria, secao, status, dataPublicacao)
    VALUES (:redator_id, :titulo, :resumo, :conteudo, :imagem, :categoria, :secao, 'APROVADA', NOW())
");

$hero = [
    [
        'titulo' => 'Impulsionamento digital, adesivos, peças na TV: veja onde partidos devem gastar os R$ 4,9 bilhões do Fundo Eleitoral',
        'resumo' => 'TSE distribuirá dinheiro a 30 partidos. Em 2022, o fundo bancou 87,9% das despesas dos presidenciáveis; despesas com TV e impulsionamento lideraram gastos.',
        'conteudo' => 'Conteúdo completo da matéria sobre o Fundo Eleitoral e a distribuição entre os partidos políticos.',
        'imagem' => 'urna.jpg',
        'categoria' => 'POLÍTICA',
        'secao' => 'hero',
    ],
    [
        'titulo' => 'Copa: Uruguai desperta no 2º tempo e busca o empate contra a Arábia Saudita',
        'resumo' => 'Apesar de sair atrás no placar, equipe de Bielsa conseguiu se recuperar e garantir o 1 a 1 em Miami; por pouco, não virou.',
        'conteudo' => 'Conteúdo completo da matéria sobre a partida do Uruguai na Copa do Mundo.',
        'imagem' => 'copa.jpg',
        'categoria' => 'ESPORTES',
        'secao' => 'hero',
    ],
    [
        'titulo' => 'SUS incorpora novo tratamento para leucemia mieloide aguda em adultos',
        'resumo' => 'Combinação de venetoclax e azacitidina será oferecida a adultos recém-diagnosticados com a doença; Ministério da Saúde tem até 180 dias para disponibilizar terapia na rede pública.',
        'conteudo' => 'Conteúdo completo da matéria sobre o novo tratamento incorporado pelo SUS.',
        'imagem' => 'exame.jpg',
        'categoria' => 'SAÚDE',
        'secao' => 'hero',
    ],
    [
        'titulo' => "'Taxa das blusinhas': governo volta a tributar compras internacionais de baixo valor em 2027, mas com imposto e alíquota diferentes",
        'resumo' => 'No lugar do imposto de importação de 20%, será cobrado imposto federal sobre consumo criado na reforma tributária. Valor será definido no fim do ano; Fazenda não comenta.',
        'conteudo' => 'Conteúdo completo da matéria sobre a taxação de compras internacionais.',
        'imagem' => 'governo.jpg',
        'categoria' => 'ECONOMIA',
        'secao' => 'hero',
    ],
];

foreach ($hero as $noticia) {
    $stmt->execute([
        ':redator_id' => 2,
        ':titulo' => $noticia['titulo'],
        ':resumo' => $noticia['resumo'],
        ':conteudo' => $noticia['conteudo'],
        ':imagem' => $noticia['imagem'],
        ':categoria' => $noticia['categoria'],
        ':secao' => $noticia['secao'],
    ]);
}

// ==================== NOTICIAS (NACIONAL) ====================

$nacional = [
    [
        'titulo' => 'Pesca em local proibido termina com apreensão 85 kg de peixes e multa de R$ 5,7 mil no interior de SP',
        'resumo' => 'Ocorrência foi registrada nesta segunda-feira (15), próximo à Cachoeira Salto Botelho, em Lucélia (SP). O pescado apreendido foi doado ao Lar São Vicente de Paulo do município.',
        'conteudo' => 'Conteúdo completo da matéria sobre a pesca ilegal no interior de São Paulo.',
        'imagem' => 'noticia1.jpg',
        'categoria' => 'POLÍTICA',
        'secao' => 'nacional',
    ],
    [
        'titulo' => 'No Rio, Zema minimiza fala de Eduardo Bolsonaro sobre rompimento com o Novo e reafirma críticas a Flávio',
        'resumo' => 'Zema disse que não muda "nada" do que afirmou anteriormente sobre a relação de Flávio Bolsonaro e Daniel Vorcaro.',
        'conteudo' => 'Conteúdo completo da matéria sobre as declarações de Zema no Rio.',
        'imagem' => 'noticia2.jpg',
        'categoria' => 'POLÍTICA',
        'secao' => 'nacional',
    ],
    [
        'titulo' => 'Nova espécie de flor descoberta no Brasil já nasce ameaçada de extinção',
        'resumo' => 'Registro feito durante uma trilha em Santa Catarina levou pesquisadores a identificar planta inédita para a ciência.',
        'conteudo' => 'Conteúdo completo da matéria sobre a nova espécie de flor.',
        'imagem' => 'noticia3.jpg',
        'categoria' => 'CIÊNCIA',
        'secao' => 'nacional',
    ],
    [
        'titulo' => 'Museu Nacional ganha réplica de dinossauro brasileiro com 15 metros',
        'resumo' => 'Oxalaia quilombensis viveu no Maranhão há 95 milhões de anos.',
        'conteudo' => 'Conteúdo completo da matéria sobre a réplica do dinossauro no Museu Nacional.',
        'imagem' => 'noticia4.jpg',
        'categoria' => 'CULTURA',
        'secao' => 'nacional',
    ],
];

foreach ($nacional as $noticia) {
    $stmt->execute([
        ':redator_id' => 2,
        ':titulo' => $noticia['titulo'],
        ':resumo' => $noticia['resumo'],
        ':conteudo' => $noticia['conteudo'],
        ':imagem' => $noticia['imagem'],
        ':categoria' => $noticia['categoria'],
        ':secao' => $noticia['secao'],
    ]);
}

// ==================== NOTICIAS (INTERNACIONAL) ====================

$internacional = [
    [
        'titulo' => 'Pizza Hut será vendida por US$ 2,7 bilhões após anos de queda nas vendas e fechamento de lojas',
        'resumo' => 'Em fevereiro, a controladora Yum Brands disse que já estudava vender a rede e fechar 250 restaurantes nos EUA, em meio ao aumento da concorrência e lojas consideradas ultrapassadas.',
        'conteudo' => 'Conteúdo completo da matéria sobre a venda da Pizza Hut.',
        'imagem' => 'noticia5.jpg',
        'categoria' => 'ECONOMIA',
        'secao' => 'internacional',
    ],
    [
        'titulo' => 'Irã na Copa: após empatar com Nova Zelândia, seleção iraniana enfrenta entraves ao deixar os EUA',
        'resumo' => 'Capitão da seleção, Mehdi Taremi, e um auxiliar da equipe foram retidos no aeroporto de Los Angeles, onde o time jogou contra a Nova Zelândia.',
        'conteudo' => 'Conteúdo completo da matéria sobre a seleção iraniana na Copa.',
        'imagem' => 'noticia6.jpg',
        'categoria' => 'ESPORTES',
        'secao' => 'internacional',
    ],
    [
        'titulo' => 'Eleições no Peru: com 99% das urnas apuradas, Keiko lidera disputa contra Sánchez',
        'resumo' => 'Com mais de 99% das urnas apuradas, os candidatos Roberto Sánchez e Keiko Fujimori ainda registram diferença de menos de 1 ponto percentual.',
        'conteudo' => 'Conteúdo completo da matéria sobre as eleições no Peru.',
        'imagem' => 'noticia7.jpg',
        'categoria' => 'POLÍTICA',
        'secao' => 'internacional',
    ],
    [
        'titulo' => 'G7 amplia pressão sobre Rússia e Trump promete agir por acordo para encerrar guerra na Ucrânia',
        'resumo' => 'Os líderes do G7 defenderam nesta terça-feira (16) em Evian, na França, o aumento da pressão sobre a Rússia para encerrar a guerra na Ucrânia.',
        'conteudo' => 'Conteúdo completo da matéria sobre o G7 e a guerra na Ucrânia.',
        'imagem' => 'noticia8.jpg',
        'categoria' => 'POLÍTICA',
        'secao' => 'internacional',
    ],
];

foreach ($internacional as $noticia) {
    $stmt->execute([
        ':redator_id' => 2,
        ':titulo' => $noticia['titulo'],
        ':resumo' => $noticia['resumo'],
        ':conteudo' => $noticia['conteudo'],
        ':imagem' => $noticia['imagem'],
        ':categoria' => $noticia['categoria'],
        ':secao' => $noticia['secao'],
    ]);
}

echo "Seed executado com sucesso!\n";
echo "Usuarios criados: admin@jornalatlas.com / redator@jornalatlas.com\n";
echo "Noticias criadas: 12 (4 hero + 4 nacional + 4 internacional)\n";
