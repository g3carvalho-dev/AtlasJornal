<?php

namespace App\Models;

use App\Core\StatusNoticia;
use DateTime;

class Noticia
{

    private int $id;
    private int $redator_id;
    private string $titulo;
    private string $resumo;
    private string $conteudo;
    private ?string $imagem;
    private string $categoria;
    private string $secao;
    private StatusNoticia $status;
    private DateTime $dataCriacao;
    private ?DateTime $dataPublicacao;
    private ?DateTime $dataEdicao;

    public function __construct(
        int $id,
        int $redator_id,
        string $titulo,
        string $resumo,
        string $conteudo,
        ?string $imagem,
        string $categoria,
        string $secao,
        StatusNoticia $status,
        DateTime $dataCriacao,
        ?DateTime $dataPublicacao = null,
        ?DateTime $dataEdicao = null
    ) {
        $this->id = $id;
        $this->redator_id = $redator_id;
        $this->titulo = $titulo;
        $this->resumo = $resumo;
        $this->conteudo = $conteudo;
        $this->imagem = $imagem;
        $this->categoria = $categoria;
        $this->secao = $secao;
        $this->status = $status;
        $this->dataCriacao = $dataCriacao;
        $this->dataPublicacao = $dataPublicacao;
        $this->dataEdicao = $dataEdicao;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getRedatorId(): int
    {
        return $this->redator_id;
    }

    public function setRedatorId(int $redator_id): void
    {
        $this->redator_id = $redator_id;
    }

    public function getTitulo(): string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): void
    {
        $this->titulo = $titulo;
    }

    public function getResumo(): string
    {
        return $this->resumo;
    }

    public function setResumo(string $resumo): void
    {
        $this->resumo = $resumo;
    }

    public function getConteudo(): string
    {
        return $this->conteudo;
    }

    public function setConteudo(string $conteudo): void
    {
        $this->conteudo = $conteudo;
    }

    public function getImagem(): ?string
    {
        return $this->imagem;
    }

    public function setImagem(?string $imagem): void
    {
        $this->imagem = $imagem;
    }

    public function getCategoria(): string
    {
        return $this->categoria;
    }

    public function setCategoria(string $categoria): void
    {
        $this->categoria = $categoria;
    }

    public function getSecao(): string
    {
        return $this->secao;
    }

    public function setSecao(string $secao): void
    {
        $this->secao = $secao;
    }

    public function getStatus(): StatusNoticia
    {
        return $this->status;
    }

    public function setStatus(StatusNoticia $status): void
    {
        $this->status = $status;
    }

    public function getDataCriacao(): DateTime
    {
        return $this->dataCriacao;
    }

    public function setDataCriacao(DateTime $dataCriacao): void
    {
        $this->dataCriacao = $dataCriacao;
    }

    public function getDataPublicacao(): ?DateTime
    {
        return $this->dataPublicacao;
    }

    public function setDataPublicacao(?DateTime $dataPublicacao): void
    {
        $this->dataPublicacao = $dataPublicacao;
    }

    public function getDataEdicao(): ?DateTime
    {
        return $this->dataEdicao;
    }

    public function setDataEdicao(?DateTime $dataEdicao): void
    {
        $this->dataEdicao = $dataEdicao;
    }

}
