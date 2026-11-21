<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="row g-6">

      <?php
      $cards = [
          ['Total Career',     $careerCount,     '/admin/career',     'ti-briefcase',      'primary'],
          ['Total Blogs',      $blogCount,       '/admin/blogs',      'ti-clipboard-text', 'primary'],
      ];
      ?>

      <?php foreach ($cards as [$label, $count, $url, $icon, $color]): ?>
        <div class="col-lg-3 col-sm-6">
          <a href="<?= e($url) ?>">
            <div class="card card-border-shadow-<?= e($color) ?> h-100">
              <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                  <div class="avatar me-4">
                    <span class="avatar-initial rounded bg-label-<?= e($color) ?>">
                      <i class="menu-icon tf-icons ti <?= e($icon) ?>"></i>
                    </span>
                  </div>
                  <h4 class="mb-0"><?= (int) $count ?></h4>
                </div>
                <p class="mb-1"><?= e($label) ?></p>
              </div>
            </div>
          </a>
        </div>
      <?php endforeach; ?>

    </div>

    <?php if (!empty($error)): ?>
      <div class="alert alert-warning text-center mt-5"><?= e($error) ?></div>
    <?php endif; ?>
  </div>
</div>