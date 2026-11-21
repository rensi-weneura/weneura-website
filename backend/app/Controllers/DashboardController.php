<?php
declare(strict_types=1);
namespace App\Controllers;

use App\Core\Database;
use App\Core\View;
use PDOException;

final class DashboardController
{
    public function index(): void
    {
        View::render('admin/dashboard', [
            'title'          => 'Dashboard',
            'activeMenu'     => 'dashboard',
            'error'          => flash('error'),
            'careerCount'    => $this->count('careers'),
            'blogCount'      => $this->count('blogs'),
        ], 'layouts/main');
    }

    private function count(string $table): int
    {
        try {
            return (int) Database::connection()->query("SELECT COUNT(*) FROM `{$table}`")->fetchColumn();
        } catch (PDOException) {
            return 0;
        }
    }
}