<?php
// Helper to check active state
$current_page = $current_page ?? 'dashboard';
?>
<div class="bottom-nav">
    <a href="/Ecom-CMS/admin/dashboard" class="nav-item <?= $current_page == 'dashboard' ? 'active' : '' ?>">
        <span class="nav-icon">📊</span>
        <span>Dashboard</span>
    </a>
    <a href="/Ecom-CMS/admin/products" class="nav-item <?= $current_page == 'products' ? 'active' : '' ?>">
        <span class="nav-icon">📦</span>
        <span>Products</span>
    </a>
    <a href="/Ecom-CMS/admin/feedbacks" class="nav-item <?= $current_page == 'feedbacks' ? 'active' : '' ?>">
        <span class="nav-icon">💬</span>
        <span>Feedback</span>
    </a>
    <a href="/Ecom-CMS/admin/myshop" class="nav-item <?= $current_page == 'myshop' ? 'active' : '' ?>">
        <span class="nav-icon">🏪</span>
        <span>My Shop</span>
    </a>
    <a href="/Ecom-CMS/admin/settings" class="nav-item <?= $current_page == 'settings' ? 'active' : '' ?>">
        <span class="nav-icon">⚙️</span>
        <span>Settings</span>
    </a>
</div>