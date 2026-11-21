<?php
declare(strict_types=1);
namespace App\Models;

use App\Core\Database;
use App\Core\Model;

final class ServiceCategory extends Model
{
    protected static string $table = 'categories';
    protected static array $fillable = ['name', 'slug', 'status'];

    public static function nameExists(string $name, int $ignoreId = 0): bool
    {
        $stmt = Database::connection()->prepare(
            'SELECT 1 FROM `categories` WHERE name = ? AND id <> ? LIMIT 1'
        );
        $stmt->execute([$name, $ignoreId]);
        return (bool) $stmt->fetchColumn();
    }

    public static function slugExists(string $slug, int $ignoreId = 0): bool
    {
        $stmt = Database::connection()->prepare(
            'SELECT 1 FROM `categories` WHERE slug = ? AND id <> ? LIMIT 1'
        );
        $stmt->execute([$slug, $ignoreId]);
        return (bool) $stmt->fetchColumn();
    }

    /** Is any service attached to this category? */
    public static function hasServices(int $id): bool
    {
        $stmt = Database::connection()->prepare(
            'SELECT 1 FROM `services` WHERE category_id = ? LIMIT 1'
        );
        $stmt->execute([$id]);
        return (bool) $stmt->fetchColumn();
    }
}