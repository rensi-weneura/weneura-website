<?php
declare(strict_types=1);
namespace App\Controllers;

use App\Core\Auth;
use App\Core\View;

final class AuthController
{
    public function showLogin(): void   
    {
        View::render('admin/auth/login', [
            'title'    => 'Admin Login',
            'error'    => flash('error'),
            'success'  => flash('success'),
            'oldEmail' => flash('old_email'),
        ], 'layouts/auth');
    }

    public function login(): void
    {
        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($email === '' || $password === '' || !Auth::attempt($email, $password)) {
            flash('error', 'Invalid email or password');
            flash('old_email', $email);
            redirect('/admin/login');
        }

        redirect('/admin');
    }

    public function logout(): void
    {
        Auth::logout();
        redirect('/admin/login');
    }
}