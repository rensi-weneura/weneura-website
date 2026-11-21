<?php
declare(strict_types=1);
namespace App\Models;

use App\Core\Database;
use App\Core\Model;
use PDO;

final class Service extends Model
{
    protected static string $table = 'services';
    protected static array $fillable = [
        'category_id', 'title', 'slug',
        'short_description', 'long_description', 'meta_title', 'status',
    ];

    /** List page: every service with its category name (grouped by category). */
    public static function allWithCategory(): array
    {
        $stmt = Database::connection()->query(
            'SELECT s.id, s.title, s.slug, s.status, s.created_at, c.name AS category_name
               FROM `services` s
               JOIN `categories` c ON c.id = s.category_id
              ORDER BY c.id, s.id'
        );
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Dropdown options: active categories only.
     * $includeId keeps the current category visible on edit even if it is inactive.
     */
    public static function categoryOptions(int $includeId = 0): array
    {
        $stmt = Database::connection()->prepare(
            'SELECT id, name FROM `categories` WHERE status = 1 OR id = ? ORDER BY id'
        );
        $stmt->execute([$includeId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function categoryExists(int $categoryId): bool
    {
        $stmt = Database::connection()->prepare(
            'SELECT 1 FROM `categories` WHERE id = ? LIMIT 1'
        );
        $stmt->execute([$categoryId]);
        return (bool) $stmt->fetchColumn();
    }

    public static function titleExists(string $title, int $ignoreId = 0): bool
    {
        $stmt = Database::connection()->prepare(
            'SELECT 1 FROM `services` WHERE title = ? AND id <> ? LIMIT 1'
        );
        $stmt->execute([$title, $ignoreId]);
        return (bool) $stmt->fetchColumn();
    }

    public static function slugExists(string $slug, int $ignoreId = 0): bool
    {
        $stmt = Database::connection()->prepare(
            'SELECT 1 FROM `services` WHERE slug = ? AND id <> ? LIMIT 1'
        );
        $stmt->execute([$slug, $ignoreId]);
        return (bool) $stmt->fetchColumn();
    }
}