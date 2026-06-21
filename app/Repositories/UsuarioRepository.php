<?php

namespace App\Repositories;

use App\Core\Database;
use App\Models\Usuario;
use DateTime;

class UsuarioRepository
{
    public static function find(int $id): ?Usuario
    {
        $stmt = Database::getConnection()->prepare(
            'SELECT * FROM Usuario WHERE id = :id LIMIT 1'
        );

        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        return $row ? self::hydrate($row) : null;
    }

    public static function findByEmail(string $email): ?Usuario
    {
        $stmt = Database::getConnection()->prepare(
            'SELECT * FROM Usuario WHERE email = :email LIMIT 1'
        );

        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch();

        return $row ? self::hydrate($row) : null;
    }

    // Melhor ordernar por nome ou id?
    public static function findAll(): array
    {
        $stmt = Database::getConnection()->query(
            'SELECT * FROM Usuario ORDER BY nome ASC'
        );

        $usuarios = [];
        foreach ($stmt->fetchAll() as $row) {
            $usuarios[] = self::hydrate($row);
        }
        return $usuarios;
    }

    public static function create(Usuario $usuario): int
    {
        $stmt = Database::getConnection()->prepare(
            'INSERT INTO Usuario (nome, nascimento, formacao, assinatura, email, senha, foto, podeRedigir, podeRevisar, isAdmin)
            VALUES (:nome, :nascimento, :formacao, :assinatura, :email, :senha, :foto, :podeRedigir, :podeRevisar, :isAdmin)'
        );

        $stmt->execute([
            ':nome' => $usuario->getNome(),
            ':nascimento' => $usuario->getDataNascimento()->format('Y-m-d'),
            ':formacao' => $usuario->getFormacao(),
            ':assinatura' => $usuario->getAssinatura(),
            ':email' => $usuario->getEmail(),
            ':senha' => password_hash($usuario->getSenha(), PASSWORD_DEFAULT),
            ':foto' => $usuario->getFoto(),
            ':podeRedigir' => $usuario->getPodeRedigir() ? 1 : 0,
            ':podeRevisar' => $usuario->getPodeRevisar() ? 1 : 0,
            ':isAdmin' => $usuario->getIsAdmin() ? 1 : 0,
        ]);

        return (int) Database::getConnection()->lastInsertId();
    }

    public static function update(Usuario $usuario): bool
    {
        $stmt = Database::getConnection()->prepare(
            'UPDATE Usuario SET
                nome = :nome,
                nascimento = :nascimento,
                formacao = :formacao,
                assinatura = :assinatura,
                email = :email
            WHERE id = :id'
        );
        return $stmt->execute([
            ':id' => $usuario->getId(),
            ':nome' => $usuario->getNome(),
            ':nascimento' => $usuario->getDataNascimento()->format('Y-m-d'),
            ':formacao' => $usuario->getFormacao(),
            ':assinatura' => $usuario->getAssinatura(),
            ':email' => $usuario->getEmail(),
        ]);
    }

    public static function updateSenha(int $id, string $senha): bool
    {
        $stmt = Database::getConnection()->prepare(
            'UPDATE Usuario SET senha = :senha WHERE id = :id'
        );

        return $stmt->execute([
            ':id' => $id,
            ':senha' => password_hash($senha, PASSWORD_DEFAULT),
        ]);
    }

    public static function updatePermissoes(int $id, bool $podeRedigir, bool $podeRevisar, bool $isAdmin): bool
    {
        $stmt = Database::getConnection()->prepare(
            'UPDATE Usuario SET podeRedigir = :podeRedigir, podeRevisar = :podeRevisar, isAdmin = :isAdmin WHERE id = :id'
        );

        return $stmt->execute([
            ':id' => $id,
            ':podeRedigir' => $podeRedigir ? 1 : 0,
            ':podeRevisar' => $podeRevisar ? 1 : 0,
            ':isAdmin' => $isAdmin ? 1 : 0,
        ]);
    }

    public static function delete(int $id): bool
    {
        $stmt = Database::getConnection()->prepare(
            'DELETE FROM Usuario WHERE id = :id'
        );

        return $stmt->execute([':id' => $id]);
    }

    public static function countRedatores(): int
    {
        return (int) Database::getConnection()->query(
            'SELECT COUNT(*) FROM Usuario WHERE podeRedigir = 1 AND isAdmin = 0'
        )->fetchColumn();
    }

    public static function countRevisores(): int
    {
        return (int) Database::getConnection()->query(
            'SELECT COUNT(*) FROM Usuario WHERE podeRevisar = 1 AND isAdmin = 0'
        )->fetchColumn();
    }

    private static function hydrate(array $row): Usuario
    {
        return new Usuario(
            (int) $row['id'],
            (string) $row['nome'],
            new DateTime($row['nascimento']),
            (string) $row['formacao'],
            (string) $row['assinatura'],
            (string) $row['email'],
            (string) $row['senha'],
            $row['foto'] ?: null,
            (bool) $row['podeRedigir'],
            (bool) $row['podeRevisar'],
            (bool) $row['isAdmin']
        );
    }
}
