<?php
// Helper to check active state
$current_page = $current_page ?? 'dashboard';
?>
<div class="bottom-nav">
    <a href="<?= BASE_URL ?>admin/dashboard" class="nav-item <?= $current_page == 'dashboard' ? 'active' : '' ?>">
        <img src="<?= BASE_URL ?>assets/icons/dashboard.png" class="nav-icon-img" alt="Dash">
        <span>Dashboard</span>
    </a>
    <a href="<?= BASE_URL ?>product/index" class="nav-item <?= $current_page == 'products' ? 'active' : '' ?>">
        <img src="<?= BASE_URL ?>assets/icons/products.png" class="nav-icon-img" alt="Prod">
        <span>Products</span>
    </a>
    <a href="<?= BASE_URL ?>feedback/index" class="nav-item <?= $current_page == 'feedback' ? 'active' : '' ?>">
        <img src="<?= BASE_URL ?>assets/icons/feedback.png" class="nav-icon-img" alt="Feed">
        <span>Feedback</span>
    </a>
    <a href="<?= BASE_URL ?>myshop/index" class="nav-item <?= $current_page == 'myshop' ? 'active' : '' ?>">
        <!-- Using Dashboard icon as placeholder as requested -->
        <img src="<?= BASE_URL ?>assets/icons/myshop.png" class="nav-icon-img" alt="Shop">
        <span>My Shop</span>
    </a>
    <a href="<?= BASE_URL ?>settings/index" class="nav-item <?= $current_page == 'settings' ? 'active' : '' ?>">
        <img src="<?= BASE_URL ?>assets/icons/settings.png" class="nav-icon-img" alt="Set">
        <span>Settings</span>
    </a>
</div>

<style>
    /* Icon Styles */
    .nav-icon-img {
        width: 24px;
        height: 24px;
        display: block;
        margin: 0 auto 4px auto;
        object-fit: contain;
        /* Basic filter to ensure they look okay if black/white */
        opacity: 0.6;
    }

    .nav-item {
        padding: 5px 4px;
        border-radius: 12px;
        transition: background-color 0.2s;
    }

    .nav-item.active,
    .nav-item:hover {
        background-color: #e1f0ff;
    }

    .nav-item.active .nav-icon-img {
        opacity: 1;
        /* Full visibility when active */
        /* Optional: If icons are black SVG/PNGs, you can use filters to colorize them to match the theme */
        /* filter: invert(36%) sepia(96%) saturate(2256%) hue-rotate(203deg) brightness(98%) contrast(106%); #007bff approx */
    }
</style>