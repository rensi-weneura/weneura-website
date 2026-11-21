<?php
declare(strict_types=1);
namespace App\Core;

final class Upload
{
    private const ALLOWED = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/webp' => 'webp',
    ];

    /** Validate only. Returns an error message or null. */
    public static function validateImage(?array $file, int $maxBytes = 2097152): ?string
    {
        if ($file === null || $file['error'] === UPLOAD_ERR_NO_FILE) {
            return null; // no file chosen, caller decides if required
        }
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return 'Image upload failed';
        }
        if ($file['size'] > $maxBytes) {
            return 'Image may not be greater than ' . ($maxBytes / 1048576) . ' MB';
        }

        $mime = (new \finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']);
        if (!isset(self::ALLOWED[$mime])) {
            return 'Image must be a JPG, PNG or WEBP file';
        }
        return null;
    }

    /** Move file to public/uploads/{folder}. Returns the relative path to store in DB. */
    public static function saveImage(array $file, string $folder): string
    {
        $mime = (new \finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']);
        $name = bin2hex(random_bytes(16)) . '.' . self::ALLOWED[$mime];
        $dir  = BASE_PATH . "/public/uploads/{$folder}";

        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }
        move_uploaded_file($file['tmp_name'], "{$dir}/{$name}");

        return "uploads/{$folder}/{$name}";
    }

    public static function delete(?string $path): void
    {
        if ($path !== null && $path !== '') {
            $full = BASE_PATH . '/public/' . ltrim($path, '/');
            if (is_file($full)) {
                unlink($full);
            }
        }
    }
}