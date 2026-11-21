<?php $primaryColor = $primaryColor ?? '#7367f0'; ?>
<!doctype html>
<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr"
    data-theme="theme-default" data-assets-path="/assets/" data-template="vertical-menu-template" data-style="light">

<head>
    <?php require BASE_PATH . '/views/partials/head.php'; ?>
    <style>
        :root {
            --primary-color: <?= e($primaryColor) ?>;
        }

        .btn-primary,
        .btn-primary:hover {
            background-color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
        }

        .bg-navbar-theme,
        .bg-navbar-theme .search-input-wrapper .search-input {
            background-color: var(--primary-color) !important;
        }

        .bg-menu-theme.menu-vertical .menu-item.active>.menu-link:not(.menu-toggle) {
            background: var(--primary-color) !important;
        }

        a.dropdown-item.mt-0.set-bgcolor.waves-effect {
            background-color: var(--primary-color) !important;
        }

        .page-item.active .page-link {
            border-color: var(--primary-color) !important;
            background-color: var(--primary-color) !important;
        }

        .text-muted {
            color: #ffffff !important;
        }

        .form-check-input:checked {
            background-color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color) !important;
        }

        .flatpickr-day.selected,
        .flatpickr-day.selected:hover {
            background: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
        }

        .custom-option.checked {
            border: 2px solid var(--primary-color) !important;
        }
    </style>
</head>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <?php require BASE_PATH . '/views/partials/sidebar.php'; ?>

            <div class="layout-page">
                <?php require BASE_PATH . '/views/partials/header.php'; ?>

                <?= $content ?>
            </div>
        </div>
    </div>

    <script src="<?= asset('vendor/libs/jquery/jquery.js') ?>"></script>
    <?php require BASE_PATH . '/views/partials/footer_scripts.php'; ?>
    <?= $pageScripts ?? '' ?>
</body>

</html>