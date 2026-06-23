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

$revisorSenha = password_hash('revisor123', PASSWORD_DEFAULT);

$pdo->exec("
    INSERT INTO Usuario (nome, nascimento, formacao, assinatura, email, senha, foto, podeRedigir, podeRevisar, isAdmin)
    VALUES ('Maria Silva', '1995-08-22', 'Comunicação Social', 'Revisora', 'revisor@jornalatlas.com', '$revisorSenha', NULL, TRUE, TRUE, FALSE)
");

// ==================== NOTICIAS ====================

$stmt = $pdo->prepare("
    INSERT INTO Noticia (redator_id, titulo, resumo, conteudo, imagem, categoria, secao, status, dataPublicacao)
    VALUES (:redator_id, :titulo, :resumo, :conteudo, :imagem, :categoria, :secao, 'APROVADA', NOW())
");

$noticias = [

    // ==================== TECNOLOGIA (hero) ====================
    [
        'titulo' => 'Vazamento de dados: Apple e Tesla tiveram informações sigilosas expostas por falha em empresa indiana',
        'resumo' => 'Mais de 200 mil arquivos com dados sigilosos e segredos comerciais teriam sido vazados da Tata Electronics; hackers cobraram resgate pelas informações.',
        'conteudo' => '<p>A Tata Electronics informou que detectou um recente "incidente de segurança cibernética", após pesquisadores afirmarem que o World Leaks publicou supostos documentos de design e especificação de componentes da Apple e da Tesla. O grupo de ransomware publicou mais de 200 mil arquivos na dark web, totalizando mais de 630 gigabytes.</p><p>A Apple estava investigando a violação e uma "análise completa estava em andamento". A Tata responde atualmente por cerca de um terço da produção de iPhones da Apple na Índia. Os arquivos continham e-mails, registros de eventos e cópias de passaportes de funcionários, além de documentos marcados como "segredo comercial" da Tesla.</p><p>A violação destaca a vulnerabilidade das empresas globais a ataques cibernéticos cada vez mais sofisticados. A Tata já havia sido atingida por um ataque cibernético em seu grupo britânico Jaguar Land Rover no ano passado.</p>',
        'imagem' => 'tech-vazamento.jpg',
        'categoria' => 'TECNOLOGIA',
        'secao' => 'hero',
    ],

    // ==================== TECNOLOGIA ====================
    [
        'titulo' => 'Tesla apresentou dados enganosos para aprovar carros autônomos na Europa, diz agência',
        'resumo' => 'Empresa apresentou estatísticas próprias a reguladores europeus para aprovar o sistema FSD, enquanto especialistas apontam comparações problemáticas.',
        'conteudo' => '<p>Em seus esforços para obter a aprovação europeia do sistema "Full Self-Driving" (FSD), a Tesla apresentou às autoridades reguladoras da Suécia e da Holanda estatísticas de segurança que, segundo pesquisadores, configurariam marketing enganoso. Os dados foram elaborados pela própria empresa.</p><p>A apresentação afirmava que o FSD poderia ter salvo 32 mil vidas e evitado 1,9 milhão de feridos. Pesquisadores ouvidos pela Reuters afirmaram que esses números são altamente enganosos, pois se baseiam na suposição irrealista de que todos os veículos dos EUA seriam substituídos por carros Tesla equipados com o sistema.</p><p>A RDW aprovou o uso do FSD na Holanda em abril, e agora busca aprovação em toda a União Europeia. O Conselho Europeu de Segurança nos Transportes afirmou estar "certamente preocupado" com o fato de a Tesla ter apresentado dados não confiáveis.</p>',
        'imagem' => 'tech-tesla.jpg',
        'categoria' => 'TECNOLOGIA',
        'secao' => 'nacional',
        'redator_id' => 2,
    ],
    [
        'titulo' => 'Big techs são condenadas por falha na proteção de crianças em jogos eletrônicos',
        'resumo' => 'Indenizações somam cerca de R$ 300 milhões; Apple, Google e Microsoft são citadas por uso de loot boxes que exploram vulnerabilidade de menores.',
        'conteudo' => '<p>A 1ª Vara da Infância e da Juventude do Distrito Federal condenou grandes empresas por uso de loot boxes — caixas surpresas que oferecem recompensas mediante pagamento — por explorar a vulnerabilidade de crianças e adolescentes. A indenização total ultrapassa R$ 300 milhões.</p><p>Entre as empresas condenadas estão Apple (R$ 50 milhões), Microsoft (R$ 50 milhões), Tencent (R$ 50 milhões), Google (R$ 40 milhões) e Sony (R$ 40 milhões). A juíza aponta relação entre as loot boxes e problemas com jogos de azar, além de gerar compulsão em crianças.</p><p>As empresas também devem adotar medidas como inclusão de advertência expressa, divulgação de probabilidades e implementação de verificação de idade. Em caso de descumprimento, há previsão de multa diária de R$ 100 mil.</p>',
        'imagem' => 'tech-games.jpg',
        'categoria' => 'TECNOLOGIA',
        'secao' => 'nacional',
        'redator_id' => 2,
    ],
    [
        'titulo' => 'Grupo hacker diz ter roubado 1,3 TB de dados sobre medicamentos da dona do Ozempic',
        'resumo' => 'FulcrumSec afirmou ter acesso a dados de milhares de pacientes e funcionários da Novo Nordisk após invasão que durou dois meses.',
        'conteudo' => '<p>O grupo hacker FulcrumSec afirmou que roubou 1,3 terabyte de dados da farmacêutica Novo Nordisk, conhecida por tratamentos como Ozempic e Wegovy. O grupo disse que considera vender parte dos dados após não ter sucesso em cobrar US$ 25 milhões para devolver o material.</p><p>Os hackers atacaram os sistemas da Novo Nordisk em março e permaneceram infiltrados por dois meses, conseguindo uma lista com mais de 700 mil arquivos. O ataque envolveu acesso a dados de 11.500 pacientes de testes clínicos e de milhares de funcionários.</p><p>A Novo Nordisk comunicou que sofreu um incidente de segurança cibernética e está em contato com as autoridades. O grupo afirmou não pretende compartilhar dados de funcionários e pacientes.</p>',
        'imagem' => 'tech-novo-nordisk.jpg',
        'categoria' => 'TECNOLOGIA',
        'secao' => 'nacional',
    ],
    [
        'titulo' => 'OpenAI derrota ação da xAI de Elon Musk sobre suposto roubo de segredos comerciais',
        'resumo' => 'Juíza concluiu que a empresa de Musk não apresentou provas de que a OpenAI obteve informações confidenciais de forma indevida.',
        'conteudo' => '<p>Uma juíza federal dos Estados Unidos rejeitou a ação movida pela xAI, de Elon Musk, que acusava a OpenAI de se apropriar de segredos comerciais. A magistrada Rita Lin afirmou que a xAI não comprovou que a OpenAI incentivou o ex-engenheiro Xuechen Li a obter informações confidenciais indevidamente.</p><p>A ação, iniciada em setembro do ano passado, alegava que ex-funcionários levaram códigos-fonte confidenciais relacionados ao chatbot Grok para a OpenAI. A juíza encerrou o processo definitivamente por considerar uma nova tentativa "inútil".</p><p>Esta é a segunda derrota judicial de Musk contra a OpenAI em quatro semanas. Em maio, um júri federal decidiu contra o homem mais rico do mundo em seu processo de US$ 150 bilhões contra a empresa de Sam Altman.</p>',
        'imagem' => 'tech-openai.jpg',
        'categoria' => 'TECNOLOGIA',
        'secao' => 'internacional',
    ],

    // ==================== ECONOMIA (hero) ====================
    [
        'titulo' => 'Dólar cai a R$ 5,14 com foco no exterior e expectativa por ata do Copom; Ibovespa sobe',
        'resumo' => 'A moeda americana recuou 0,46%, cotada a R$ 5,1413. O principal índice da bolsa brasileira subiu 1,21%, aos 170.365 pontos.',
        'conteudo' => '<p>O dólar fechou em queda nesta segunda-feira, com recuo de 0,46%, cotado a R$ 5,1413. Na mínima do dia, a moeda chegou a R$ 5,1234. O Ibovespa encerrou o pregão em alta de 1,31%, aos 170.365 pontos, impulsionado pelas negociações entre EUA e Irã na Suíça.</p><p>As negociações entre os EUA e o Irã continuam a mexer com os mercados. Representantes dos dois países avançaram nas conversas, o que ajudou a conter os preços do petróleo. No fechamento, o barril do Brent recuou 3,31%, a US$ 77,90.</p><p>Na agenda desta semana, destaque para dados de inflação no Brasil e nos EUA, índices PMI e a ata da última reunião do Banco Central. A renúncia do primeiro-ministro britânico Keir Starmer e as eleições na Colômbia também seguem na mira dos investidores.</p>',
        'imagem' => 'eco-dolar.jpg',
        'categoria' => 'ECONOMIA',
        'secao' => 'hero',
    ],

    // ==================== ECONOMIA ====================
    [
        'titulo' => 'Mercado eleva previsão de inflação para 2026 e projeta só mais um corte de juros',
        'resumo' => 'Expectativas do Boletim Focus apontam inflação de 5,33% em 2026, décima quinta semana seguida de aumento. Mercado projeta taxa Selic a 14% em agosto.',
        'conteudo' => '<p>O mercado financeiro elevou sua estimativa média para a inflação em 2026, que avançou para 5,33%. A explicação é que a guerra no Oriente Médio fez disparar o preço do petróleo, que tem potencial de pressionar a inflação brasileira via aumento dos combustíveis.</p><p>Os economistas passaram a projetar somente mais um corte de juros em 2026, para 14% ao ano, na reunião do Copom de agosto. Antes da guerra entre EUA e Irã, os economistas acreditavam que a taxa terminaria este ano em 12,5% ao ano.</p><p>Para o crescimento do PIB de 2026, a estimativa subiu para 1,98%. A projeção para a taxa de câmbio ao fim deste ano permaneceu em R$ 5,20 por dólar.</p>',
        'imagem' => 'eco-mercado.jpg',
        'categoria' => 'ECONOMIA',
        'secao' => 'nacional',
        'redator_id' => 2,
    ],
    [
        'titulo' => 'Empresas americanas afirmam que Brasil é insubstituível e tentam barrar taxa de 25% de Trump',
        'resumo' => 'Companhias dos setores de mineração, madeira e construção solicitaram isenções ao USTR, argumentando que dependem de insumos vindos do mercado brasileiro.',
        'conteudo' => '<p>Até mesmo empresas americanas que dependem de importações brasileiras passaram a pressionar Washington para retirar os produtos da lista de sobretaxas. Elas argumentam que não há fornecedores em outros países capazes de substituir o Brasil em qualidade, escala e preço.</p><p>A GeoCentral, atacadista de pedras semipreciosas de Ohio, pediu formalmente inclusão na lista de isenção. A empresa compra mais de 25% de seu portfólio do Brasil. No total, ao menos 12 empresas e entidades enviaram manifestações ao USTR contestando a sobretaxa.</p><p>As sobretaxas impostas pelos EUA chegaram a 50% sobre parte dos produtos brasileiros em 2025. O governo brasileiro atua em duas frentes: contestação técnica e negociação diplomática. A audiência pública está marcada para 6 de julho.</p>',
        'imagem' => 'eco-tarifas.jpg',
        'categoria' => 'ECONOMIA',
        'secao' => 'nacional',
    ],
    [
        'titulo' => 'UE diz que oferece proposta mais vantajosa ao Brasil na disputa por minerais críticos',
        'resumo' => 'Comissário europeu afirma que proposta do bloco prevê investimentos em refino e tecnologia para agregar valor à produção brasileira de terras raras.',
        'conteudo' => '<p>A União Europeia aposta no Brasil como parceiro estratégico na disputa por minerais críticos e afirma ter uma proposta mais "benéfica" do que a de outros atores. O comissário Jozef Síkela visitou o centro de processamento de terras raras da Viridis Mining em Poços de Caldas (MG).</p><p>A Viridis planeja investir US$ 360 milhões para construir planta comercial com capacidade de 15 mil toneladas de carbonato de terras raras por ano a partir de 2028. Um acordo com a química belga Solvay pode ser fechado até julho.</p><p>O Brasil conta com a segunda maior reserva global de terras raras. A estratégia europeia busca reduzir dependências na cadeia de suprimentos, após choques como a pandemia e a guerra na Ucrânia.</p>',
        'imagem' => 'eco-minerais.jpg',
        'categoria' => 'ECONOMIA',
        'secao' => 'nacional',
    ],
    [
        'titulo' => 'Banco Central amplia acesso a contas em moeda estrangeira no Brasil; veja o que muda',
        'resumo' => 'Nova regra permitirá que exportadores e empresas com capital estrangeiro movimentem recursos em dólar sem necessidade de operação de câmbio em algumas situações.',
        'conteudo' => '<p>O Banco Central anunciou novas regras que ampliam o acesso a contas em moeda estrangeira no Brasil. A medida faz parte da regulamentação do Marco Legal do Câmbio e entra em vigor em 1º de outubro de 2026.</p><p>Com as novas regras, empresas exportadoras, com dívidas no exterior e com participação de investidores estrangeiros poderão manter contas em dólar e outras moedas. Algumas transferências entre essas contas poderão ser feitas sem operação de câmbio.</p><p>Os benefícios incluem mais facilidade para administrar recursos do exterior, melhor gerenciamento de oscilações cambiais e redução de custos em operações internacionais. A mudança não altera a proibição de uso de moedas estrangeiras para pagamentos no dia a dia.</p>',
        'imagem' => 'eco-banco-central.jpg',
        'categoria' => 'ECONOMIA',
        'secao' => 'internacional',
        'redator_id' => 2,
    ],
    [
        'titulo' => 'Taxa das blusinhas: governo volta a tributar compras internacionais de baixo valor em 2027',
        'resumo' => 'No lugar do imposto de importação de 20%, será cobrado CBS — tributo federal criado na reforma tributária. Alíquota estimada é de 9,43%.',
        'conteudo' => '<p>A taxação de encomendas com valor abaixo de US$ 50, zerada neste ano com o fim da "taxa das blusinhas", retornará em 2027 por meio da CBS — tributo federal criado no âmbito da reforma tributária sobre o consumo.</p><p>O valor da CBS está sendo calculado pela Receita Federal e será fixado por resolução do Senado em dezembro. A alíquota estimada é de 9,43% em 2027. A CBS terá a mesma lógica para produtos nacionais e importados.</p><p>Além da CBS, os estados continuarão taxando as encomendas com ICMS de 17% a 20%. A "taxa das blusinhas" havia sido instituída em agosto de 2024 e revogada em maio deste ano em meio à corrida eleitoral.</p>',
        'imagem' => 'eco-blusinhas.jpg',
        'categoria' => 'ECONOMIA',
        'secao' => 'internacional',
    ],

    // ==================== SAÚDE (hero) ====================
    [
        'titulo' => 'Ministério da Saúde volta a incluir reforço contra pólio aos 4 anos no calendário infantil',
        'resumo' => 'A partir de agosto de 2026, crianças de 4 anos receberão segundo reforço contra poliomielite, utilizando exclusivamente a vacina injetável (VIP).',
        'conteudo' => '<p>O Ministério da Saúde oficializou a volta do segundo reforço contra a poliomielite para crianças de 4 anos, a partir de 3 de agosto de 2026. O esquema vacinal agora terá cinco aplicações: três doses da VIP aos 2, 4 e 6 meses, um reforço aos 15 meses e outro aos 4 anos.</p><p>A decisão de utilizar exclusivamente a vacina injetável segue recomendação da OMS, que apontou que a vacina oral (VOP) podia, em casos extremamente raros, causar paralisia. Segundo especialistas, a VIP produz resposta imunológica mais robusta.</p><p>A retomada do reforço busca prolongar a proteção das crianças, especialmente em cenário de coberturas vacinais abaixo da meta de 95%. O Brasil não registra caso de poliomielite desde 1989 e é certificado como área livre do poliovírus selvagem desde 1994.</p>',
        'imagem' => 'saude-polio.jpg',
        'categoria' => 'SAÚDE',
        'secao' => 'hero',
    ],

    // ==================== SAÚDE ====================
    [
        'titulo' => 'Copa do Mundo coloca autoridades em alerta para surtos de doenças; sarampo lidera preocupações',
        'resumo' => 'Movimentação de milhões de torcedores nos EUA, Canadá e México gera temor de surtos. Sarampo já matou mais de 2 mil pessoas no mundo em 2026.',
        'conteudo' => '<p>Enquanto milhões de torcedores acompanham os jogos da Copa do Mundo, autoridades sanitárias dos EUA, Canadá e México correm para evitar que o torneio se torne catalisador para surtos de doenças infecciosas. O sarampo é a principal preocupação.</p><p>Além do sarampo, autoridades monitoram norovírus, hepatite A, rotavírus e doenças transmitidas por mosquitos como dengue e chikungunya. A estratégia inclui vigilância de águas residuais para detectar material genético de vírus dias antes dos primeiros pacientes.</p><p>O desafio ocorre em momento delicado para a saúde pública americana, com os CDC enfrentando restrições orçamentárias. Especialistas orientam torcedores a manter vacinação em dia e adotar medidas básicas de higiene.</p>',
        'imagem' => 'saude-copa.jpg',
        'categoria' => 'SAÚDE',
        'secao' => 'nacional',
        'redator_id' => 2,
    ],
    [
        'titulo' => 'Um em cada quatro brasileiros ignora que o câncer pode ser prevenido, revela estudo inédito',
        'resumo' => 'Pesquisa revela que 27% dos adultos brasileiros não sabem que a doença pode ser prevenida, apesar de até 40% dos casos serem evitáveis.',
        'conteudo' => '<p>O Brasil deve registrar 781 mil novos casos de câncer por ano entre 2026 e 2028. Ainda assim, 27% dos adultos brasileiros não sabem que a doença pode ser prevenida. O tabagismo lidera o conhecimento como fator de risco (90,5%), mas sedentarismo e alimentação são menos reconhecidos.</p><p>Mais de 61% dos entrevistados acreditam que suplementos de vitaminas reduzem o risco de câncer, o que não tem evidências científicas. Jovens de até 24 anos concentram os piores indicadores de conhecimento sobre prevenção.</p><p>O estudo também revelou que 45% dos entrevistados relatam consumir ultraprocessados regularmente. Os autores defendem campanhas, taxação de ultraprocessados e fortalecimento dos serviços de saúde.</p>',
        'imagem' => 'saude-cancer.jpg',
        'categoria' => 'SAÚDE',
        'secao' => 'nacional',
    ],
    [
        'titulo' => 'Quase 30% das mortes por influenza no Brasil em 2026 foram registradas nas últimas 2 semanas',
        'resumo' => '136 óbitos associados aos vírus Influenza A e B foram confirmados nas duas últimas semanas. Campanha de vacinação encerrou com apenas 38,5% de cobertura.',
        'conteudo' => '<p>Até maio de 2026, 506 mortes por síndrome respiratória aguda grave associadas aos vírus Influenza foram registradas no Brasil. Desse total, 136 mortes foram confirmadas apenas nas duas últimas semanas.</p><p>O Brasil já registrou 7.749 casos de SRAG por influenza em 2026, superando os 6.250 registrados no mesmo período de 2025. A campanha nacional de vacinação encerrou com apenas 38,5% de cobertura, bem abaixo da meta de 90%.</p><p>Especialistas apontam que a antecipação da sazonalidade viral e a baixa adesão à vacinação, impulsionada por desinformação pós-pandemia, contribuíram para o aumento de internações.</p>',
        'imagem' => 'saude-influenza.jpg',
        'categoria' => 'SAÚDE',
        'secao' => 'nacional',
        'redator_id' => 2,
    ],
    [
        'titulo' => 'SUS incorpora novo tratamento para leucemia mieloide aguda em adultos',
        'resumo' => 'Combinação de venetoclax e azacitidina será oferecida a adultos recém-diagnosticados; Ministério tem até 180 dias para disponibilizar terapia.',
        'conteudo' => '<p>O Ministério da Saúde incorporou ao SUS o uso do venetoclax em combinação com azacitidina para o tratamento de adultos com leucemia mieloide aguda recém-diagnosticada que não podem ser submetidos à quimioterapia intensiva.</p><p>A incorporação contempla pacientes considerados inelegíveis para esquemas convencionais, geralmente por idade avançada ou fragilidade clínica. O venetoclax bloqueia proteínas que ajudam as células tumorais a sobreviver.</p><p>A leucemia mieloide aguda é um câncer que se origina na medula óssea. Os sintomas incluem cansaço intenso, palidez, febre persistente e hematomas espontâneos.</p>',
        'imagem' => 'saude-leucemia.jpg',
        'categoria' => 'SAÚDE',
        'secao' => 'internacional',
    ],

    // ==================== ESPORTES (hero) ====================
    [
        'titulo' => 'Messi supera Klose e é o maior artilheiro da história das Copas do Mundo',
        'resumo' => 'Lionel Messi marcou dois gols contra a Áustria, atingindo 18 gols em Copas e superando o recorde do alemão Miroslav Klose (16).',
        'conteudo' => '<p>Lionel Messi é oficialmente o maior artilheiro da história das Copas do Mundo. O craque argentino marcou dois gols na vitória por 2 a 0 sobre a Áustria, se isolando no recorde com 18 gols. Em sua sexta participação em Mundiais, o camisa 10 da Argentina soma 5 gols em 2 jogos nesta edição.</p><p>Esta é a melhor Copa de Messi em termos de média de gols: já são 5 gols em apenas 2 jogos, superando os 7 gols em 7 partidas da campanha do título em 2022.</p><p>Na trajetória em Mundiais, o argentino marcou 1 gol em 2006, 0 em 2010, 4 em 2014, 1 em 2018, 7 em 2022 e agora 5 em 2026.</p>',
        'imagem' => 'esp-messi.jpg',
        'categoria' => 'ESPORTES',
        'secao' => 'hero',
    ],

    // ==================== ESPORTES ====================
    [
        'titulo' => 'Flamengo abre venda de ingressos para amistosos da intertemporada em Portugal',
        'resumo' => 'Clube enfrentará River Plate, Lausanne-Sport e Benfica no Estádio do Algarve, com preços entre 11 e 44 euros.',
        'conteudo' => '<p>O Flamengo divulgou a venda de ingressos para os amistosos da intertemporada em julho no Estádio do Algarve, em Portugal. Os preços variam de 11 a 44 euros. As partidas contra River Plate e Lausanne terão o setor Poente Superior disponível caso os outros setores se esgotem.</p><p>A delegação rubro-negra embarca para Portugal no dia 28 de junho. A primeira etapa dos treinamentos acontecerá em Lagos, entre 29 de junho e 5 de julho, e depois o grupo seguirá para Estoi até 12 de julho.</p><p>O primeiro amistoso será contra o River Plate, em 3 de julho, às 15h30 (horário de Brasília).</p>',
        'imagem' => 'esp-flamengo.jpg',
        'categoria' => 'ESPORTES',
        'secao' => 'nacional',
        'redator_id' => 2,
    ],
    [
        'titulo' => 'Brasileirão Série A: CBF divulga tabela detalhada das rodadas 19 a 24',
        'resumo' => 'Quatro jogos ocorrerão antes da final da Copa do Mundo; destaque para Flamengo x São Paulo no Maracanã pela 20ª rodada.',
        'conteudo' => '<p>A Confederação Brasileira de Futebol divulgou a tabela detalhada das rodadas 19 a 24 do Brasileirão. A 19ª rodada terá quatro jogos antes da final da Copa do Mundo, em 16 e 17 de julho, incluindo Botafogo x Santos e Fluminense x Bragantino.</p><p>Destaques incluem o Flamengo x São Paulo no Maracanã pela 20ª rodada, Palmeiras x Atlético-MG no Allianz Parque, e o Clássico do Rio entre Botafogo e Fluminense na 22ª rodada.</p><p>A 24ª rodada tem o Cruzeiro x Flamengo no Mineirão como grande confronto, em 22 de agosto.</p>',
        'imagem' => 'esp-brasileirao.jpg',
        'categoria' => 'ESPORTES',
        'secao' => 'nacional',
    ],
    [
        'titulo' => 'Campeã de Wimbledon pega quatro anos de suspensão por se recusar a fazer teste antidoping',
        'resumo' => 'Marketa Vondrousova foi suspensa pela ITIA após se recusar a fornecer amostra fora de competição em dezembro de 2025.',
        'conteudo' => '<p>A campeã de Wimbledon de 2023, Marketa Vondrousova, foi suspensa por quatro anos após se recusar a fornecer amostra para teste antidoping fora de competição. A Agência Internacional de Integridade do Tênis informou que as justificativas da atleta — estresse e preocupações com segurança — não foram consideradas convincentes.</p><p>A suspensão terá validade até 21 de junho de 2030. Em publicação nas redes sociais, Vondrousova afirmou que jamais utilizou substâncias proibidas e destacou que um exame realizado três dias após o episódio teve resultado negativo.</p><p>Aos 26 anos, a tcheca soma duas finais de Grand Slam na carreira.</p>',
        'imagem' => 'esp-tenis.jpg',
        'categoria' => 'ESPORTES',
        'secao' => 'internacional',
    ],
    [
        'titulo' => 'Skate: após três meses sem competir, Rayssa Leal fica fora do pódio em Roma',
        'resumo' => 'A Fadinha voltou à final da Copa do Mundo de skate street, mas terminou em quinto lugar com 142.55 pontos.',
        'conteudo' => '<p>Rayssa Leal retornou às competições após três meses sem competir devido a lesão no joelho direito sofrida em março em São Paulo. A skatista chegou à final da Copa do Mundo de Roma, mas sofreu com quedas e terminou em quinto lugar geral, com 142.55 pontos.</p><p>A australiana Chloe Covell defendeu seu título e assegurou o bicampeonato consecutivo, com 177.01 pontos — mais de 20 pontos de diferença da vice.</p><p>No masculino, o Brasil também ficou fora do pódio, com Wallace Gabriel em quinto e Giovanni Vianna em oitavo.</p>',
        'imagem' => 'esp-rayssa.jpg',
        'categoria' => 'ESPORTES',
        'secao' => 'internacional',
        'redator_id' => 2,
    ],

    // ==================== MUNDO (hero) ====================
    [
        'titulo' => 'Primeiro-ministro do Reino Unido, Keir Starmer, anuncia que irá renunciar ao cargo',
        'resumo' => 'Um novo líder trabalhista deverá assumir até o retorno do Parlamento em setembro. Pressão aumentou após derrota em eleição suplementar.',
        'conteudo' => '<p>O primeiro-ministro do Reino Unido, Keir Starmer, anunciou nesta segunda-feira que renunciará ao cargo. Um novo líder deverá assumir até o retorno do Parlamento britânico do recesso, em setembro. Starmer conversou com o rei Charles e afirmou que deseja uma transição de poder tranquila.</p><p>A pressão contra Starmer vinha aumentando há meses e se intensificou após Andy Burnham conquistar uma cadeira no Parlamento na quinta-feira. A vitória reacendeu a esperança de que Burnham possa revitalizar o partido.</p><p>Com a saída de Starmer, o Reino Unido terá seu sétimo chefe de governo em dez anos. Os indicadores de popularidade do governo eram os piores desde 2009, segundo pesquisa.</p>',
        'imagem' => 'mundo-starmer.jpg',
        'categoria' => 'MUNDO',
        'secao' => 'hero',
    ],

    // ==================== MUNDO ====================
    [
        'titulo' => 'Meloni chama ataques de Trump de "sem sentido" e provoca após fala sobre popularidade',
        'resumo' => 'Primeira-ministra da Itália rebateu críticas de Trump; chanceler italiano cancelou viagem aos EUA e relação entre os dois líderes piorou.',
        'conteudo' => '<p>A primeira-ministra italiana Giorgia Meloni voltou a rebater o que chamou de ataques "sem sentido" do presidente dos EUA, Donald Trump. Depois de negar que tenha implorado para tirar uma foto com Trump, Meloni provocou: "Sugiro que você se concentre na sua".</p><p>Trump afirmou que o "nível de popularidade dela está em baixa na Itália" e reclamou do fato do governo italiano não ter permitido que os EUA usassem bases militares na guerra contra o Irã. A taxa de aprovação de Trump caiu para 35%.</p><p>O atrito político vinha se intensificando desde abril, quando Meloni criticou Trump por ter chamado o papa Leão XIV de "fraco" ao condenar a guerra no Irã.</p>',
        'imagem' => 'mundo-meloni.jpg',
        'categoria' => 'MUNDO',
        'secao' => 'internacional',
        'redator_id' => 2,
    ],
    [
        'titulo' => 'Trump diz que Estreito de Ormuz está "totalmente aberto" após negociações com Irã',
        'resumo' => 'Afirmação veio após 1ª rodada de negociações EUA-Irã rumo a acordo de paz. Irã concordou em estabelecer linha de comunicação para evitar conflitos.',
        'conteudo' => '<p>O presidente dos EUA, Donald Trump, declarou que o Estreito de Ormuz, importante via marítima por onde passam cerca de 20% do petróleo mundial, está "totalmente aberto". A afirmação ocorreu no dia seguinte à primeira rodada de negociações entre EUA e Irã.</p><p>O Estreito de Ormuz foi reaberto oficialmente na quarta-feira passada, mas ataques de Israel no Líbano fizeram com que Teerã fechasse novamente a passagem no sábado. A questão parece ter sido contornada.</p><p>O principal negociador do Irã afirmou que finalizou os preparativos para a liberação de US$ 12 bilhões em ativos iranianos congelados. As tratativas tiveram atmosfera positiva.</p>',
        'imagem' => 'mundo-ormuz.jpg',
        'categoria' => 'MUNDO',
        'secao' => 'internacional',
    ],
    [
        'titulo' => 'Eleições na Colômbia: candidato de Petro diz que pedirá recontagem de votos',
        'resumo' => 'Iván Cepeda anunciou que pedirá impugnação de 33 mil mesas eleitorais após apuração preliminar indicar vitória do candidato de direita.',
        'conteudo' => '<p>O candidato esquerdista Iván Cepeda anunciou que seu partido pedirá a impugnação de 33 mil mesas eleitorais, após a apuração preliminar indicar a vitória de Abelardo de la Espriella, candidato da direita apoiado por Trump. A diferença é de cerca de 250 mil votos.</p><p>A Colômbia voltou às urnas para o 2º turno das eleições presidenciais. Espriella celebrou a vitória com camiseta da seleção colombiana e defendeu acordos militares com os EUA para combater o crime organizado.</p><p>O triunfo do direitista representa uma guinada no país após o governo Petro, primeiro presidente de esquerda da história da Colômbia.</p>',
        'imagem' => 'mundo-colombia.jpg',
        'categoria' => 'MUNDO',
        'secao' => 'internacional',
        'redator_id' => 2,
    ],
    [
        'titulo' => 'Ataques seguem no Líbano apesar de cessar-fogo com Israel; 16 pessoas morreram',
        'resumo' => 'Defesa Civil libanesa confirmou 16 mortos em ataques israelenses no sábado, poucas horas após entrada em vigor do cessar-fogo.',
        'conteudo' => '<p>A Defesa Civil do Líbano afirmou que 16 pessoas morreram em ataques de Israel neste sábado, poucas horas após a entrada em vigor de um cessar-fogo. Os ataques atingiram a cidade de Nabatiyeh e vilarejos próximos.</p><p>O Exército israelense disse que estava respondendo a projéteis disparados pelo Hezbollah, que teria lançado mais de 50 projéteis contra tropas israelenses durante a noite. O número de mortos no conflito com Israel ultrapassou 4 mil.</p><p>O Hezbollah afirmou que respeitará um cessar-fogo caso Israel faça o mesmo. Catar, EUA e Irã estavam trabalhando para mediar a trégua.</p>',
        'imagem' => 'mundo-libano.jpg',
        'categoria' => 'MUNDO',
        'secao' => 'internacional',
    ],

    // ==================== CULTURA (hero) ====================
    [
        'titulo' => 'Gorillaz: como é o show atual da banda que vem ao Primavera Sound São Paulo',
        'resumo' => 'O Gorillaz é o headliner do Primavera Sound SP em dezembro de 2026. Show em Barcelona foi considerado grandioso e meditativo.',
        'conteudo' => '<p>O Gorillaz se apresentou no Primavera Sound Barcelona e o show foi considerado um dos melhores da edição. Na prática, os personagens fictícios aparecem nos telões, enquanto músicos de verdade sobem no palco, incluindo Damon Albarn — que se jogou na galera e cantou em walkie-talkie.</p><p>A banda vem com repertório atualizado pelo álbum "The Mountain", influenciado por música indiana e com pegada espiritual, trazendo cítaras, flautas e coro de cantores. Em Barcelona, houve convidados como Little Simz e Moonchild Sanelly.</p><p>Em comparação com a última vinda ao Brasil em 2022, o show está mais grandioso, estruturado e psicodélico. Sucessos como "Feel Good Inc" ganharam arranjos renovados.</p>',
        'imagem' => 'cult-gorillaz.jpg',
        'categoria' => 'CULTURA',
        'secao' => 'hero',
    ],

    // ==================== CULTURA ====================
    [
        'titulo' => 'Músicas de Humberto Gessinger têm questões existenciais diluídas no tom forrozeiro',
        'resumo' => 'Álbum "Nordestina highway" reúne sete artistas nordestinos que reinterpretam canções do compositor em arranjos de forró.',
        'conteudo' => '<p>O álbum "Nordestina highway" transporta a obra existencialista de Humberto Gessinger — mentor dos Engenheiros do Hawaii — para o universo dançante do forró. Produzido por Marcelinho Macedo em João Pessoa, o disco traz sete faixas regravadas por artistas nordestinos.</p><p>Entre os destaques, Lucy Alves carrega a ansiedade de "Eu que não amo você", enquanto Sandra Belê expressa em "Depois da curva" o sentimento de esperança. Beto Brito evoca a prosódia de Zé Ramalho na interpretação de "Revolta dos dândis I".</p><p>O disco está previsto para lançamento em 25 de junho e recebeu 3 estrelas da crítica.</p>',
        'imagem' => 'cult-gessinger.jpg',
        'categoria' => 'CULTURA',
        'secao' => 'nacional',
        'redator_id' => 2,
    ],
    [
        'titulo' => 'Mestre Ambrósio tem contribuição à cena pernambucana posta em foco em documentário',
        'resumo' => 'Filme "Quando a gente vira um" conta a história do grupo que surgiu em 1992 e conectou o movimento Armorial à geração Manguebeat.',
        'conteudo' => '<p>O Mestre Ambrósio surgiu em 1992 no Recife, quando músicos se alimentaram da cultura musical da Zona da Mata Norte de Pernambuco, adotando maracatu rural e cavalo marinho como matérias-primas. O grupo gravitou em torno do Manguebeat sem ficar intrinsecamente associado a ele.</p><p>O documentário de 126 minutos parte do Recife dos anos 1990 para contextualizar o surgimento do grupo, com imagens de arquivo inéditas e entrevistas. Com depoimentos de Lenine e Marina Person, o filme mostra como o grupo contribuiu para que o Brasil percebesse a força da cultura popular pernambucana.</p><p>O In-Edit Brasil tem sessões do filme programadas para os dias 22 e 28 de junho em São Paulo.</p>',
        'imagem' => 'cult-ambrosio.jpg',
        'categoria' => 'CULTURA',
        'secao' => 'nacional',
    ],
    [
        'titulo' => 'Gilberto Gil perpetua turnê "Tempo rei" em álbum ao vivo com quatro volumes',
        'resumo' => 'Gil lança primeiro volume do álbum audiovisual no dia 26 de junho, data de seu 84º aniversário. Show retrospectivo percorreu arenas do Brasil.',
        'conteudo' => '<p>De março de 2025 a março de 2026, Gilberto Gil percorreu arenas e estádios do Brasil com o show retrospectivo "Tempo rei", alardeado como a última grande excursão do artista. O show será perpetuado em álbum ao vivo em quatro volumes.</p><p>O primeiro volume traz oito faixas do roteiro quase inteiramente autoral, incluindo "Palco", "Banda um", "Tempo rei" e "Cálice". As músicas foram gravadas em São Paulo, Fortaleza, Belo Horizonte, Rio de Janeiro e Belém.</p><p>O quarto volume está previsto para novembro, quando chegará uma caixa com edições dos quatro discos em LP.</p>',
        'imagem' => 'cult-gil.jpg',
        'categoria' => 'CULTURA',
        'secao' => 'nacional',
    ],
    [
        'titulo' => 'Maria Bethânia 80 anos: cantora doma os palcos com presença magnética em seis décadas',
        'resumo' => 'A cantora completou 80 anos cercada de louvações. Desde "Opinião" em 1965, Bethânia se impôs como senhora da cena brasileira.',
        'conteudo' => '<p>Maria Bethânia completou 80 anos em 18 de junho. É nos palcos que a intérprete se manifesta em toda plenitude. Desde sua estreia em 1965, ao cantar "Carcará" no show "Opinião", Bethânia se impôs como senhora da cena, transitando de boates a estádios.</p><p>Com auxílio do diretor Fauzi Arap, Bethânia cristalizou um molde de espetáculo conceitual em que músicas e textos se costuram em roteiros que jamais perdem o fio da meada. Espetáculos como "Nossos momentos" (1982) e "Abraçar e agradecer" (2015) sobressaem na trajetória.</p><p>Bethânia sempre soube que um show jamais pode ser mera reprodução de um disco, e é essa inteligência cênica que a mantém magnética em seis décadas de carreira.</p>',
        'imagem' => 'cult-bethania.jpg',
        'categoria' => 'CULTURA',
        'secao' => 'internacional',
        'redator_id' => 2,
    ],

    // ==================== CIÊNCIA (hero) ====================
    [
        'titulo' => 'Vírus gigantes podem ter ajudado a moldar as células que deram origem a animais e plantas',
        'resumo' => 'Estudo na Nature revela que células complexas surgiram por alianças entre micróbios e vírus gigantes, contestando teoria tradicional.',
        'conteudo' => '<p>Um estudo publicado na revista "Nature" sugere que as células complexas que formam o corpo de animais, plantas e fungos surgiram aos poucos, fruto de uma sucessão de "alianças" entre diferentes micróbios — e que até vírus gigantes podem ter participado do processo.</p><p>O trabalho identificou marcas genéticas dos grupos bacterianos Planctomycetota e Myxococcota, que contribuíram em diferentes momentos para a formação dessas células há 2 bilhões de anos. Genes de vírus gigantes também foram incorporados.</p><p>Cientistas usaram o supercomputador MareNostrum por mais de 5 anos para reconstruir o genoma do ancestral comum de todos os eucariontes.</p>',
        'imagem' => 'ciencia-virus.jpg',
        'categoria' => 'CIÊNCIA',
        'secao' => 'hero',
    ],

    // ==================== CIÊNCIA ====================
    [
        'titulo' => 'Via Láctea foi remodelada por colisão há bilhões de anos e agora está a caminho de outra',
        'resumo' => 'Astrônomo ganhador do Prêmio Kavli explica como galáxia foi reconfigurada por colisão com galáxia desaparecida.',
        'conteudo' => '<p>As evidências mais claras do passado cataclísmico da Via Láctea são os "migrantes": estrelas que não nasceram nela, mas que deslizam cruzando as órbitas das estrelas locais. A maior estrutura é a Gaia-Sausage-Enceladus, restos de uma galáxia que colidiu com a nossa entre 8 e 11 bilhões de anos atrás.</p><p>O Gaia mostrou que o halo de matéria escura da Via Láctea pode ser deformado por grandes encontros galácticos, fazendo com que a galáxia se incline ao longo de bilhões de anos.</p><p>Atualmente, a Grande Nuvem de Magalhães está puxando a Via Láctea para uma nova dança galáctica. As descobertas foram apresentadas pelo astrônomo Vasily Belokurov.</p>',
        'imagem' => 'ciencia-via-lactea.jpg',
        'categoria' => 'CIÊNCIA',
        'secao' => 'nacional',
    ],
    [
        'titulo' => 'Nasa anuncia tripulantes da Artemis III, missão de testes para futuras viagens à Lua',
        'resumo' => 'Quatro astronautas foram selecionados para missão prevista para 2027; base lunar fixa deve ficar pronta em 2032.',
        'conteudo' => '<p>A Artemis III testará os sistemas necessários para levar astronautas à superfície lunar. A tripulação inclui Andre Douglas, Frank Rubio (recorde de voo espacial de 371 dias), Luca Parmitano e Randy Bresnik.</p><p>O processo de instalação da base lunar será dividido em três fases: construção e aprendizado (2026-2029), infraestrutura (2029-2032) e presença humana sustentada a partir de 2032.</p><p>A Nasa cancelou a estação espacial orbital Lunar Gateway para realocar recursos para a base na superfície lunar.</p>',
        'imagem' => 'ciencia-artemis.jpg',
        'categoria' => 'CIÊNCIA',
        'secao' => 'nacional',
    ],
    [
        'titulo' => 'Céu terá Lua Azul e microlua ao mesmo tempo; entenda o fenômeno',
        'resumo' => 'Segunda Lua Cheia do mês coincidiu com apogeu, criando espetáculo astronômico pouco comum no céu brasileiro.',
        'conteudo' => '<p>O fenômeno da Lua Azul é a segunda Lua Cheia de um mesmo mês, situação que acontece em um ciclo a cada dois anos. A Lua Azul não ficará azul — é apenas um nome tradicional.</p><p>Simultaneamente, a Lua estava em apogeu, a 406.135 km da Terra, tornando-se uma microlua, visivelmente menor e menos brilhante. Como bônus, a Lua Cheia ficou próxima de Antares, estrela avermelhada da constelação de Escorpião.</p><p>Para ocorrer, é preciso que a primeira Lua Cheia caia no início do mês e que o mês tenha 31 dias.</p>',
        'imagem' => 'ciencia-lua.jpg',
        'categoria' => 'CIÊNCIA',
        'secao' => 'internacional',
    ],
    [
        'titulo' => '"Júpiter quente": cientistas descobrem exoplaneta com manhãs nubladas e tardes sem nuvens',
        'resumo' => 'Telescópio James Webb revelou ciclo meteorológico em planeta a centenas de anos-luz; nuvens são de silicatos, não de água.',
        'conteudo' => '<p>O WASP-94A b é um gigante gasoso que orbita extremamente perto de sua estrela, com um ano durando apenas alguns dias terrestres. O telescópio James Webb revelou diferença clara entre o lado matinal (com nuvens densas) e o vespertino (atmosfera limpa).</p><p>As nuvens nesse tipo de planeta podem ser compostas de silicatos ou minerais vaporizados, não de água como na Terra. As diferenças térmicas podem ultrapassar 280 graus Celsius.</p><p>A descoberta ajuda a resolver um antigo debate: as nuvens em Júpiteres quentes são formadas por condensação e comportam-se como sistemas meteorológicos dinâmicos.</p>',
        'imagem' => 'ciencia-jupiter.jpg',
        'categoria' => 'CIÊNCIA',
        'secao' => 'internacional',
    ],

    // ==================== POLÍTICA (hero - existing) ====================
    [
        'titulo' => 'Impulsionamento digital, adesivos, peças na TV: veja onde partidos devem gastar os R$ 4,9 bilhões do Fundo Eleitoral',
        'resumo' => 'TSE distribuirá dinheiro a 30 partidos. Em 2022, o fundo bancou 87,9% das despesas dos presidenciáveis.',
        'conteudo' => '<p>O Tribunal Superior Eleitoral dividiu R$ 4,9 bilhões entre 30 partidos no Fundo Eleitoral de 2026. Os maiores beneficiados são PL, PT, União Brasil, PSD e PP.</p><p>Em 2022, candidatos à Presidência gastaram R$ 336,7 milhões. A produção de rádio e TV liderou os gastos com R$ 81,3 milhões.</p><p>O uso de inteligência artificial será um dos grandes desafios destas eleições, exigindo profissionais especializados em microsegmentação de conteúdo.</p>',
        'imagem' => 'politica-fundo.jpg',
        'categoria' => 'POLÍTICA',
        'secao' => 'hero',
    ],
    [
        'titulo' => 'Pesca em local proibido termina com apreensão de 85 kg de peixes e multa de R$ 5,7 mil',
        'resumo' => 'Três homens foram multados por pesca ilegal próximo à Cachoeira Salto Botelho, em Lucélia (SP).',
        'conteudo' => '<p>Três homens foram multados em R$ 5.718,80 por pesca em local proibido, em Lucélia (SP). A Polícia Ambiental apreendeu dois barcos, tarrafas e 85,5 kg de peixes.</p><p>A ocorrência foi registrada durante o patrulhamento das equipes. O pescado apreendido foi doado ao Lar São Vicente de Paulo.</p><p>Os três homens foram levados à Delegacia por infringir a Lei Federal 9.605/1998, que dispõe sobre crimes ambientais.</p>',
        'imagem' => 'politica-pesca.jpg',
        'categoria' => 'POLÍTICA',
        'secao' => 'nacional',
    ],
    [
        'titulo' => 'Zema minimiza fala de Eduardo Bolsonaro sobre rompimento com o Novo',
        'resumo' => 'Pré-candidato pelo Novo afirmou que partidos seguem aliados em estados do Sul e em Goiás.',
        'conteudo' => '<p>O pré-candidato à Presidência pelo Novo, Romeu Zema, minimizou a declaração de Eduardo Bolsonaro que defendeu um "rompimento geral" entre PL e Novo.</p><p>Zema voltou a chamar Daniel Vorcaro de "banqueiro bandido" e afirmou que a direita estará unida em eventual segundo turno contra Lula.</p><p>Sobre seu programa de governo, Zema apresentou três "choques": moral e ético, contra a gastança e contra a criminalidade.</p>',
        'imagem' => 'politica-zema.jpg',
        'categoria' => 'POLÍTICA',
        'secao' => 'nacional',
    ],
    [
        'titulo' => 'Nova espécie de flor descoberta no Brasil já nasce ameaçada de extinção',
        'resumo' => 'Alstroemeria durantei foi descoberta em Lauro Müller, Santa Catarina, e possui apenas 1 de 9 populações em conservação.',
        'conteudo' => '<p>Uma nova espécie de flor, batizada de Alstroemeria durantei, foi descoberta em Lauro Müller, Santa Catarina. A planta recebeu o nome do fotógrafo João Paulo Durante.</p><p>Cientistas confirmaram a descoberta após análises comparativas publicadas na revista Phytotaxa. As flores possuem tépalas mais estreitas e alongadas.</p><p>Pesquisadores alertam que a nova espécie já está ameaçada de extinção, com apenas 1 de 9 populações em unidade de conservação.</p>',
        'imagem' => 'politica-flor.jpg',
        'categoria' => 'POLÍTICA',
        'secao' => 'nacional',
    ],
    [
        'titulo' => 'Museu Nacional ganha réplica de dinossauro brasileiro com 15 metros',
        'resumo' => 'Oxalaia quilombensis, com 5 metros de altura, enfeita a frente do Museu Nacional no Rio de Janeiro.',
        'conteudo' => '<p>Um animatrônico de Oxalaia quilombensis, um dos mais importantes dinossauros já descritos no Brasil, enfeita a frente do Museu Nacional, na Quinta da Boa Vista.</p><p>A réplica foi doada pelo Parque Terra dos Dinos. O Oxalaia viveu há cerca de 95 milhões de anos na Ilha do Cajual, no Maranhão.</p><p>O exemplar permanecerá em frente ao equipamento até agosto, e depois será levado para a entrada do Centro de Visitantes.</p>',
        'imagem' => 'politica-museu.jpg',
        'categoria' => 'POLÍTICA',
        'secao' => 'internacional',
    ],
];

foreach ($noticias as $noticia) {
    $stmt->execute([
        ':redator_id' => $noticia['redator_id'] ?? 1,
        ':titulo' => $noticia['titulo'],
        ':resumo' => $noticia['resumo'],
        ':conteudo' => $noticia['conteudo'],
        ':imagem' => $noticia['imagem'],
        ':categoria' => $noticia['categoria'],
        ':secao' => $noticia['secao'],
    ]);
}

echo "Seed executado com sucesso!\n";
echo "Usuarios: admin@jornalatlas.com / revisor@jornalatlas.com\n";
echo "Noticias: " . count($noticias) . " (1 hero por categoria, 8 categorias)\n";
