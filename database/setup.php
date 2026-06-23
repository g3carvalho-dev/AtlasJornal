<?php

/**
 * Script de configuração do banco de dados.
 *
 * Uso:
 *   php database/setup.php
 *
 * Cria o banco, executa o schema (tabelas) e popula com dados iniciais.
 */

$host = 'localhost';
$user = 'root';
$password = '';
$database = 'jornal_atlasdb';

echo "=== Jornal Atlas — Setup do Banco de Dados ===\n\n";

// 1. Conectar ao MySQL (sem selecionar banco)
try {
    $pdo = new PDO("mysql:host=$host", $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
    echo "[OK] Conexao com MySQL estabelecida.\n";
} catch (PDOException $e) {
    echo "[ERRO] Nao foi possivel conectar ao MySQL: " . $e->getMessage() . "\n";
    echo "Verifique se o servico MySQL esta rodando e se as credenciais estao corretas.\n";
    exit(1);
}

// 2. Criar banco se nao existir
$pdo->exec("CREATE DATABASE IF NOT EXISTS $database");
$pdo->exec("USE $database");
echo "[OK] Banco de dados '$database' criado/selecionado.\n";

// 3. Executar schema.sql (criar tabelas)
$schemaFile = __DIR__ . '/schema.sql';

if (!file_exists($schemaFile)) {
    echo "[ERRO] Arquivo schema.sql nao encontrado em: $schemaFile\n";
    exit(1);
}

$schema = file_get_contents($schemaFile);

// Remover CREATE DATABASE e USE (ja fizemos acima)
$schema = preg_replace('/CREATE DATABASE IF NOT EXISTS \w+;/', '', $schema);
$schema = preg_replace('/USE \w+;/', '', $schema);

// Adicionar IF NOT EXISTS para tabelas (idempotente)
$schema = str_replace('CREATE TABLE ', 'CREATE TABLE IF NOT EXISTS ', $schema);

// Dividir por ; e executar cada statement
$statements = array_filter(array_map('trim', explode(';', $schema)));

foreach ($statements as $stmt) {
    if (!empty($stmt)) {
        $pdo->exec($stmt);
    }
}

echo "[OK] Tabelas criadas com sucesso.\n";
echo "     - Usuario\n";
echo "     - Noticia\n";
echo "     - Revisao\n";
echo "     - SolicitacaoCargo\n";

// 4. Limpar tabelas antes de popular (idempotente)
$pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
$pdo->exec("TRUNCATE TABLE SolicitacaoCargo");
$pdo->exec("TRUNCATE TABLE Revisao");
$pdo->exec("TRUNCATE TABLE Noticia");
$pdo->exec("TRUNCATE TABLE Usuario");
$pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
echo "[OK] Tabelas limpas para reinsercao dos dados.\n";

// 5. Executar seed (dados iniciais)
$seedFile = __DIR__ . '/seed.php';

if (!file_exists($seedFile)) {
    echo "[AVISO] Arquivo seed.php nao encontrado. Pulando populacao.\n";
    exit(0);
}

require $seedFile;

echo "\n=== Setup concluido com sucesso! ===\n";
echo "Acesse: http://localhost/AtlasJornal/public/\n";
