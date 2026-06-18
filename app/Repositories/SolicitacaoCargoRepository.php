<?php

namespace App\Repositories;

use App\Core\CargoSolicitado;
use App\Core\Database;
use App\Core\StatusSolicitacao;
use App\Models\SolicitacaoCargo;
use DateTime;

class SolicitacaoCargoRepository
{
    public static function create(int $usuarioId, CargoSolicitado $cargo): int
    {
        $stmt = Database::getConnection()->prepare(
            'INSERT INTO SolicitacaoCargo (usuario_id, cargo, status)
            VALUES (:usuario_id, :cargo, :status)'
        );
        $stmt->execute([
            ':usuario_id' => $usuarioId,
            ':cargo' => $cargo->value,
            ':status' => StatusSolicitacao::ANALISE->value,
        ]);
        return (int) Database::getConnection()->lastInsertId();
    }

    public static function find(int $id): ?SolicitacaoCargo
    {
        $stmt = Database::getConnection()->prepare(
            'SELECT * FROM SolicitacaoCargo WHERE id = :id LIMIT 1'
        );
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return $row ? self::hydrate($row) : null;
    }

    public static function pending(): array
    {
        $stmt = Database::getConnection()->query(
            'SELECT * FROM SolicitacaoCargo WHERE status = \'' . StatusSolicitacao::ANALISE->value . '\' ORDER BY dataSolicitacao ASC'
        );
        $lista = [];
        foreach ($stmt->fetchAll() as $row) {
            $lista[] = self::hydrate($row);
        }
        return $lista;
    }

    public static function byUsuario(int $usuarioId): array
    {
        $stmt = Database::getConnection()->prepare(
            'SELECT * FROM SolicitacaoCargo WHERE usuario_id = :id ORDER BY dataSolicitacao DESC'
        );
        $stmt->execute([':id' => $usuarioId]);
        $lista = [];
        foreach ($stmt->fetchAll() as $row) {
            $lista[] = self::hydrate($row);
        }
        return $lista;
    }

    public static function temPendente(int $usuarioId): bool
    {
        $stmt = Database::getConnection()->prepare(
            'SELECT COUNT(*) FROM SolicitacaoCargo WHERE usuario_id = :id AND status = \'' . StatusSolicitacao::ANALISE->value . '\''
        );
        $stmt->execute([':id' => $usuarioId]);
        return (int) $stmt->fetchColumn() > 0;
    }

    public static function responder(int $id, StatusSolicitacao $status, int $adminId, ?string $observacao = null): bool
    {
        $stmt = Database::getConnection()->prepare(
            'UPDATE SolicitacaoCargo SET
                admin_id = :admin_id,
                status = :status,
                dataResposta = NOW(),
                observacao = :observacao
            WHERE id = :id'
        );
        return $stmt->execute([
            ':id' => $id,
            ':admin_id' => $adminId,
            ':status' => $status->value,
            ':observacao' => $observacao ?? null,
        ]);
    }

    private static function hydrate(array $row): SolicitacaoCargo
    {
        return new SolicitacaoCargo(
            (int) $row['id'],
            (int) $row['usuario_id'],
            (int) $row['admin_id'] ?? 0,
            CargoSolicitado::from($row['cargo']),
            StatusSolicitacao::from($row['status']),
            new DateTime($row['dataSolicitacao']),
            $row['dataResposta'] ? new DateTime($row['dataResposta']) : null,
            $row['observacao'] ?? null
        );
    }
}
