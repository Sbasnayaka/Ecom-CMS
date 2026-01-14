<?php require_once 'views/layouts/customer_header.php'; ?>

<!-- Single Product View Styles (All handled in customer.css now) -->
<div class="product-detail-page">

    <!-- Image Gallery Section -->
    <div class="product-gallery">
        <!-- Back Button Overlay -->
        <a href="<?= BASE_URL ?>" class="back-btn-overlay">
            <i class="fas fa-chevron-left"></i>
        </a>

        <div class="gallery-slider">
            <!-- Main Image First -->
            <?php
            $mainImg = 'assets/uploads/' . $product['main_image'];
            if (empty($product['main_image']) || !file_exists(ROOT_PATH . $mainImg)) {
                $mainImg = 'https://via.placeholder.com/600x600?text=' . urlencode($product['title']);
            } else {
                $mainImg = BASE_URL . $mainImg;
            }
            ?>
            <img src="<?= $mainImg ?>" class="gallery-img current" alt="Main Image">

            <!-- Gallery Images -->
            <?php if (!empty($gallery)): ?>
                <?php foreach ($gallery as $gImg):
                    $gPath = 'assets/uploads/' . $gImg;
                    $gUrl = (file_exists(ROOT_PATH . $gPath)) ? BASE_URL . $gPath : '';
                    if ($gUrl):
                        ?>
                        <img src="<?= $gUrl ?>" class="gallery-img" alt="Gallery Image">
                    <?php endif; endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Pagination Dots (Visual Only for now, or simple JS) -->
        <div class="gallery-dots">
            <span class="dot active"></span>
            <?php if (!empty($gallery)): ?>
                <?php foreach ($gallery as $g): ?>
                    <span class="dot"></span>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Info Section -->
    <div class="product-info-container">

        <!-- Breadcrumb / Category -->
        <div class="pd-breadcrumb">
            <?php
            $catName = htmlspecialchars($product['category_name'] ?? '');
            $parentName = htmlspecialchars($product['parent_category_name'] ?? '');
            echo (!empty($parentName) ? $parentName . ' | ' : '') . $catName;
            ?>
        </div>

        <!-- Title -->
        <h1 class="pd-title">
            <?= htmlspecialchars($product['title']) ?>
        </h1>

        <!-- Price & Guide Row -->
        <div class="pd-price-row">
            <div class="pd-prices">
                <?php
                $currency = $settings['currency_symbol'] ?? 'LKR';
                if (!empty($product['sale_price']) && $product['sale_price'] < $product['price']):
                    ?>
                    <span class="pd-old-price">
                        <?= $currency ?>
                        <?= number_format($product['price'], 0) ?>
                    </span>
                    <span class="pd-sale-price">
                        <?= $currency ?>
                        <?= number_format($product['sale_price'], 0) ?>
                    </span>
                <?php else: ?>
                    <span class="pd-sale-price">
                        <?= $currency ?>
                        <?= number_format($product['price'], 0) ?>
                    </span>
                <?php endif; ?>
            </div>

            <?php if (!empty($product['size_guide_id'])): ?>
                <button class="btn-size-guide" onclick="openSizeGuide()">Size Guide</button>
            <?php endif; ?>
        </div>

        <!-- Variations -->
        <?php if (!empty($variations)): ?>
            <?php foreach ($variations as $varName => $values): ?>
                <div class="var-section">
                    <span class="var-label">
                        <?= htmlspecialchars(ucfirst($varName)) ?>
                    </span>
                    <div class="var-pills">
                        <?php foreach ($values as $val): ?>
                            <div class="var-pill" onclick="selectVariation(this, '<?= $varName ?>', '<?= $val['id'] ?>')">
                                <?= htmlspecialchars($val['value']) ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <!-- Description -->
        <div class="pd-description">
            <?= nl2br(htmlspecialchars($product['description'])) ?>

            <div class="delivery-fee-line">
                <span style="color:#FF3B30;">♦</span> Delivery Fee: 350/-
            </div>
        </div>
    </div>

    <!-- Bottom Actions -->
    <div class="pd-bottom-actions">
        <!-- WhatsApp Order -->
        <a href="https://wa.me/<?= str_replace(['+', ' '], '', $settings['shop_whatsapp'] ?? '') ?>?text=I would like to order <?= urlencode($product['title']) ?>"
            class="btn-action btn-whatsapp">
            <i class="fab fa-whatsapp"></i> Order Now
        </a>

        <!-- Add to Cart -->
        <button class="btn-action btn-cart" onclick="addToCart(<?= $product['id'] ?>)">
            <i class="fas fa-cart-plus"></i> Add to cart
        </button>
    </div>

</div>

<!-- Size Guide Modal (Basic) -->
<?php if (!empty($product['size_guide_image'])):
    $sgImg = BASE_URL . 'assets/uploads/' . $product['size_guide_image'];
    ?>
    <div id="sgModal" class="modal-overlay" onclick="closeSizeGuide()">
        <div class="modal-content" onclick="event.stopPropagation()" style="position: relative; padding: 0;">
            <div onclick="closeSizeGuide()"
                style="position: absolute; top: 10px; right: 10px; cursor: pointer; z-index: 100; background: rgba(255,255,255,0.7); border-radius: 50%; padding: 5px; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">
                <img src="<?= BASE_URL ?>assets/icons/delete.png" alt="Close" style="width: 15px; height: 15px;">
            </div>
            <img src="<?= $sgImg ?>" style="width:100%; border-radius:10px; display: block;">
        </div>
    </div>
    <script>
        function openSizeGuide() { document.getElementById('sgModal').style.display = 'flex'; }
        function closeSizeGuide() { document.getElementById('sgModal').style.display = 'none'; }
    </script>
<?php endif; ?>

<script>
    function selectVariation(el, name, id) {
        // Toggle active class in this group
        let siblings = el.parentElement.querySelectorAll('.var-pill');
        siblings.forEach(s => s.classList.remove('active'));
        el.classList.add('active');
        // Store selection logic here (future)
    }

    // Simple Gallery Slider (for now just manual logic or relying on CSS scroll snap if implemented)
    // We will assume CSS scroll snap for gallery-slider in css
</script>

<?php require_once 'views/layouts/customer_footer.php'; ?>