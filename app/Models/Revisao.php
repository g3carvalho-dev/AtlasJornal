<?php

namespace App\Models;

use App\Core\AcaoRevisao;
use DateTime;

class Revisao
{
    private int $id;
    private int $revisor_id;
    private int $noticia_id;
    private AcaoRevisao $acao;
    private DateTime $dataRevisao;
    private ?string $observacao;

    public function __construct(
        int $id,
        int $revisor_id,
        int $noticia_id,
        AcaoRevisao $acao,
        DateTime $dataRevisao,
        ?string $observacao = null
    ) {
        $this->id = $id;
        $this->revisor_id = $revisor_id;
        $this->noticia_id = $noticia_id;
        $this->acao = $acao;
        $this->dataRevisao = $dataRevisao;
        $this->observacao = $observacao;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getRevisorId(): int
    {
        return $this->revisor_id;
    }

    public function setRevisorId(int $revisor_id): void
    {
        $this->revisor_id = $revisor_id;
    }

    public function getNoticiaId(): int
    {
        return $this->noticia_id;
    }

    public function setNoticiaId(int $noticia_id): void
    {
        $this->noticia_id = $noticia_id;
    }

    public function getAcao(): AcaoRevisao
    {
        return $this->acao;
    }

    public function setAcao(AcaoRevisao $acao): void
    {
        $this->acao = $acao;
    }

    public function getDataRevisao(): DateTime
    {
        return $this->dataRevisao;
    }

    public function setDataRevisao(DateTime $dataRevisao): void
    {
        $this->dataRevisao = $dataRevisao;
    }

    public function getObservacao(): ?string
    {
        return $this->observacao;
    }

    public function setObservacao(?string $observacao): void
    {
        $this->observacao = $observacao;
    }
}
