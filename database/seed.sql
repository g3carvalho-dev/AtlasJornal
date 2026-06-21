-- ==================== USUARIOS ====================

INSERT INTO Usuario (nome, nascimento, formacao, assinatura, email, senha, foto, podeRedigir, podeRevisar, isAdmin)
VALUES ('Eduardo P.', '1990-05-15', 'Jornalismo', 'Admin', 'admin@jornalatlas.com', '$2y$12$sR3/URFV7z5XMhw29FCpJuPijxBWIFfcQ.HThhLdRZlwt1BhL2DVm', NULL, TRUE, TRUE, TRUE);

INSERT INTO Usuario (nome, nascimento, formacao, assinatura, email, senha, foto, podeRedigir, podeRevisar, isAdmin)
VALUES ('Maria Silva', '1995-08-22', 'Comunicação Social', 'Redatora', 'redator@jornalatlas.com', '$2y$12$LRG2KoeUHRyJn7JYn3Rn5eLVQByRCpPGsX.nJg2s8Fm06G4KcC5iC', NULL, TRUE, FALSE, FALSE);

-- ==================== NOTICIAS (HERO) ====================

INSERT INTO Noticia (redator_id, titulo, resumo, conteudo, imagem, categoria, secao, status, dataPublicacao)
VALUES (2, 'Impulsionamento digital, adesivos, peças na TV: veja onde partidos devem gastar os R$ 4,9 bilhões do Fundo Eleitoral',
'TSE distribuirá dinheiro a 30 partidos. Em 2022, o fundo bancou 87,9% das despesas dos presidenciáveis; despesas com TV e impulsionamento lideraram gastos.',
'Conteúdo completo da matéria sobre o Fundo Eleitoral e a distribuição entre os partidos políticos.',
'urna.jpg', 'POLÍTICA', 'hero', 'APROVADA', NOW());

INSERT INTO Noticia (redator_id, titulo, resumo, conteudo, imagem, categoria, secao, status, dataPublicacao)
VALUES (2, 'Copa: Uruguai desperta no 2º tempo e busca o empate contra a Arábia Saudita',
'Apesar de sair atrás no placar, equipe de Bielsa conseguiu se recuperar e garantir o 1 a 1 em Miami; por pouco, não virou.',
'Conteúdo completo da matéria sobre a partida do Uruguai na Copa do Mundo.',
'copa.jpg', 'ESPORTES', 'hero', 'APROVADA', NOW());

INSERT INTO Noticia (redator_id, titulo, resumo, conteudo, imagem, categoria, secao, status, dataPublicacao)
VALUES (2, 'SUS incorpora novo tratamento para leucemia mieloide aguda em adultos',
'Combinação de venetoclax e azacitidina será oferecida a adultos recém-diagnosticados com a doença; Ministério da Saúde tem até 180 dias para disponibilizar terapia na rede pública.',
'Conteúdo completo da matéria sobre o novo tratamento incorporado pelo SUS.',
'exame.jpg', 'SAÚDE', 'hero', 'APROVADA', NOW());

INSERT INTO Noticia (redator_id, titulo, resumo, conteudo, imagem, categoria, secao, status, dataPublicacao)
VALUES (2, '''Taxa das blusinhas'': governo volta a tributar compras internacionais de baixo valor em 2027, mas com imposto e alíquota diferentes',
'No lugar do imposto de importação de 20%, será cobrado imposto federal sobre consumo criado na reforma tributária. Valor será definido no fim do ano; Fazenda não comenta.',
'Conteúdo completo da matéria sobre a taxação de compras internacionais.',
'governo.jpg', 'ECONOMIA', 'hero', 'APROVADA', NOW());

-- ==================== NOTICIAS (NACIONAL) ====================

INSERT INTO Noticia (redator_id, titulo, resumo, conteudo, imagem, categoria, secao, status, dataPublicacao)
VALUES (2, 'Pesca em local proibido termina com apreensão 85 kg de peixes e multa de R$ 5,7 mil no interior de SP',
'Ocorrência foi registrada nesta segunda-feira (15), próximo à Cachoeira Salto Botelho, em Lucélia (SP). O pescado apreendido foi doado ao Lar São Vicente de Paulo do município.',
'Conteúdo completo da matéria sobre a pesca ilegal no interior de São Paulo.',
'noticia1.jpg', 'POLÍTICA', 'nacional', 'APROVADA', NOW());

INSERT INTO Noticia (redator_id, titulo, resumo, conteudo, imagem, categoria, secao, status, dataPublicacao)
VALUES (2, 'No Rio, Zema minimiza fala de Eduardo Bolsonaro sobre rompimento com o Novo e reafirma críticas a Flávio',
'Zema disse que não muda "nada" do que afirmou anteriormente sobre a relação de Flávio Bolsonaro e Daniel Vorcaro.',
'Conteúdo completo da matéria sobre as declarações de Zema no Rio.',
'noticia2.jpg', 'POLÍTICA', 'nacional', 'APROVADA', NOW());

INSERT INTO Noticia (redator_id, titulo, resumo, conteudo, imagem, categoria, secao, status, dataPublicacao)
VALUES (2, 'Nova espécie de flor descoberta no Brasil já nasce ameaçada de extinção',
'Registro feito durante uma trilha em Santa Catarina levou pesquisadores a identificar planta inédita para a ciência.',
'Conteúdo completo da matéria sobre a nova espécie de flor.',
'noticia3.jpg', 'CIÊNCIA', 'nacional', 'APROVADA', NOW());

INSERT INTO Noticia (redator_id, titulo, resumo, conteudo, imagem, categoria, secao, status, dataPublicacao)
VALUES (2, 'Museu Nacional ganha réplica de dinossauro brasileiro com 15 metros',
'Oxalaia quilombensis viveu no Maranhão há 95 milhões de anos.',
'Conteúdo completo da matéria sobre a réplica do dinossauro no Museu Nacional.',
'noticia4.jpg', 'CULTURA', 'nacional', 'APROVADA', NOW());

-- ==================== NOTICIAS (INTERNACIONAL) ====================

INSERT INTO Noticia (redator_id, titulo, resumo, conteudo, imagem, categoria, secao, status, dataPublicacao)
VALUES (2, 'Pizza Hut será vendida por US$ 2,7 bilhões após anos de queda nas vendas e fechamento de lojas',
'Em fevereiro, a controladora Yum Brands disse que já estudava vender a rede e fechar 250 restaurantes nos EUA, em meio ao aumento da concorrência e lojas consideradas ultrapassadas.',
'Conteúdo completo da matéria sobre a venda da Pizza Hut.',
'noticia5.jpg', 'ECONOMIA', 'internacional', 'APROVADA', NOW());

INSERT INTO Noticia (redator_id, titulo, resumo, conteudo, imagem, categoria, secao, status, dataPublicacao)
VALUES (2, 'Irã na Copa: após empatar com Nova Zelândia, seleção iraniana enfrenta entraves ao deixar os EUA',
'Capitão da seleção, Mehdi Taremi, e um auxiliar da equipe foram retidos no aeroporto de Los Angeles, onde o time jogou contra a Nova Zelândia.',
'Conteúdo completo da matéria sobre a seleção iraniana na Copa.',
'noticia6.jpg', 'ESPORTES', 'internacional', 'APROVADA', NOW());

INSERT INTO Noticia (redator_id, titulo, resumo, conteudo, imagem, categoria, secao, status, dataPublicacao)
VALUES (2, 'Eleições no Peru: com 99% das urnas apuradas, Keiko lidera disputa contra Sánchez',
'Com mais de 99% das urnas apuradas, os candidatos Roberto Sánchez e Keiko Fujimori ainda registram diferença de menos de 1 ponto percentual.',
'Conteúdo completo da matéria sobre as eleições no Peru.',
'noticia7.jpg', 'POLÍTICA', 'internacional', 'APROVADA', NOW());

INSERT INTO Noticia (redator_id, titulo, resumo, conteudo, imagem, categoria, secao, status, dataPublicacao)
VALUES (2, 'G7 amplia pressão sobre Rússia e Trump promete agir por acordo para encerrar guerra na Ucrânia',
'Os líderes do G7 defenderam nesta terça-feira (16) em Evian, na França, o aumento da pressão sobre a Rússia para encerrar a guerra na Ucrânia.',
'Conteúdo completo da matéria sobre o G7 e a guerra na Ucrânia.',
'noticia8.jpg', 'POLÍTICA', 'internacional', 'APROVADA', NOW());
