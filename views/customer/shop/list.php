<?php require_once 'views/layouts/customer_header.php'; ?>

<div class="home-layout">

    <!-- DESKTOP SIDEBAR -->
    <?php include 'views/customer/partials/sidebar.php'; ?>

    <!-- MAIN CONTENT AREA -->
    <main class="main-content">

        <!-- Page Header -->
        <div class="section-header">
            <h2 class="section-title">
                <?= htmlspecialchars($title) ?>
            </h2>
        </div>

        <!-- Product Grid (Replicating views/customer/shop/index.php Grid Structure) -->
        <div id="product-grid-container" class="shop-grid"
            style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 20px;">

            <?php if (empty($products)): ?>
                <div style="grid-column: 1 / -1; padding: 40px; text-align: center; color: #777;">
                    <h3>No products found.</h3>
                    <p>Check back later for updates!</p>
                    <a href="<?= BASE_URL ?>" class="btn-red"
                        style="display:inline-block; margin-top:20px; text-decoration:none;">Go Home</a>
                </div>
            <?php else: ?>
                <?php foreach ($products as $prod): ?>
                    <?php include 'views/customer/partials/product_card.php'; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

    </main>

</div>

<?php require_once 'views/layouts/customer_footer.php'; ?>