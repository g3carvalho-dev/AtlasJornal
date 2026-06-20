CREATE DATABASE IF NOT EXISTS jornal_atlasdb;
USE jornal_atlasdb;

CREATE TABLE Usuario 
( 
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    nascimento DATE NOT NULL,
    formacao VARCHAR(150) NOT NULL,
    assinatura VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    podeRedigir BOOLEAN NOT NULL DEFAULT FALSE,
    podeRevisar BOOLEAN NOT NULL DEFAULT FALSE,
    isAdmin BOOLEAN NOT NULL DEFAULT FALSE
); 

CREATE TABLE Noticia 
( 
    id INT PRIMARY KEY AUTO_INCREMENT,
    redator_id INT NOT NULL,
    titulo VARCHAR(200) NOT NULL,
    resumo VARCHAR(500) NOT NULL,
    conteudo TEXT NOT NULL,
    imagem VARCHAR(255) NULL,
    categoria VARCHAR(50) NOT NULL,
    secao ENUM('hero', 'nacional', 'internacional') NOT NULL,
    status ENUM('RASCUNHO', 'EM_ANALISE', 'APROVADA', 'ARQUIVADA', 'REJEITADA') NOT NULL DEFAULT 'RASCUNHO',
    dataCriacao DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    dataPublicacao DATETIME NULL,
    dataEdicao DATETIME NULL,

    FOREIGN KEY (redator_id) REFERENCES Usuario(id)
); 

CREATE TABLE Revisao 
( 
    id INT PRIMARY KEY AUTO_INCREMENT,
    revisor_id INT NOT NULL,
    noticia_id INT NOT NULL,
    acaoRealizada ENUM('APROVAR', 'REJEITAR', 'ARQUIVAR', 'SOLICITAR_CORRECAO') NOT NULL,
    dataRevisao DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    observacao TEXT,

    FOREIGN KEY (revisor_id) REFERENCES Usuario(id),
    FOREIGN KEY (noticia_id) REFERENCES Noticia(id)
); 

CREATE TABLE SolicitacaoCargo 
( 
    id INT PRIMARY KEY AUTO_INCREMENT,
    usuario_id INT NOT NULL,
    admin_id INT NULL,
    cargo ENUM('REDATOR', 'REVISOR') NOT NULL DEFAULT 'REDATOR',
    status ENUM('EM_ANALISE', 'APROVADA', 'REJEITADA') NOT NULL DEFAULT 'EM_ANALISE',
    dataSolicitacao DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    dataResposta DATETIME NULL,
    observacao TEXT,

    FOREIGN KEY (usuario_id) REFERENCES Usuario(id),
    FOREIGN KEY (admin_id) REFERENCES Usuario(id)
);