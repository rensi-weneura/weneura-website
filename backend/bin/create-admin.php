<?php
declare(strict_types=1);

use App\Core\Database;
use App\Core\Env;

require __DIR__ . '/../vendor/autoload.php';
Env::load(__DIR__ . '/../.env');

[$script, $email, $name, $password] = $argv + [null, null, null, null];

if (!$email || !$name || !$password || strlen($password) < 8) {
    exit("Usage: php bin/create-admin.php email \"Name\" password(min 8 chars)\n");
}

$stmt = Database::connection()->prepare(
    'INSERT INTO admins (name, email, password, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())'
);
$stmt->execute([$name, $email, password_hash($password, PASSWORD_DEFAULT)]);
echo "Admin created: {$email}\n";