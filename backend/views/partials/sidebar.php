<?php
$menu = [
    'dashboard'  => ['Dashboard',   '/admin',            'ti-smart-home'],
    'career'     => ['Career',      '/admin/career',     'ti-briefcase'],
    'blog_category' => ['Blog Category', '/admin/blog-category', 'ti-category'],
    'blogs'      => ['Blogs',       '/admin/blog',      'ti-clipboard-text'],
    'service_category' => ['Service Category', '/admin/service-category', 'ti-category'],
    'service' => ['Service', '/admin/service', 'ti-briefcase'],
];
$activeMenu = $activeMenu ?? '';
?>
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="/admin" class="app-brand-link">
            <img class="logo_light" src="<?= asset('img/logo.png') ?>" alt="Logo"
                onerror="this.onerror=null; this.src='<?= asset('img/ads-logo.png') ?>';">
        </a>
    </div>
    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <?php foreach ($menu as $key => [$label, $url, $icon]): ?>
            <li class="menu-item <?= $activeMenu === $key ? 'active' : '' ?>">
                <a href="<?= e($url) ?>" class="menu-link">
                    <i class="menu-icon tf-icons ti <?= e($icon) ?>"></i>
                    <div data-i18n="<?= e($label) ?>"><?= e($label) ?></div>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</aside>