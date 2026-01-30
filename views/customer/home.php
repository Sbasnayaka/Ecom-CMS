<?php require_once 'views/layouts/customer_header.php'; ?>

<!-- Mobile Welcome Block (Moved here or kept in header, keeping here ensures it is part of flow) -->
<!-- Actually handled in Header for global presence, but specific to Home? 
     Design shows it at top. Header has it. Good. -->

<div class="home-layout">

    <?php
    // Organize Categories into Tree
    $categoryTree = [];
    // First pass: Main categories
    foreach ($categories as $cat) {
        if (empty($cat['parent_id'])) {
            $categoryTree[$cat['id']] = $cat;
            $categoryTree[$cat['id']]['children'] = [];
        }
    }
    // Second pass: Subcategories
    foreach ($categories as $cat) {
        if (!empty($cat['parent_id']) && isset($categoryTree[$cat['parent_id']])) {
            $categoryTree[$cat['parent_id']]['children'][] = $cat;
        }
    }
    ?>

    <!-- DESKTOP SIDEBAR (Visible only on Desktop) -->
    <?php include 'views/customer/partials/sidebar.php'; ?>

    <!-- MAIN CONTENT AREA -->
    <main class="main-content">

        <!-- Top Categories (Mobile Horizontal Scroll / Desktop Grid?) -->
        <div class="section-header">
            <h2 class="section-title">Top Categories</h2>
            <a href="<?= BASE_URL ?>shop/categories" class="view-all">View All</a>
        </div>

        <div class="categories-scroll">
            <?php foreach ($categories as $cat): ?>
                <div class="cat-item">
                    <?php
                    $catPath = 'assets/uploads/' . $cat['image'];
                    $img = (!empty($cat['image']) && file_exists(ROOT_PATH . $catPath))
                        ? BASE_URL . $catPath
                        : 'https://via.placeholder.com/60?text=' . urlencode($cat['name']);
                    ?>
                    <img src="<?= $img ?>" class="cat-img" alt="<?= htmlspecialchars($cat['name']) ?>">
                    <div class="cat-name">
                        <?= htmlspecialchars($cat['name']) ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- DESKTOP TABS (Task 6 - Home Page Tabs) -->
        <div class="desktop-tabs display-desktop-only" style="margin-bottom: 20px; border-bottom: 2px solid #eee;">
            <button class="home-tab-btn active" onclick="switchHomeTab('featured')">Featured Products</button>
            <button class="home-tab-btn" onclick="switchHomeTab('latest')">Newly Released</button>
            <button class="home-tab-btn" onclick="switchHomeTab('sale')">Sale! Sale!</button>
        </div>

        <!-- Featured Products -->
        <div id="tab-featured" class="home-tab-content active">
            <?php if (!empty($featuredProducts)): ?>
                <div class="section-header display-mobile-only">
                    <h2 class="section-title">Featured Products <span class="tag special">SPECIAL</span></h2>
                </div>
                <div class="products-scroll">
                    <?php foreach ($featuredProducts as $prod): ?>
                        <?php include 'views/customer/partials/product_card.php'; ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Latest Products -->
        <div id="tab-latest" class="home-tab-content" style="display: none;">
            <!-- Hidden by default on Desktop, handled by JS -->
            <div class="section-header display-mobile-only">
                <h2 class="section-title">Latest Products <span class="tag new">NEW</span></h2>
            </div>
            <div class="products-scroll">
                <?php foreach ($latestProducts as $prod): ?>
                    <?php include 'views/customer/partials/product_card.php'; ?>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Sale Products -->
        <div id="tab-sale" class="home-tab-content" style="display: none;">
            <?php if (!empty($saleProducts)): ?>
                <div class="section-header display-mobile-only">
                    <h2 class="section-title">Sale Products <span class="tag sale">Sale..!</span></h2>
                </div>
                <div class="products-scroll">
                    <?php foreach ($saleProducts as $prod): ?>
                        <?php include 'views/customer/partials/product_card.php'; ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <script>
            function switchHomeTab(tabName) {
                // 1. Update Buttons
                document.querySelectorAll('.home-tab-btn').forEach(btn => btn.classList.remove('active'));
                event.target.classList.add('active');

                // 2. Hide All Contents (Desktop Logic)
                // Note: On Mobile, we want them ALL visible? 
                // Using .display-desktop-only for buttons means this logic only triggers via clicks on Desktop.
                // But we need to ensure Mobile layout isn't broken.
                // Mobile layout relies on stacked divs.
                // We should only toggle display on Desktop.

                const tabs = ['featured', 'latest', 'sale'];
                tabs.forEach(t => {
                    const el = document.getElementById('tab-' + t);
                    if (el) {
                        // On desktop, we hide/show. On mobile, we keep them mostly stacked?
                        // Actually, simpler to just toggle 'active-tab' class and use CSS to handle display?
                        // Or inline styles.
                        if (window.innerWidth >= 1024) {
                            el.style.display = (t === tabName) ? 'block' : 'none';
                        }
                    }
                });
            }

            // Init Tabs on Load (Desktop)
            document.addEventListener('DOMContentLoaded', () => {
                if (window.innerWidth >= 1024) {
                    const activeBtn = document.querySelector('.home-tab-btn.active');
                    if (activeBtn) activeBtn.click();
                } else {
                    // Mobile: Ensure all are visible
                    document.getElementById('tab-featured').style.display = 'block';
                    document.getElementById('tab-latest').style.display = 'block';
                    document.getElementById('tab-sale').style.display = 'block';
                }
            });
        </script>

        <style>
            /* Simple Tab Styles */
            .home-tab-btn {
                background: none;
                border: none;
                padding: 10px 20px;
                font-size: 16px;
                font-weight: 600;
                color: #777;
                cursor: pointer;
                border-bottom: 2px solid transparent;
            }

            .home-tab-btn.active {
                color: #000;
                border-bottom: 2px solid #000;
            }

            .home-tab-btn:hover {
                color: #333;
            }

            @media (max-width: 1023px) {

                /* Force display block on mobile to override inline JS styles if any mess up */
                .home-tab-content {
                    display: block !important;
                }
            }
        </style>

    </main>

</div>

<?php require_once 'views/layouts/customer_footer.php'; ?>