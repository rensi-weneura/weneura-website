<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use App\Core\Model;

final class BlogCategory extends Model
{
    protected static string $table = 'blog_category';
    protected static array $fillable = ['title', 'status'];

    public static function titleExists(string $title, int $ignoreId = 0): bool
    {
        $stmt = Database::connection()->prepare(
            'SELECT 1 FROM `blog_category` WHERE title = ? AND id <> ? LIMIT 1'
        );
        $stmt->execute([$title, $ignoreId]);
        return (bool) $stmt->fetchColumn();
    }

    /** @return array<int,array<string,mixed>> Active categories for the public site */
    public static function active(): array
    {
        $stmt = Database::connection()->query(
            'SELECT id, title FROM `blog_category` WHERE status = 1 ORDER BY id ASC'
        );
        return $stmt->fetchAll();
    }
}