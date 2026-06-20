<?php

namespace App\Core;

enum StatusNoticia: string
{
    case RASCUNHO = 'RASCUNHO';
    case ANALISE = 'EM_ANALISE';
    case APROVADA = 'APROVADA';
    case ARQUIVADA = 'ARQUIVADA';
    case REJEITADA = 'REJEITADA';
}

enum AcaoRevisao: string
{
    case APROVAR = 'APROVAR';
    case REJEITAR = 'REJEITAR';
    case ARQUIVAR = 'ARQUIVAR';
    case SOLICITAR_CORRECAO = 'SOLICITAR_CORRECAO';
}

enum CargoSolicitado: string
{
    case REDATOR = 'REDATOR';
    case REVISOR = 'REVISOR';
}

enum StatusSolicitacao: string
{
    case ANALISE = 'EM_ANALISE';
    case APROVADA = 'APROVADA';
    case REJEITADA = 'REJEITADA';
}
