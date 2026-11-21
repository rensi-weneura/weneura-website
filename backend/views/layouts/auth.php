<?php $primaryColor = $primaryColor ?? '#7367f0'; ?>
<!doctype html>
<html lang="en" class="light-style layout-wide customizer-hide" dir="ltr" data-theme="theme-default"
  data-assets-path="/assets/" data-template="vertical-menu-template" data-style="light">

<head>
  <?php require BASE_PATH . '/views/partials/head.php'; ?>
  <style>
    :root { --primary-color: <?= e($primaryColor) ?>; }

    .btn-primary,
    .btn-primary:hover {
      background-color: var(--primary-color) !important;
      border-color: var(--primary-color) !important;
    }

    .authentication-wrapper.authentication-basic .authentication-inner:after {
      width: 180px; height: 180px; content: " ";
      position: absolute; z-index: -1; bottom: -30px; right: -56px;
      background-image: url("/assets/img/after.svg");
    }

    .authentication-wrapper.authentication-basic .authentication-inner:before {
      width: 238px; height: 233px; content: " ";
      position: absolute; top: -35px; left: -45px;
      background-image: url("/assets/img/before.svg");
    }
  </style>
</head>

<body>
  <?= $content ?>

  <script src="<?= asset('vendor/libs/jquery/jquery.js') ?>"></script>
  <?php require BASE_PATH . '/views/partials/footer_scripts.php'; ?>
</body>
</html>