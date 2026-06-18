<?php

namespace App\Repositories;

use App\Core\AcaoRevisao;
use App\Core\Database;
use App\Models\Revisao;
use DateTime;

class RevisaoRepository
{
    public static function create(Revisao $revisao)
    {
        $stmt = Database::getConnection()->prepare(
            'INSERT INTO Revisao (revisor_id, noticia_id, acaoRealizada, observacao)
            VALUES (:revisorId, :noticiaId, :acao, :observacao)'
        );
        $stmt->execute([
            ':revisor_id' => $revisao->getRevisorId(),
            ':noticia_id' => $revisao->getNoticiaId(),
            ':acao' => $revisao->getAcao() instanceof AcaoRevisao ? $revisao->getAcao()->value : $revisao->getAcao(),
            ':observacao' => $revisao->getObservacao() ?? null,
        ]);
        return (int) Database::getConnection()->lastInsertId();
    }

    public static function byNoticia(int $noticiaId): array
    {
        $stmt = Database::getConnection()->prepare(
            'SELECT * FROM Revisao WHERE noticia_id = :id ORDER BY dataRevisao DESC'
        );
        $stmt->execute([':id' => $noticiaId]);
        $revisoes = [];
        foreach ($stmt->fetchAll() as $row) {
            $revisoes[] = self::hydrate($row);
        }
        return $revisoes;
    }

    public static function latestForNoticia(int $noticiaId): ?Revisao
    {
        $stmt = Database::getConnection()->prepare(
            'SELECT * FROM Revisao WHERE noticia_id = :id ORDER BY dataRevisao DESC LIMIT 1'
        );
        $stmt->execute([':id' => $noticiaId]);
        $row = $stmt->fetch();
        return $row ? self::hydrate($row) : null;
    }

    private static function hydrate(array $row): Revisao
    {
        return new Revisao(
            (int) $row['id'],
            (int) $row['revisor_id'],
            (int) $row['noticia_id'],
            AcaoRevisao::from($row['acaoRealizada']),
            new DateTime($row['dataRevisao']),
            $row['observacao'] ?? null
        );
    }
}
