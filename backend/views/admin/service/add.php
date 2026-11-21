<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">

    <?php if (!empty($error)): ?>
      <div class="alert alert-danger"><?= e($error) ?></div>
    <?php endif; ?>

    <?php if (empty($categories)): ?>
      <div class="alert alert-warning">
        No active category found. Please <a href="/admin/service-category/add">add a service category</a> first.
      </div>
    <?php endif; ?>

    <div class="card mb-6">
      <h5 class="card-header">Add Service</h5>
      <form class="card-body" method="POST" action="/admin/service/add">
        <?= csrf_field() ?>
        <div class="row g-6">

          <div class="col-md-6">
            <label class="form-label" for="category_id">Category</label>
            <span class="req">*</span>
            <select name="category_id" id="category_id" class="form-select" required>
              <option value="">-- Select Category --</option>
              <?php foreach ($categories as $cat): ?>
                <option value="<?= (int) $cat['id'] ?>"
                  <?= (int) $values['category_id'] === (int) $cat['id'] ? 'selected' : '' ?>>
                  <?= e($cat['name']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="col-md-6">
            <label class="form-label" for="status">Status</label>
            <select name="status" id="status" class="form-select">
              <option value="1" <?= (string) $values['status'] === '1' ? 'selected' : '' ?>>Active</option>
              <option value="0" <?= (string) $values['status'] === '0' ? 'selected' : '' ?>>Inactive</option>
            </select>
          </div>

          <div class="col-md-6">
            <label class="form-label" for="title">Title</label>
            <span class="req">*</span>
            <input type="text" name="title" id="title" class="form-control"
                   value="<?= e((string) $values['title']) ?>"
                   placeholder="e.g. Custom ERP Development" maxlength="200" required />
          </div>

          <div class="col-md-6">
            <label class="form-label" for="slug">Slug</label>
            <input type="text" name="slug" id="slug" class="form-control"
                   value="<?= e((string) $values['slug']) ?>"
                   placeholder="auto-generated from title" maxlength="160" />
          </div>

          <div class="col-12">
            <label class="form-label" for="short_description">Short Description</label>
            <textarea name="short_description" id="short_description" class="form-control" rows="3"
                      maxlength="255" placeholder="Shown on the services list and cards (max 255 characters)"><?= e((string) $values['short_description']) ?></textarea>
          </div>

          <div class="col-12">
            <label class="form-label" for="long_description">Long Description</label>
            <!-- No "required" here: CKEditor hides the textarea, so the browser can't validate it -->
            <textarea name="long_description" id="long_description" class="content"><?= e((string) $values['long_description']) ?></textarea>
          </div>

          <div class="col-12">
            <label class="form-label" for="meta_title">Meta Title</label>
            <input type="text" name="meta_title" id="meta_title" class="form-control"
                   value="<?= e((string) $values['meta_title']) ?>"
                   placeholder="Shown in the browser tab and Google results" maxlength="200" />
          </div>

        </div>

        <div class="pt-6">
          <button type="submit" class="btn btn-primary me-4">Submit</button>
          <a href="/admin/service" class="btn btn-label-secondary">Cancel</a>
        </div>
      </form>
    </div>

  </div>
</div>

<?php ob_start(); ?>
<style>
  /* CKEditor 5 has no "height" option, so set it with CSS */
  .ck-editor__editable_inline { min-height: 320px; }
</style>
<script src="<?= asset('js/ckeditor-classic.bundle.js') ?>"></script>
<script>
  (function () {
    // Slug auto-fill from title (stops once the slug is filled/edited by hand)
    const titleInput = document.getElementById('title');
    const slugInput  = document.getElementById('slug');
    let slugTouched  = slugInput.value.trim() !== '';

    const slugify = (s) => s.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');

    slugInput.addEventListener('input', () => { slugTouched = slugInput.value.trim() !== ''; });
    titleInput.addEventListener('input', () => {
      if (!slugTouched) slugInput.value = slugify(titleInput.value);
    });

    // CKEditor (same toolbar as the blog reference)
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