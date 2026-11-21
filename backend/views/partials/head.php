<title><?= e($title ?? 'Admin') ?> | Weneura</title>
<meta charset="utf-8" />
<meta name="csrf-token" content="<?= e(\App\Core\Csrf::token()) ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

<!-- Favicon -->
<link rel="icon" type="image/x-icon" href="<?= asset('img/favicon.png') ?>" />
<link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

<link rel="stylesheet" href="<?= asset('vendor/fonts/fontawesome.css') ?>" />
<link rel="stylesheet" href="<?= asset('vendor/fonts/tabler-icons.css') ?>" />
<link rel="stylesheet" href="<?= asset('vendor/fonts/flag-icons.css') ?>" />

<link rel="stylesheet" href="<?= asset('vendor/css/rtl/core.css') ?>" class="template-customizer-core-css" />
<link rel="stylesheet" href="<?= asset('vendor/css/rtl/theme-default.css') ?>" class="template-customizer-theme-css" />
<link rel="stylesheet" href="<?= asset('css/demo.css') ?>" />
<link rel="stylesheet" href="<?= asset('css/style.css') ?>" />

<link rel="stylesheet" href="<?= asset('vendor/libs/node-waves/node-waves.css') ?>" />
<link rel="stylesheet" href="<?= asset('vendor/libs/perfect-scrollbar/perfect-scrollbar.css') ?>" />
<link rel="stylesheet" href="<?= asset('vendor/libs/typeahead-js/typeahead.css') ?>" />
<link rel="stylesheet" href="<?= asset('vendor/libs/apex-charts/apex-charts.css') ?>" />
<link rel="stylesheet" href="<?= asset('vendor/libs/select2/select2.css') ?>" />
<link rel="stylesheet" href="<?= asset('vendor/libs/flatpickr/flatpickr.css') ?>" />
<link rel="stylesheet" href="<?= asset('vendor/libs/datatables-bs5/datatables.bootstrap5.css') ?>">
<link rel="stylesheet" href="<?= asset('vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') ?>">
<link rel="stylesheet" href="<?= asset('vendor/libs/sweetalert2/sweetalert2.css') ?>" />
<link rel="stylesheet" href="<?= asset('vendor/libs/dropzone/dropzone.css') ?>" />
<link rel="stylesheet" href="<?= asset('vendor/libs/pickr/pickr-themes.css') ?>" />
<link rel="stylesheet" href="<?= asset('vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css') ?>" />
<link rel="stylesheet" href="<?= asset('vendor/libs/%40form-validation/form-validation.css') ?>" />
<link rel="stylesheet" href="<?= asset('vendor/css/pages/page-auth.css') ?>">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css" />

<script src="<?= asset('vendor/js/helpers.js') ?>"></script>
<script src="<?= asset('js/config.js') ?>"></script>