<?php
declare(strict_types=1);
namespace App\Core;

final class Auth
{
    public static function attempt(string $email, string $password): bool
    {
        $stmt = Database::connection()->prepare('SELECT id, name, email, password FROM admins WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        $admin = $stmt->fetch();

        if (!$admin || !password_verify($password, $admin['password'])) {
            return false;
        }

        session_regenerate_id(true);
        $_SESSION['admin'] = ['id' => (int) $admin['id'], 'name' => $admin['name'], 'email' => $admin['email']];
        return true;
    }

    public static function check(): bool
    {
        return isset($_SESSION['admin']);
    }

    public static function user(): ?array
    {
        return $_SESSION['admin'] ?? null;
    }

    public static function logout(): void
    {
        $_SESSION = [];
        session_destroy();
    }
}