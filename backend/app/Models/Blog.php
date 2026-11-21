<?php
declare(strict_types=1);
namespace App\Models;
use App\Core\Database;
use App\Core\Model;
final class Blog extends Model
{
    // =========================================================================
    // 1. TABLE CONFIGURATION
    // =========================================================================
    protected static string $table = 'blog';
    protected static array $fillable = [
        'title',
        'slug',
        'short_description',
        'long_description',
        'image',
        'blog_category_id',
        'status',
    ];
    // =========================================================================
    // 2. ADMIN PANEL LOGIC (Called by App\Controllers\BlogController)
    // =========================================================================
    /**
     * Admin list page: retrieves ALL blogs (active & inactive)
     * joined with category title for the DataTables grid.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function allWithCategory(): array
    {
        $sql = 'SELECT b.id, b.title, b.slug, b.short_description, b.image, b.status, b.created_at,
                       b.blog_category_id, c.title AS category_title
                FROM `blog` b
                LEFT JOIN `blog_category` c ON c.id = b.blog_category_id
                ORDER BY b.id DESC';
        $stmt = Database::connection()->query($sql);
        return $stmt->fetchAll();
    }
    /**
     * Converts blog title to a URL-friendly slug and guarantees uniqueness.
     * Example: "Software ERP!" becomes "software-erp" (or "software-erp-2" if taken).
     */
    public static function slugify(string $title, ?int $ignoreId = null): string
    {
        $slug = strtolower(trim(preg_replace('/[^a-z0-9]+/i', '-', $title), '-'));
        $base = $slug !== '' ? $slug : 'blog';
        $slug = $base;
        $i = 2;
        while (self::slugExists($slug, $ignoreId)) {
            $slug = $base . '-' . $i++;
        }
        return $slug;
    }
    /**
     * Check if a slug already exists for another blog ID.
     */
    private static function slugExists(string $slug, ?int $ignoreId): bool
    {
        $stmt = Database::connection()->prepare(
            'SELECT id FROM `blog` WHERE slug = ? AND id <> ? LIMIT 1'
        );
        $stmt->execute([$slug, $ignoreId ?? 0]);
        return $stmt->fetch() !== false;
    }
    // =========================================================================
    // 3. FRONTEND / PUBLIC API LOGIC (Called by App\Controllers\API\BlogApiController)
    // =========================================================================
    /**
     * Frontend cards grid: retrieves ONLY active blogs (status = 1),
     * optionally filtered by category.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function activeWithCategory(?int $categoryId = null): array
    {
        $sql = 'SELECT b.id, b.title, b.slug, b.short_description, b.image, b.created_at,
                       b.blog_category_id AS category_id, c.title AS category_title
                FROM `blog` b
                LEFT JOIN `blog_category` c ON c.id = b.blog_category_id
                WHERE b.status = 1';
        $params = [];
        if ($categoryId !== null && $categoryId > 0) {
            $sql .= ' AND b.blog_category_id = ?';
            $params[] = $categoryId;
        }
        $stmt = Database::connection()->prepare($sql . ' ORDER BY b.id DESC');
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
    /**
     * Frontend article details: retrieves one active blog by ID with full content.
     *
     * @return array<string, mixed>|null
     */
    public static function findActive(int $id): ?array
    {
        $stmt = Database::connection()->prepare(
            'SELECT b.id, b.title, b.slug, b.short_description, b.long_description, b.image, b.created_at,
                    b.blog_category_id AS category_id, c.title AS category_title
             FROM `blog` b
             LEFT JOIN `blog_category` c ON c.id = b.blog_category_id
             WHERE b.id = ? AND b.status = 1
             LIMIT 1'
        );
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row === false ? null : $row;
    }
    /**
     * Frontend article details: retrieves one active blog by Slug with full content.
     *
     * @return array<string, mixed>|null
     */
    public static function findActiveBySlug(string $slug): ?array
    {
        $stmt = Database::connection()->prepare(
            'SELECT b.id, b.title, b.slug, b.short_description, b.long_description, b.image, b.created_at,
                    b.blog_category_id AS category_id, c.title AS category_title
             FROM `blog` b
             LEFT JOIN `blog_category` c ON c.id = b.blog_category_id
             WHERE b.slug = ? AND b.status = 1
             LIMIT 1'
        );
        $stmt->execute([$slug]);
        $row = $stmt->fetch();
        return $row === false ? null : $row;
    }
}