<?php
// Product Card Partial
// Expects $prod array available

$imagePath = !empty($prod['main_image'])
    ? '/Ecom-CMS/assets/uploads/' . $prod['main_image']
    : 'https://via.placeholder.com/300';

$isOnSale = !empty($prod['sale_price']) && $prod['sale_price'] < $prod['price'];
?>

<div class="product-card">
    <div class="product-thumb-container">
        <a href="/Ecom-CMS/shop/product/<?= $prod['id'] ?>">
            <img src="<?= $imagePath ?>" class="product-thumb" alt="<?= htmlspecialchars($prod['title']) ?>">
        </a>

        <!-- Badges -->
        <?php if ($isOnSale): ?>
            <span class="sale-badge">SALE</span>
        <?php endif; ?>

        <!-- Add to Cart / Actions Overlay -->
        <div class="badge-overlay">
            <div class="cart-btn" onclick="addToCart(<?= $prod['id'] ?>)">
                <i class="fas fa-shopping-cart" style="font-size: 12px;"></i>
            </div>
        </div>
    </div>

    <div class="product-info">
        <h3 class="product-name">
            <a href="/Ecom-CMS/shop/product/<?= $prod['id'] ?>">
                <?= htmlspecialchars($prod['title']) ?>
            </a>
        </h3>
        <div class="product-category" style="font-size:10px; color:#888; margin-bottom: 5px;">
            <?= isset($prod['category_name']) ? htmlspecialchars($prod['category_name']) : 'General' ?>
        </div>

        <div class="product-price">
            <?php if ($isOnSale): ?>
                <span class="old-price">LKR
                    <?= number_format($prod['price'], 2) ?>
                </span>
                <span class="current-price" style="color:red;">LKR
                    <?= number_format($prod['sale_price'], 2) ?>
                </span>
            <?php else: ?>
                LKR
                <?= number_format($prod['price'], 2) ?>
            <?php endif; ?>
        </div>
    </div>
</div>