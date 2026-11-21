<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">

    <?php if (!empty($error)): ?>
      <div class="alert alert-danger"><?= e($error) ?></div>
    <?php endif; ?>

    <div class="card mb-6">
      <h5 class="card-header">Add Service Category</h5>
      <form class="card-body" method="POST" action="/admin/service-category/add">
        <?= csrf_field() ?>
        <div class="row g-6">
          <div class="col-md-6">
            <label class="form-label" for="name">Name</label>
            <span class="req">*</span>
            <input type="text" name="name" id="name" class="form-control"
                   value="<?= e($oldName) ?>" placeholder="e.g. Software Development" maxlength="150" required />
          </div>

          <div class="col-md-6">
            <label class="form-label" for="slug">Slug</label>
            <input type="text" name="slug" id="slug" class="form-control"
                   value="<?= e($oldSlug) ?>" placeholder="auto-generated from name" maxlength="160" />
          </div>

          <div class="col-md-6">
            <label class="form-label" for="status">Status</label>
            <select name="status" id="status" class="form-select">
              <option value="1" <?= (string) $oldStatus === '1' ? 'selected' : '' ?>>Active</option>
              <option value="0" <?= (string) $oldStatus === '0' ? 'selected' : '' ?>>Inactive</option>
            </select>
          </div>
        </div>

        <div class="pt-6">
          <button type="submit" class="btn btn-primary me-4">Submit</button>
          <a href="/admin/service-category" class="btn btn-label-secondary">Cancel</a>
        </div>
      </form>
    </div>

  </div>
</div>

<?php ob_start(); ?>
<script>
  // Auto-fill slug from name until the user edits the slug by hand
  const nameInput = document.getElementById('name');
  const slugInput = document.getElementById('slug');
  let slugTouched = slugInput.value.trim() !== '';

  const slugify = (s) => s.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');

  slugInput.addEventListener('input', () => { slugTouched = slugInput.value.trim() !== ''; });
  nameInput.addEventListener('input', () => {
    if (!slugTouched) slugInput.value = slugify(nameInput.value);
  });
</script>
<?php $pageScripts = ob_get_clean(); ?>