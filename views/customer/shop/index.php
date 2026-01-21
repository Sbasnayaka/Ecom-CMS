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


<script>
    document.addEventListener('DOMContentLoaded', function () {
        console.log('Price Filter: Script Loaded');
        const applyBtn = document.getElementById('applyPriceFilter');
        const minInput = document.getElementById('minPrice');
        const maxInput = document.getElementById('maxPrice');
        const shopGrid = document.getElementById('product-grid-container');

        console.log('Price Filter: Elements check', { 
            btn: !!applyBtn, 
            min: !!minInput, 
            max: !!maxInput, 
            grid: !!shopGrid 
        });

        if (applyBtn && minInput && maxInput && shopGrid) {
            applyBtn.addEventListener('click', function (e) {
                e.preventDefault();
                console.log('Price Filter: Apply Clicked');
                
                const min = minInput.value.trim();
                const max = maxInput.value.trim();
                const urlParams = new URLSearchParams(window.location.search);
                const search = urlParams.get('search') || '';

                const apiUrl = '<?= BASE_URL ?>shop/filter?min=' + encodeURIComponent(min) + '&max=' + encodeURIComponent(max) + '&search=' + encodeURIComponent(search);
                console.log('Price Filter: Requesting', apiUrl);
                
                shopGrid.style.opacity = '0.5';

                fetch(apiUrl)
                    .then(response => {
                        console.log('Price Filter: Response Status', response.status);
                        if (!response.ok) throw new Error('Network response was not ok');
                        return response.text();
                    })
                    .then(html => {
                        console.log('Price Filter: Updating Grid');
                        shopGrid.innerHTML = html;
                        shopGrid.style.opacity = '1';

                        const newUrl = new URL(window.location);
                        if (min) newUrl.searchParams.set('min', min); else newUrl.searchParams.delete('min');
                        if (max) newUrl.searchParams.set('max', max); else newUrl.searchParams.delete('max');
                        window.history.pushState({}, '', newUrl);
                    })
                    .catch(error => {
                        console.error('Price Filter: Error', error);
                        shopGrid.innerHTML = '<p style="grid-column:1/-1;color:red;text-align:center;">Error filtering products.</p>';
                        shopGrid.style.opacity = '1';
                    });
            });
        }
    });
</script>

<?php require_once 'views/layouts/customer_footer.php'; ?>