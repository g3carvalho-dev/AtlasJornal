<?php

namespace App\Models;

use DateTime;

class Usuario
{
    private int $id;
    private string $nome;
    private DateTime $dataNascimento;
    private string $formacao;
    private string $assinatura;
    private string $email;
    private string $senha;
    private ?string $foto;
    private bool $podeRedigir;
    private bool $podeRevisar;
    private bool $isAdmin;

    public function __construct(
        int $id,
        string $nome,
        DateTime $dataNascimento,
        string $formacao,
        string $assinatura,
        string $email,
        string $senha,
        ?string $foto = null,
        bool $podeRedigir = false,
        bool $podeRevisar = false,
        bool $isAdmin = false
    ) {
        $this->id = $id;
        $this->nome = $nome;
        $this->dataNascimento = $dataNascimento;
        $this->formacao = $formacao;
        $this->assinatura = $assinatura;
        $this->email = $email;
        $this->senha = $senha;
        $this->foto = $foto;
        $this->podeRedigir = $podeRedigir;
        $this->podeRevisar = $podeRevisar;
        $this->isAdmin = $isAdmin;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function getDataNascimento(): DateTime
    {
        return $this->dataNascimento;
    }

    public function getFormacao(): string
    {
        return $this->formacao;
    }

    public function getAssinatura(): string
    {
        return $this->assinatura;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getSenha(): string
    {
        return $this->senha;
    }

    public function getFoto(): string
    {
        return $this->foto ?? 'img/avatar_admin.png';
    }

    public function getPodeRedigir(): bool
    {
        return $this->podeRedigir;
    }

    public function getPodeRevisar(): bool
    {
        return $this->podeRevisar;
    }

    public function getIsAdmin(): bool
    {
        return $this->isAdmin;
    }

    public function getCargo(): string
    {
        if ($this->isAdmin) return 'administrador';
        if ($this->podeRevisar) return 'revisor';
        if ($this->podeRedigir) return 'redator';
        return 'leitor';
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setNome(string $nome): void
    {
        $this->nome = $nome;
    }

    public function setDataNascimento(DateTime $dataNascimento): void
    {
        $this->dataNascimento = $dataNascimento;
    }

    public function setFormacao(string $formacao): void
    {
        $this->formacao = $formacao;
    }

    public function setAssinatura(string $assinatura): void
    {
        $this->assinatura = $assinatura;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setSenha(string $senha): void
    {
        $this->senha = $senha;
    }

    public function setFoto(string $foto): void
    {
        $this->foto = $foto;
    }

    public function setPodeRedigir(bool $pode): void
    {
        $this->podeRedigir = $pode;
    }

    public function setPodeRevisar(bool $pode): void
    {
        $this->podeRevisar = $pode;
    }

    public function setIsAdmin(bool $isAdmin): void
    {
        $this->isAdmin = $isAdmin;
    }
}
