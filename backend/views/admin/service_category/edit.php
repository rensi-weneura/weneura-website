<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">

    <?php if (!empty($error)): ?>
      <div class="alert alert-danger"><?= e($error) ?></div>
    <?php endif; ?>

    <div class="card mb-6">
      <h5 class="card-header">Edit Service Category</h5>
      <form class="card-body" method="POST" action="/admin/service-category/edit/<?= (int) $category['id'] ?>">
        <?= csrf_field() ?>
        <div class="row g-6">
          <div class="col-md-6">
            <label class="form-label" for="name">Name</label>
            <span class="req">*</span>
            <input type="text" name="name" id="name" class="form-control"
                   value="<?= e($category['name']) ?>" placeholder="Enter Name" maxlength="150" required />
          </div>

          <div class="col-md-6">
            <label class="form-label" for="slug">Slug</label>
            <input type="text" name="slug" id="slug" class="form-control"
                   value="<?= e($category['slug']) ?>" placeholder="Enter Slug" maxlength="160" />
            <small class="text-muted">Changing the slug changes the page URL.</small>
          </div>

          <div class="col-md-6">
            <label class="form-label" for="status">Status</label>
            <select name="status" id="status" class="form-select">
              <option value="1" <?= (int) $category['status'] === 1 ? 'selected' : '' ?>>Active</option>
              <option value="0" <?= (int) $category['status'] === 0 ? 'selected' : '' ?>>Inactive</option>
            </select>
          </div>
        </div>

        <div class="pt-6">
          <button type="submit" class="btn btn-primary me-4">Update</button>
          <a href="/admin/service-category" class="btn btn-label-secondary">Cancel</a>
        </div>
      </form>
    </div>

  </div>
</div>