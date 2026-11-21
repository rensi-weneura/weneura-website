<?php
declare(strict_types=1);
namespace App\Core;

abstract class Model
{
    protected static string $table;
    protected static array $fillable = [];

    public static function all(): array
    {
        return Database::connection()
            ->query('SELECT * FROM `' . static::$table . '` ORDER BY id DESC')
            ->fetchAll();
    }

    public static function find(int $id): ?array
    {
        $stmt = Database::connection()->prepare('SELECT * FROM `' . static::$table . '` WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public static function count(): int
    {
        return (int) Database::connection()->query('SELECT COUNT(*) FROM `' . static::$table . '`')->fetchColumn();
    }

    public static function create(array $data): int
    {
        $data = array_intersect_key($data, array_flip(static::$fillable));
        $cols = implode(',', array_map(fn($c) => "`$c`", array_keys($data)));
        $marks = implode(',', array_fill(0, count($data), '?'));

        $pdo = Database::connection();
        $pdo->prepare('INSERT INTO `' . static::$table . "` ($cols) VALUES ($marks)")->execute(array_values($data));
        return (int) $pdo->lastInsertId();
    }

    public static function update(int $id, array $data): void
    {
        $data = array_intersect_key($data, array_flip(static::$fillable));
        $set = implode(',', array_map(fn($c) => "`$c` = ?", array_keys($data)));

        Database::connection()
            ->prepare('UPDATE `' . static::$table . "` SET $set, updated_at = NOW() WHERE id = ?")
            ->execute([...array_values($data), $id]);
    }

    public static function delete(int $id): void
    {
        Database::connection()->prepare('DELETE FROM `' . static::$table . '` WHERE id = ?')->execute([$id]);
    }
}