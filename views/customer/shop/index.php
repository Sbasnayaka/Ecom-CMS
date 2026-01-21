<?php require_once 'views/layouts/customer_header.php'; ?>

<div class="home-layout">

    <!-- SIDEBAR (Reused) -->
    <?php include 'views/customer/partials/sidebar.php'; ?>

    <!-- MAIN CONTENT AREA -->
    <main class="main-content">

        <div class="section-header">
            <?php if (!empty($search_query)): ?>
                <h2 class="section-title">Searched Products</h2>
            <?php else: ?>
                <h2 class="section-title">All Products</h2>
            <?php endif; ?>
        </div>

        <div id="product-grid-container" class="shop-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 20px;">
            <?php if (empty($products)): ?>
                <div style="grid-column: 1 / -1; padding: 40px; text-align: center; color: #777;">
                    <h3>No products found.</h3>
                    <p>Try searching for something else or browse our categories.</p>
                    <a href="<?= BASE_URL ?>" class="btn-red"
                        style="display:inline-block; margin-top:20px; text-decoration:none;">Go Home</a>
                </div>
            <?php else: ?>
                <?php foreach ($products as $prod): ?>
                    <?php include 'views/customer/partials/product_card.php'; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <style>
            @media (max-width: 768px) {
                #product-grid-container {
                    grid-template-columns: repeat(2, 1fr) !important;
                    gap: 10px !important;
                }
            }
        </style>

    </main>

</div>




<?php require_once 'views/layouts/customer_footer.php'; ?>