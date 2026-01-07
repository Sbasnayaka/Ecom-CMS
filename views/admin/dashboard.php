<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="/Ecom-CMS/assets/css/admin.css">
    <style>
        /* Specific tweaks for dashboard */
        .welcome-section {
            margin-bottom: 30px;
        }

        .welcome-title {
            font-size: 28px;
            font-weight: 800;
            margin: 0;
        }

        .welcome-sub {
            color: #888;
            margin: 5px 0 0 0;
        }
    </style>
</head>

<body>

    <div class="container">
        <!-- Header -->
        <div class="page-header">
            <div class="welcome-section">
                <h1 class="welcome-title">Welcome back!</h1>
                <p class="welcome-sub"><?= $_SESSION['username'] ?? 'Shop Owner' ?></p>
            </div>
            <!-- Placeholder for Avatar -->
            <div class="user-avatar"
                style="background: #ddd; display:flex; align-items:center; justify-content:center;">👤</div>
        </div>

        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card">
                <h2 class="stat-number"><?= $stats['categories'] ?? 0 ?></h2>
                <p class="stat-label">Categories</p>
            </div>
            <div class="stat-card">
                <h2 class="stat-number"><?= $stats['products'] ?? 0 ?></h2>
                <p class="stat-label">Products</p>
            </div>
            <div class="stat-card">
                <h2 class="stat-number"><?= $stats['size_guides'] ?? 0 ?></h2>
                <p class="stat-label">Size Guides</p>
            </div>
            <div class="stat-card">
                <h2 class="stat-number"><?= $stats['feedbacks'] ?? 0 ?></h2>
                <p class="stat-label">Feedbacks</p>
            </div>
        </div>

        <!-- Products Section -->
        <h3 class="section-title">Products in your Store</h3>

        <div class="product-list-container">
            <!-- Header Row (Optional background gray bar from screenshot) -->
            <div
                style="background:#eee; padding: 10px; border-radius: 6px; font-size:12px; color:#666; margin-bottom:10px;">
                Products
            </div>

            <?php if (empty($latest_products)): ?>
                <p style="text-align:center; padding:20px; color:#999;">No products yet.</p>
            <?php else: ?>
                <?php foreach ($latest_products as $product): ?>
                    <div class="product-item">
                        <div class="delete-icon">🗑️</div>
                        <img src="/Ecom-CMS/assets/uploads/<?= $product['main_image'] ?? 'default.png' ?>" class="product-thumb"
                            alt="Img">
                        <div class="product-info">
                            <h4 class="product-name"><?= htmlspecialchars($product['title']) ?></h4>
                            <p class="product-category"><?= htmlspecialchars($product['category_name'] ?? 'Uncategorized') ?>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Bottom Nav -->
    <?php $current_page = 'dashboard';
    include 'views/layouts/bottom_nav.php'; ?>

</body>

</html>