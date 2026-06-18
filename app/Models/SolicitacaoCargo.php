<?php

namespace App\Models;

use App\Core\CargoSolicitado;
use App\Core\StatusSolicitacao;
use DateTime;

class SolicitacaoCargo
{
    private int $id;
    private int $usuario_id;
    private int $admin_id;
    private CargoSolicitado $cargo;
    private StatusSolicitacao $status;
    private DateTime $dataSolicitacao;
    private ?DateTime $dataResposta;
    private ?string $observacao;

    public function __construct(
        int $id,
        int $usuario_id,
        int $admin_id,
        CargoSolicitado $cargo,
        StatusSolicitacao $status,
        DateTime $dataSolicitacao,
        ?DateTime $dataResposta = null,
        ?string $observacao = null
    ) {
        $this->id = $id;
        $this->usuario_id = $usuario_id;
        $this->admin_id = $admin_id;
        $this->cargo = $cargo;
        $this->status = $status;
        $this->dataSolicitacao = $dataSolicitacao;
        $this->dataResposta = $dataResposta;
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

    public function getUsuarioId(): int
    {
        return $this->usuario_id;
    }

    public function setUsuarioId(int $usuario_id): void
    {
        $this->usuario_id = $usuario_id;
    }

    public function getAdminId(): int
    {
        return $this->admin_id;
    }

    public function setAdminId(int $admin_id): void
    {
        $this->admin_id = $admin_id;
    }

    public function getCargo(): CargoSolicitado
    {
        return $this->cargo;
    }

    public function setCargo(CargoSolicitado $cargo): void
    {
        $this->cargo = $cargo;
    }

    public function getStatus(): StatusSolicitacao
    {
        return $this->status;
    }

    public function setStatus(StatusSolicitacao $status): void
    {
        $this->status = $status;
    }

    public function getDataSolicitacao(): DateTime
    {
        return $this->dataSolicitacao;
    }

    public function setDataSolicitacao(DateTime $dataSolicitacao): void
    {
        $this->dataSolicitacao = $dataSolicitacao;
    }

    public function getDataResposta(): ?DateTime
    {
        return $this->dataResposta;
    }

    public function setDataResposta(?DateTime $dataResposta): void
    {
        $this->dataResposta = $dataResposta;
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
