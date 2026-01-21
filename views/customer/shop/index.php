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

        <?php if (empty($products)): ?>
            <div style="padding: 40px; text-align: center; color: #777;">
                <h3>No products found.</h3>
                <p>Try searching for something else or browse our categories.</p>
                <a href="<?= BASE_URL ?>" class="btn-red"
                    style="display:inline-block; margin-top:20px; text-decoration:none;">Go Home</a>
            </div>
        <?php else: ?>
            <!-- Products Grid -->
            <!-- Using existing .products-scroll class style or creating a grid wrapper -->
            <!-- The screenshot shows a grid. .products-scroll is usually horizontal. -->
            <!-- We should check customer.css for a grid class or add inline style for now to match strictness -->

            <style>
                .shop-grid {
                    display: grid;
                    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
                    gap: 20px;
                }

                @media (max-width: 768px) {
                    .shop-grid {
                        grid-template-columns: repeat(2, 1fr);
                        gap: 10px;
                    }
                }
            </style>

            <div class="shop-grid">
                <?php foreach ($products as $prod): ?>
                    <?php include 'views/customer/partials/product_card.php'; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </main>

</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const applyBtn = document.getElementById('applyPriceFilter');
        const minInput = document.getElementById('minPrice');
        const maxInput = document.getElementById('maxPrice');
        const shopGrid = document.querySelector('.shop-grid');

        if (applyBtn && minInput && maxInput && shopGrid) {
            applyBtn.addEventListener('click', function () {
                const min = minInput.value.trim();
                const max = maxInput.value.trim();

                // Get current search query from URL to persist it
                const urlParams = new URLSearchParams(window.location.search);
                const search = urlParams.get('search') || '';

                // Build API URL
                const apiUrl = '<?= BASE_URL ?>shop/filter?min=' + encodeURIComponent(min) + '&max=' + encodeURIComponent(max) + '&search=' + encodeURIComponent(search);

                // Fetch Data
                fetch(apiUrl)
                    .then(response => {
                        if (!response.ok) throw new Error('Network response was not ok');
                        return response.text();
                    })
                    .then(html => {
                        shopGrid.innerHTML = html;

                        // Update URL without reload
                        const newUrl = new URL(window.location);
                        if (min) newUrl.searchParams.set('min', min); else newUrl.searchParams.delete('min');
                        if (max) newUrl.searchParams.set('max', max); else newUrl.searchParams.delete('max');

                        window.history.pushState({}, '', newUrl);
                    })
                    .catch(error => {
                        console.error('Error filtering products:', error);
                    });
            });
        }
    });
</script>

<?php require_once 'views/layouts/customer_footer.php'; ?>