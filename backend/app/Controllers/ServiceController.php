<?php
declare(strict_types=1);
namespace App\Controllers;

use App\Core\View;
use App\Models\Service;

final class ServiceController
{
    public function index(): void
    {
        View::render('admin/service/list', [
            'title'      => 'Services',
            'activeMenu' => 'service',
            'success'    => flash('success'),
            'error'      => flash('error'),
        ]);
    }

    public function data(): void
    {
        json_response(['data' => Service::allWithCategory()]);
    }

    public function create(): void
    {
        $old = json_decode((string) flash('old'), true);

        View::render('admin/service/add', [
            'title'      => 'Add Service',
            'activeMenu' => 'service',
            'error'      => flash('error'),
            'values'     => array_merge(self::defaults(), is_array($old) ? $old : []),
            'categories' => Service::categoryOptions(),
        ]);
    }

    public function store(): void
    {
        [$data, $error] = $this->input();

        if ($error !== null) {
            flash('error', $error);
            flash('old', json_encode($data, JSON_UNESCAPED_UNICODE));
            redirect('/admin/service/add');
        }

        Service::create($data);
        flash('success', 'Service added successfully');
        redirect('/admin/service');
    }

    public function edit(string $id): void
    {
        $service = Service::find((int) $id);
        if ($service === null) {
            flash('error', 'Service not found');
            redirect('/admin/service');
        }

        View::render('admin/service/edit', [
            'title'      => 'Edit Service',
            'activeMenu' => 'service',
            'error'      => flash('error'),
            'values'     => array_merge(self::defaults(), $service),
            'categories' => Service::categoryOptions((int) $service['category_id']),
        ]);
    }

    public function update(string $id): void
    {
        $id = (int) $id;
        if (Service::find($id) === null) {
            flash('error', 'Service not found');
            redirect('/admin/service');
        }

        [$data, $error] = $this->input($id);

        if ($error !== null) {
            flash('error', $error);
            redirect('/admin/service/edit/' . $id);
        }

        Service::update($id, $data);
        flash('success', 'Service updated successfully');
        redirect('/admin/service');
    }

    public function updateStatus(): void
    {
        $id = (int) ($_POST['id'] ?? 0);
        $status = ($_POST['status'] ?? '') === '1' ? 1 : 0;

        if (Service::find($id) === null) {
            json_response(['success' => false, 'message' => 'Not found'], 404);
        }

        Service::update($id, ['status' => $status]);
        json_response(['success' => true]);
    }

    public function destroy(string $id): void
    {
        $id = (int) $id;
        if (Service::find($id) === null) {
            json_response(['success' => false, 'message' => 'Service not found'], 404);
        }

        Service::delete($id);
        json_response(['success' => true]);
    }

    /** @return array<string,mixed> */
    private static function defaults(): array
    {
        return [
            'category_id'       => '',
            'title'             => '',
            'slug'              => '',
            'short_description' => '',
            'long_description'  => '',
            'meta_title'        => '',
            'status'            => 1,
        ];
    }

    /** @return array{0:array<string,mixed>,1:?string} [data, error] */
    private function input(int $ignoreId = 0): array
    {
        $categoryId = (int) ($_POST['category_id'] ?? 0);
        $title      = trim((string) ($_POST['title'] ?? ''));
        $slugInput  = trim((string) ($_POST['slug'] ?? ''));
        $slug       = self::slugify($slugInput !== '' ? $slugInput : $title);
        $short      = trim((string) ($_POST['short_description'] ?? ''));
        $long       = trim((string) ($_POST['long_description'] ?? ''));
        $meta       = trim((string) ($_POST['meta_title'] ?? ''));
        $status     = ($_POST['status'] ?? '1') === '0' ? 0 : 1;

        $data = [
            'category_id'       => $categoryId,
            'title'             => $title,
            'slug'              => $slug,
            'short_description' => $short !== '' ? $short : null,
            'long_description'  => $long !== '' ? $long : null,
            'meta_title'        => $meta !== '' ? $meta : null,
            'status'            => $status,
        ];

        $error = null;

        if ($categoryId <= 0 || !Service::categoryExists($categoryId)) {
            $error = 'Please select a valid category';
        } elseif ($title === '') {
            $error = 'Title is required';
        } elseif (mb_strlen($title) > 200) {
            $error = 'Title may not be greater than 200 characters';
        } elseif ($slug === '') {
            $error = 'Slug could not be generated from this title';
        } elseif (mb_strlen($slug) > 160) {
            $error = 'Slug may not be greater than 160 characters';
        } elseif (mb_strlen($short) > 255) {
            $error = 'Short description may not be greater than 255 characters';
        } elseif (mb_strlen($meta) > 200) {
            $error = 'Meta title may not be greater than 200 characters';
        } elseif (Service::titleExists($title, $ignoreId)) {
            $error = 'This service already exists';
        } elseif (Service::slugExists($slug, $ignoreId)) {
            $error = 'This slug is already used by another service';
        }

        return [$data, $error];
    }

    private static function slugify(string $text): string
    {
        $text = mb_strtolower($text);
        $text = (string) preg_replace('/[^a-z0-9]+/', '-', $text);
        return trim($text, '-');
    }
}