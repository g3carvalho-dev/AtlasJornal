<?php

namespace App\Repositories;

use App\Core\Database;
use App\Core\StatusNoticia;
use App\Models\Noticia;
use DateTime;

class NoticiaRepository
{
    public static function find(int $id): ?Noticia
    {
        $stmt = Database::getConnection()->prepare(
            'SELECT * FROM Noticia WHERE id = :id LIMIT 1'
        );

        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();

        return $row ? self::hydrate($row) : null;
    }

    public static function approved(): array
    {
        $stmt = Database::getConnection()->query(
            'SELECT * FROM Noticia WHERE status = \'' . StatusNoticia::APROVADA->value . '\' ORDER BY dataPublicacao DESC'
        );

        return self::hydrateMany($stmt->fetchAll());
    }

    public static function bySecao(string $secao): array
    {
        $stmt = Database::getConnection()->prepare(
            'SELECT * FROM Noticia WHERE status = :status AND secao = :secao ORDER BY dataPublicacao DESC'
        );

        $stmt->execute([
            ':status' => StatusNoticia::APROVADA->value,
            ':secao' => $secao,
        ]);

        return self::hydrateMany($stmt->fetchAll());
    }

    public static function byCategoria(string $categoria): array
    {
        $stmt = Database::getConnection()->prepare(
            'SELECT * FROM Noticia WHERE status = :status AND categoria = :categoria ORDER BY dataPublicacao DESC'
        );

        $stmt->execute([
            ':status' => StatusNoticia::APROVADA->value,
            ':categoria' => $categoria,
        ]);

        return self::hydrateMany($stmt->fetchAll());
    }

    public static function pendingReview(): array
    {
        $stmt = Database::getConnection()->query(
            'SELECT * FROM Noticia WHERE status = \'' . StatusNoticia::ANALISE->value . '\' ORDER BY dataCriacao DESC'
        );

        return self::hydrateMany($stmt->fetchAll());
    }

    public static function pendingReviewWithAuthor(): array
    {
        $stmt = Database::getConnection()->query(
            'SELECT n.*, u.nome AS autor_nome, u.foto AS autor_foto
             FROM Noticia n
             LEFT JOIN Usuario u ON n.redator_id = u.id
             WHERE n.status = \'' . StatusNoticia::ANALISE->value . '\'
             ORDER BY n.dataCriacao DESC'
        );

        return $stmt->fetchAll();
    }

    public static function byRedator(int $redatorId): array
    {
        $stmt = Database::getConnection()->prepare(
            'SELECT * FROM Noticia WHERE redator_id = :redatorId ORDER BY dataCriacao DESC'
        );

        $stmt->execute([':redatorId' => $redatorId]);
        return self::hydrateMany($stmt->fetchAll());
    }

    public static function byStatus(StatusNoticia $status): array
    {
        $stmt = Database::getConnection()->prepare(
            'SELECT * FROM Noticia WHERE status = :status ORDER BY dataCriacao DESC'
        );

        $stmt->execute([':status' => $status->value]);
        return self::hydrateMany($stmt->fetchAll());
    }

    public static function create(Noticia $noticia): int
    {
        $stmt = Database::getConnection()->prepare(
            'INSERT INTO Noticia (redator_id, titulo, resumo, conteudo, imagem, categoria, secao, status)
            VALUES (:redator_id, :titulo, :resumo, :conteudo, :imagem, :categoria, :secao, :status)'
        );

        $stmt->execute([
            ':redator_id' => $noticia->getRedatorId(),
            ':titulo' => $noticia->getTitulo(),
            ':resumo' => $noticia->getResumo(),
            ':conteudo' => $noticia->getConteudo(),
            ':imagem' => $noticia->getImagem(),
            ':categoria' => $noticia->getCategoria(),
            ':secao' => $noticia->getSecao(),
            ':status' => $noticia->getStatus()->value,
        ]);

        return (int) Database::getConnection()->lastInsertId();
    }

    public static function update(Noticia $noticia): bool
    {
        $stmt = Database::getConnection()->prepare(
            'UPDATE Noticia SET
                titulo = :titulo,
                resumo = :resumo,
                conteudo = :conteudo,
                imagem = :imagem,
                categoria = :categoria,
                secao = :secao,
                dataEdicao = NOW()
            WHERE id = :id'
        );

        return $stmt->execute([
            ':id' => $noticia->getId(),
            ':titulo' => $noticia->getTitulo(),
            ':resumo' => $noticia->getResumo(),
            ':conteudo' => $noticia->getConteudo(),
            ':imagem' => $noticia->getImagem(),
            ':categoria' => $noticia->getCategoria(),
            ':secao' => $noticia->getSecao(),
        ]);
    }

    private static function updateStatus(int $id, StatusNoticia $status, ?DateTime $dataPublicacao = null): bool
    {
        $sql = 'UPDATE Noticia SET status = :status, dataEdicao = NOW()';
        $params = [':id' => $id, ':status' => $status->value];

        if ($dataPublicacao !== null) {
            $sql .= ', dataPublicacao = :dataPublicacao';
            $params[':dataPublicacao'] = $dataPublicacao->format('Y-m-d H:i:s');
        }

        $sql .= ' WHERE id = :id';

        $stmt = Database::getConnection()->prepare($sql);
        return $stmt->execute($params);
    }

    public static function delete(int $id): bool
    {
        $stmt = Database::getConnection()->prepare(
            'DELETE FROM Noticia WHERE id = :id'
        );

        return $stmt->execute([':id' => $id]);
    }

    private static function hydrate(array $row): Noticia
    {
        return new Noticia(
            (int) $row['id'],
            (int) $row['redator_id'],
            (string) $row['titulo'],
            (string) $row['resumo'],
            (string) $row['conteudo'],
            $row['imagem'] ?: null,
            (string) $row['categoria'],
            (string) $row['secao'],
            StatusNoticia::from($row['status']),
            new DateTime($row['dataCriacao']),
            $row['dataPublicacao'] ? new DateTime($row['dataPublicacao']) : null,
            $row['dataEdicao'] ? new DateTime($row['dataEdicao']) : null
        );
    }

    private static function hydrateMany(array $rows): array
    {
        $list = [];
        foreach ($rows as $row) {
            $list[] = self::hydrate($row);
        }
        return $list;
    }
}
