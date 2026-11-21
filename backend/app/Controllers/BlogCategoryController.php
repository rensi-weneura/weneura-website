<?php
declare(strict_types=1);
namespace App\Controllers;

use App\Core\View;
use App\Models\BlogCategory;

final class BlogCategoryController
{
    public function index(): void
    {
        View::render('admin/blog_category/list', [
            'title'      => 'Blog Category',
            'activeMenu' => 'blog_category',
            'success'    => flash('success'),
            'error'      => flash('error'),
        ]);
    }

    public function data(): void
    {
        json_response(['data' => BlogCategory::all()]);
    }

    public function create(): void
    {
        View::render('admin/blog_category/add', [
            'title'      => 'Add Blog Category',
            'activeMenu' => 'blog_category',
            'error'      => flash('error'),
            'oldTitle'   => flash('old_title'),
            'oldStatus'  => flash('old_status') ?? '1',
        ]);
    }

    public function store(): void
    {
        [$title, $status, $error] = $this->input();

        if ($error !== null) {
            flash('error', $error);
            flash('old_title', $title);
            flash('old_status', (string) $status);
            redirect('/admin/blog-category/add');
        }

        BlogCategory::create(['title' => $title, 'status' => $status]);
        flash('success', 'Blog category added successfully');
        redirect('/admin/blog-category');
    }

    public function edit(string $id): void
    {
        $category = BlogCategory::find((int) $id);
        if ($category === null) {
            flash('error', 'Blog category not found');
            redirect('/admin/blog-category');
        }

        View::render('admin/blog_category/edit', [
            'title'      => 'Edit Blog Category',
            'activeMenu' => 'blog_category',
            'error'      => flash('error'),
            'category'   => $category,
        ]);
    }

    public function update(string $id): void
    {
        $id = (int) $id;
        if (BlogCategory::find($id) === null) {
            flash('error', 'Blog category not found');
            redirect('/admin/blog-category');
        }

        [$title, $status, $error] = $this->input($id);

        if ($error !== null) {
            flash('error', $error);
            redirect('/admin/blog-category/edit/' . $id);
        }

        BlogCategory::update($id, ['title' => $title, 'status' => $status]);
        flash('success', 'Blog category updated successfully');
        redirect('/admin/blog-category');
    }

    public function updateStatus(): void
    {
        $id = (int) ($_POST['id'] ?? 0);
        $status = ($_POST['status'] ?? '') === '1' ? 1 : 0;

        if (BlogCategory::find($id) === null) {
            json_response(['success' => false, 'message' => 'Not found'], 404);
        }

        BlogCategory::update($id, ['status' => $status]);
        json_response(['success' => true]);
    }

    public function destroy(string $id): void
    {
        $id = (int) $id;
        if (BlogCategory::find($id) === null) {
            json_response(['success' => false, 'message' => 'Blog category not found'], 404);
        }

        BlogCategory::delete($id);
        json_response(['success' => true]);
    }

    /** @return array{0:string,1:int,2:?string} */
    private function input(int $ignoreId = 0): array
    {
        $title  = trim((string) ($_POST['title'] ?? ''));
        $status = ($_POST['status'] ?? '1') === '0' ? 0 : 1;
        $error  = null;

        if ($title === '') {
            $error = 'Title is required';
        } elseif (mb_strlen($title) > 255) {
            $error = 'Title may not be greater than 255 characters';
        } elseif (BlogCategory::titleExists($title, $ignoreId)) {
            $error = 'This category already exists';
        }

        return [$title, $status, $error];
    }
}