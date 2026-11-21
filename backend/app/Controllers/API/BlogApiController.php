<?php

declare(strict_types=1);

namespace App\Controllers\API;

use App\Models\Blog;
use App\Models\BlogCategory;

final class BlogApiController
{
    // GET /api/blog-categories
    public function categories(): void
    {
        $this->cors();
        json_response(['data' => BlogCategory::active()]);
    }

    // GET /api/blogs?category=3
    public function index(): void
    {
        $this->cors();
        $categoryId = isset($_GET['category']) ? (int) $_GET['category'] : null;

        $blogs = array_map(
            fn(array $b) => $this->withImageUrl($b),
            Blog::activeWithCategory($categoryId)
        );

        json_response(['data' => $blogs]);
    }








    // GET /api/blogs/{identifier} (can be ID or Slug)
    public function show(string $identifier): void
    {
        $this->cors();

        // If numeric ID, search by ID. Otherwise, search by slug.
        $blog = ctype_digit($identifier)
            ? Blog::findActive((int) $identifier)
            : Blog::findActiveBySlug($identifier);

        if ($blog === null) {
            json_response(['success' => false, 'message' => 'Blog not found'], 404);
        }

        json_response(['data' => $this->withImageUrl($blog)]);
    }

    /** Turn "uploads/blog/abc.jpg" into a full URL the frontend can load. */
    private function withImageUrl(array $blog): array
    {
        $blog['image'] = !empty($blog['image']) ? $this->baseUrl() . '/' . ltrim($blog['image'], '/') : null;
        return $blog;
    }

    private function baseUrl(): string
    {
        $https = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost:8000';
        return ($https ? 'https' : 'http') . '://' . $host;
    }

    /** CORS headers */
    private function cors(): void
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
        if (($_SERVER['REQUEST_METHOD'] ?? '') === 'OPTIONS') {
            http_response_code(200);
            exit;
        }
    }
}
