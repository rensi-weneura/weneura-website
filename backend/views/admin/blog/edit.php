<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= e($error) ?></div>
        <?php endif; ?>

        <div class="card mb-6">
            <h5 class="card-header">Edit Blog</h5>
            <form class="card-body" method="POST" action="/admin/blog/edit/<?= (int) $blog['id'] ?>" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="row g-6">

                    <div class="col-md-6">
                        <label class="form-label" for="blog_category_id">Category</label>
                        <span class="req">*</span>
                        <select name="blog_category_id" id="blog_category_id" class="form-select" required>
                            <option value="">-- Select Category --</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= (int) $cat['id'] ?>"
                                    <?= (int) $blog['blog_category_id'] === (int) $cat['id'] ? 'selected' : '' ?>>
                                    <?= e($cat['title']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" for="status">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="1" <?= (int) $blog['status'] === 1 ? 'selected' : '' ?>>Active</option>
                            <option value="0" <?= (int) $blog['status'] === 0 ? 'selected' : '' ?>>Inactive</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label" for="title">Title</label>
                        <span class="req">*</span>
                        <input type="text" name="title" id="title" class="form-control"
                            value="<?= e((string) $blog['title']) ?>"
                            placeholder="Enter blog title" maxlength="255" required />
                    </div>

                    <div class="col-12">
                        <label class="form-label" for="short_description">Short Description</label>
                        <span class="req">*</span>
                        <textarea name="short_description" id="short_description" class="form-control" rows="3"
                            maxlength="255" required
                            placeholder="Shown on the blog list and cards (max 255 characters)"><?= e((string) $blog['short_description']) ?></textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" for="image">Image</label>
                        <div class="image-upload">
                            <input type="file" name="image" id="image" class="file-input"
                                accept="image/jpeg,image/png,image/webp"
                                onchange="previewImage(event, 'image-preview', 'image-label')" />

                            <label for="image" class="file-label" id="image-label">
                                <?php if (empty($blog['image'])): ?>
                                    <p>Add Image</p>
                                <?php endif; ?>
                            </label>

                            <img id="image-preview" class="photo-preview" alt="Blog image"
                                <?php if (!empty($blog['image'])): ?>
                                src="/<?= e($blog['image']) ?>" style="display:block"
                                <?php endif; ?> />
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="form-label" for="long_description">Long Description</label>
                        <span class="req">*</span>
                        <!-- No "required": CKEditor hides the textarea, so the browser can't validate it. Server validates. -->
                        <textarea name="long_description" id="long_description" class="content"><?= e((string) $blog['long_description']) ?></textarea>
                    </div>

                </div>

                <div class="pt-6">
                    <button type="submit" class="btn btn-primary me-4">Update</button>
                    <a href="/admin/blog" class="btn btn-label-secondary">Cancel</a>
                </div>
            </form>
        </div>

    </div>
</div>

<?php ob_start(); ?>

<script src="<?= asset('js/ckeditor-classic.bundle.js') ?>"></script>
<script>
    (function() {
        window.previewImage = function(event, previewId, labelId) {
            const file = event.target.files[0];
            const preview = document.getElementById(previewId);
            const label = document.getElementById(labelId);
            if (!file || !preview) return;

            const reader = new FileReader();
            reader.onload = () => {
                preview.src = reader.result;
                preview.style.display = 'block';
                if (label) label.style.display = 'none';
            };
            reader.readAsDataURL(file);
        };

        const initEditor = () => {
            const el = document.querySelector('.content');
            if (!el) return;

            ClassicEditor.create(el, {
                toolbar: [
                    'undo', 'redo', '|',
                    'heading', '|',
                    'bold', 'italic', '|',
                    'bulletedList', 'numberedList', 'outdent', 'indent'
                ]
            }).catch((err) => console.error('CKEditor init failed:', err));
        };

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initEditor);
        } else {
            initEditor();
        }
    })();
</script>
<?php $pageScripts = ob_get_clean(); ?>