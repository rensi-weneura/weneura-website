<?php
declare(strict_types=1);
namespace App\Controllers;

use App\Core\View;
use App\Models\ServiceCategory;

final class ServiceCategoryController
{
    public function index(): void
    {
        View::render('admin/service_category/list', [
            'title'      => 'Service Category',
            'activeMenu' => 'service_category',
            'success'    => flash('success'),
            'error'      => flash('error'),
        ]);
    }

    public function data(): void
    {
        json_response(['data' => ServiceCategory::all()]);
    }

    public function create(): void
    {
        View::render('admin/service_category/add', [
            'title'      => 'Add Service Category',
            'activeMenu' => 'service_category',
            'error'      => flash('error'),
            'oldName'    => flash('old_name') ?? '',
            'oldSlug'    => flash('old_slug') ?? '',
            'oldStatus'  => flash('old_status') ?? '1',
        ]);
    }

    public function store(): void
    {
        [$data, $error] = $this->input();

        if ($error !== null) {
            flash('error', $error);
            flash('old_name', $data['name']);
            flash('old_slug', $data['slug']);
            flash('old_status', (string) $data['status']);
            redirect('/admin/service-category/add');
        }

        ServiceCategory::create($data);
        flash('success', 'Service category added successfully');
        redirect('/admin/service-category');
    }

    public function edit(string $id): void
    {
        $id = (int) $id;
        $category = ServiceCategory::find($id);
        if ($category === null) {
            flash('error', 'Service category not found');
            redirect('/admin/service-category');
        }

        View::render('admin/service_category/edit', [
            'title'      => 'Edit Service Category',
            'activeMenu' => 'service_category',
            'error'      => flash('error'),
            'category'   => $category,
        ]);
    }

    public function update(string $id): void
    {
        $id = (int) $id;
        if (ServiceCategory::find($id) === null) {
            flash('error', 'Service category not found');
            redirect('/admin/service-category');
        }

        [$data, $error] = $this->input($id);

        if ($error !== null) {
            flash('error', $error);
            redirect('/admin/service-category/edit/' . $id);
        }

        ServiceCategory::update($id, $data);
        flash('success', 'Service category updated successfully');
        redirect('/admin/service-category');
    }

    public function updateStatus(): void
    {
        $id = (int) ($_POST['id'] ?? 0);
        $status = ($_POST['status'] ?? '') === '1' ? 1 : 0;

        if (ServiceCategory::find($id) === null) {
            json_response(['success' => false, 'message' => 'Not found'], 404);
        }

        ServiceCategory::update($id, ['status' => $status]);
        json_response(['success' => true]);
    }

    public function destroy(string $id): void
    {
        $id = (int) $id;
        if (ServiceCategory::find($id) === null) {
            json_response(['success' => false, 'message' => 'Service category not found'], 404);
        }

        if (ServiceCategory::hasServices($id)) {
            json_response(['success' => false, 'message' => 'Cannot delete: Services are attached to this category'], 422);
        }

        ServiceCategory::delete($id);
        json_response(['success' => true]);
    }

    /** @return array{0:array<string,mixed>,1:?string} [data, error] */
    private function input(int $ignoreId = 0): array
    {
        $name      = trim((string) ($_POST['name'] ?? ''));
        $slugInput = trim((string) ($_POST['slug'] ?? ''));
        $slug      = self::slugify($slugInput !== '' ? $slugInput : $name);
        $status    = ($_POST['status'] ?? '1') === '0' ? 0 : 1;

        $data = [
            'name'   => $name,
            'slug'   => $slug,
            'status' => $status,
        ];

        $error = null;

        if ($name === '') {
            $error = 'Name is required';
        } elseif (mb_strlen($name) > 150) {
            $error = 'Name may not be greater than 150 characters';
        } elseif ($slug === '') {
            $error = 'Slug could not be generated from this name';
        } elseif (mb_strlen($slug) > 160) {
            $error = 'Slug may not be greater than 160 characters';
        } elseif (ServiceCategory::nameExists($name, $ignoreId)) {
            $error = 'This service category already exists';
        } elseif (ServiceCategory::slugExists($slug, $ignoreId)) {
            $error = 'This slug is already used by another category';
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
