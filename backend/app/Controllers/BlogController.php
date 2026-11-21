<?php
declare(strict_types=1);
namespace App\Controllers;

use App\Core\Upload;
use App\Core\View;
use App\Models\Blog;
use App\Models\BlogCategory;

final class BlogController
{
    public function index(): void
    {
        View::render('admin/blog/list', [
            'title'      => 'Blog',
            'activeMenu' => 'blog',
            'success'    => flash('success'),
            'error'      => flash('error'),
        ]);
    }

    public function data(): void
    {
        json_response(['data' => Blog::allWithCategory()]);
    }

    public function create(): void
    {
        View::render('admin/blog/add', [
            'title'      => 'Add Blog',
            'activeMenu' => 'blog',
            'error'      => flash('error'),
            'categories' => $this->activeCategories(),
            'old'        => [
                'blog_category_id'  => flash('old_blog_category_id'),
                'title'             => flash('old_title'),
                'short_description' => flash('old_short_description'),
                'long_description'  => flash('old_long_description'),
                'status'            => flash('old_status') ?? '1',
            ],
        ]);
    }

    public function store(): void
    {
        [$data, $error] = $this->input(imageRequired: true);

        if ($error !== null) {
            $this->flashOld($data, $error);
            redirect('/admin/blog/add');
        }

        $data['slug']  = Blog::slugify($data['title']);
        $data['image'] = Upload::saveImage($_FILES['image'], 'blog');

        Blog::create($data);
        flash('success', 'Blog added successfully');
        redirect('/admin/blog');
    }

    public function edit(string $id): void
    {
        $blog = Blog::find((int) $id);
        if ($blog === null) {
            flash('error', 'Blog not found');
            redirect('/admin/blog');
        }

        View::render('admin/blog/edit', [
            'title'      => 'Edit Blog',
            'activeMenu' => 'blog',
            'error'      => flash('error'),
            'blog'       => $blog,
            'categories' => $this->activeCategories(),
        ]);
    }

    public function update(string $id): void
    {
        $id   = (int) $id;
        $blog = Blog::find($id);
        if ($blog === null) {
            flash('error', 'Blog not found');
            redirect('/admin/blog');
        }

        [$data, $error] = $this->input(imageRequired: false);

        if ($error !== null) {
            flash('error', $error);
            redirect('/admin/blog/edit/' . $id);
        }

        // Replace image only if a new one was uploaded
        if (($_FILES['image']['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_OK) {
            $data['image'] = Upload::saveImage($_FILES['image'], 'blog');
            Upload::delete($blog['image'] ?? null);
        }

        if ($data['title'] !== ($blog['title'] ?? '') || empty($blog['slug'])) {
            $data['slug'] = Blog::slugify($data['title'], $id);
        }

        Blog::update($id, $data);
        flash('success', 'Blog updated successfully');
        redirect('/admin/blog');
    }

    public function updateStatus(): void
    {
        $id     = (int) ($_POST['id'] ?? 0);
        $status = ($_POST['status'] ?? '') === '1' ? 1 : 0;

        if (Blog::find($id) === null) {
            json_response(['success' => false, 'message' => 'Not found'], 404);
        }

        Blog::update($id, ['status' => $status]);
        json_response(['success' => true]);
    }

    public function destroy(string $id): void
    {
        $id   = (int) $id;
        $blog = Blog::find($id);
        if ($blog === null) {
            json_response(['success' => false, 'message' => 'Blog not found'], 404);
        }

        Blog::delete($id);
        Upload::delete($blog['image'] ?? null);
        json_response(['success' => true]);
    }

    /** @return array<int,array<string,mixed>> */
    private function activeCategories(): array
    {
        return array_values(array_filter(
            BlogCategory::all(),
            fn(array $c) => (int) $c['status'] === 1
        ));
    }

    /** @return array{0:array<string,mixed>,1:?string} */
    private function input(bool $imageRequired): array
    {
        $data = [
            'blog_category_id'  => (int) ($_POST['blog_category_id'] ?? 0),
            'title'             => trim((string) ($_POST['title'] ?? '')),
            'short_description' => trim((string) ($_POST['short_description'] ?? '')),
            'long_description'  => trim((string) ($_POST['long_description'] ?? '')),
            'status'            => ($_POST['status'] ?? '1') === '0' ? 0 : 1,
        ];

        $error = null;
        $file  = $_FILES['image'] ?? null;

        if ($data['blog_category_id'] === 0 || BlogCategory::find($data['blog_category_id']) === null) {
            $error = 'Please select a valid category';
        } elseif ($data['title'] === '') {
            $error = 'Title is required';
        } elseif (mb_strlen($data['title']) > 255) {
            $error = 'Title may not be greater than 255 characters';
        } elseif ($data['short_description'] === '') {
            $error = 'Short description is required';
        } elseif (mb_strlen($data['short_description']) > 255) {
            $error = 'Short description may not be greater than 255 characters';
        } elseif ($data['long_description'] === '') {
            $error = 'Long description is required';
        } elseif ($imageRequired && ($file === null || $file['error'] === UPLOAD_ERR_NO_FILE)) {
            $error = 'Image is required';
        } else {
            $error = Upload::validateImage($file);
        }

        return [$data, $error];
    }

    private function flashOld(array $data, string $error): void
    {
        flash('error', $error);
        foreach ($data as $key => $value) {
            flash('old_' . $key, (string) $value);
        }
    }
}