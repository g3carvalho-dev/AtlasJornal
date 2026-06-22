<?php

namespace App\Repositories;

use App\Core\AcaoRevisao;
use App\Core\Database;
use App\Core\StatusNoticia;
use App\Models\Revisao;
use App\Models\Noticia;
use DateTime;

class RevisaoRepository
{
    public static function create(Revisao $revisao): int
    {
        $stmt = Database::getConnection()->prepare(
            'INSERT INTO Revisao (revisor_id, noticia_id, acaoRealizada, observacao)
            VALUES (:revisorId, :noticiaId, :acao, :observacao)'
        );
        $stmt->execute([
            ':revisorId' => $revisao->getRevisorId(),
            ':noticiaId' => $revisao->getNoticiaId(),
            ':acao' => $revisao->getAcao()->value,
            ':observacao' => $revisao->getObservacao() ?? null,
        ]);
        return (int) Database::getConnection()->lastInsertId();
    }

    public static function pendingWithAuthor(): array
    {
        $stmt = Database::getConnection()->query(
            'SELECT n.*, u.nome AS autor_nome, u.email AS autor_email
             FROM Noticia n
             JOIN Usuario u ON n.redator_id = u.id
             WHERE n.status = \'' . StatusNoticia::ANALISE->value . '\'
             ORDER BY n.dataCriacao DESC'
        );
        $lista = [];
        foreach ($stmt->fetchAll() as $row) {
            $lista[] = $row;
        }
        return $lista;
    }

    public static function pendentesEHistorico(int $revisorId): array
    {
        $stmt = Database::getConnection()->prepare(
            'SELECT n.*, u.nome AS autor_nome, u.email AS autor_email
             FROM Noticia n
             JOIN Usuario u ON n.redator_id = u.id
             WHERE n.status = :analise
                OR n.id IN (SELECT noticia_id FROM Revisao WHERE revisor_id = :revisorId)
             ORDER BY n.dataCriacao DESC'
        );
        $stmt->execute([
            ':analise' => StatusNoticia::ANALISE->value,
            ':revisorId' => $revisorId,
        ]);
        return $stmt->fetchAll();
    }

    public static function latestReviewForNoticia(int $noticiaId): ?array
    {
        $stmt = Database::getConnection()->prepare(
            'SELECT r.*, u.nome AS revisor_nome
             FROM Revisao r
             JOIN Usuario u ON r.revisor_id = u.id
             WHERE r.noticia_id = :id
             ORDER BY r.dataRevisao DESC LIMIT 1'
        );
        $stmt->execute([':id' => $noticiaId]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function pendentesCount(): int
    {
        $stmt = Database::getConnection()->query(
            'SELECT COUNT(*) FROM Noticia WHERE status = \'' . StatusNoticia::ANALISE->value . '\''
        );
        return (int) $stmt->fetchColumn();
    }

    public static function rejeitadasCount(): int
    {
        $stmt = Database::getConnection()->query(
            'SELECT COUNT(*) FROM Noticia WHERE status = \'' . StatusNoticia::REJEITADA->value . '\''
        );
        return (int) $stmt->fetchColumn();
    }

    public static function arquivadasCount(): int
    {
        $stmt = Database::getConnection()->query(
            'SELECT COUNT(*) FROM Noticia WHERE status = \'' . StatusNoticia::ARQUIVADA->value . '\''
        );
        return (int) $stmt->fetchColumn();
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

    public static function revisadasByRevisor(int $revisorId): array
    {
        $stmt = Database::getConnection()->prepare(
            'SELECT r.*, n.titulo, n.imagem, n.categoria, n.resumo, n.status AS noticia_status
             FROM Revisao r
             JOIN Noticia n ON r.noticia_id = n.id
             WHERE r.revisor_id = :revisorId
             ORDER BY r.dataRevisao DESC'
        );
        $stmt->execute([':revisorId' => $revisorId]);
        return $stmt->fetchAll();
    }

    public static function countByRevisor(int $revisorId): int
    {
        $stmt = Database::getConnection()->prepare(
            'SELECT COUNT(*) FROM Revisao WHERE revisor_id = :id'
        );
        $stmt->execute([':id' => $revisorId]);
        return (int) $stmt->fetchColumn();
    }

    public static function reviewsForRedator(int $redatorId): array
    {
        $stmt = Database::getConnection()->prepare(
            'SELECT r.*, n.titulo, n.imagem, n.categoria, n.status AS noticia_status,
                    u.nome AS revisor_nome, u.foto AS revisor_foto
             FROM Revisao r
             JOIN Noticia n ON r.noticia_id = n.id
             JOIN Usuario u ON r.revisor_id = u.id
             WHERE n.redator_id = :redatorId
             ORDER BY r.dataRevisao DESC'
        );
        $stmt->execute([':redatorId' => $redatorId]);
        return $stmt->fetchAll();
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
