<aside class="sidebar display-desktop-only">
    <div class="filter-group">
        <span class="filter-title">Filter by Price,</span>
        <div style="display: flex; gap: 10px;">
            <input type="text" placeholder="Min"
                style="width: 60px; padding: 5px; border: 1px solid #ddd; border-radius: 4px;">
            <input type="text" placeholder="Max"
                style="width: 60px; padding: 5px; border: 1px solid #ddd; border-radius: 4px;">
        </div>
    </div>

    <div class="filter-group">
        <span class="filter-title">Filter by Category</span>
        <?php
        // Organize Categories into Tree if not already organized?
        // Actually, we expect $categories to be passed. The Tree logic logic can be done here or controller.
        // Let's re-use the tree logic if it's cheap, or rely on controller passing $categoryTree. 
        // For partial simplicity, let's keep logic here or assume $categories is available.
        // Copying the standard tree logic from home.php for robustness.
        $categoryTree = [];
        if (!empty($categories)) {
            foreach ($categories as $cat) {
                if (empty($cat['parent_id'])) {
                    $categoryTree[$cat['id']] = $cat;
                    $categoryTree[$cat['id']]['children'] = [];
                }
            }
            foreach ($categories as $cat) {
                if (!empty($cat['parent_id']) && isset($categoryTree[$cat['parent_id']])) {
                    $categoryTree[$cat['parent_id']]['children'][] = $cat;
                }
            }
        }
        ?>
        <?php foreach ($categoryTree as $mainCat): ?>
            <label class="checkbox-label">
                <input type="checkbox">
                <strong>
                    <?= htmlspecialchars($mainCat['name']) ?>
                </strong>
            </label>
            <?php if (!empty($mainCat['children'])): ?>
                <div style="margin-left: 10px; display: flex; flex-direction: column;">
                    <?php foreach ($mainCat['children'] as $childCat): ?>
                        <label class="checkbox-label" style="font-size: 12px; color: #777;">
                            <input type="checkbox">
                            --
                            <?= htmlspecialchars($childCat['name']) ?>
                        </label>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <!-- Shop Info Box -->
    <div class="shop-info-box">
        <div class="shop-info-title">
            <?= !empty($settings['shop_name']) ? htmlspecialchars($settings['shop_name']) : 'Dark Lavender Clothing' ?>
        </div>
        <div class="shop-desc">
            <?php
            $about = $settings['shop_about'] ?? '';
            echo nl2br(htmlspecialchars($about));
            ?>
        </div>

        <button class="btn-review">Give us a Review!</button>

        <div class="social-icons">
            <img src="<?= BASE_URL ?>assets/icons/facebook.png" alt="FB" class="social-icon-img">
            <img src="<?= BASE_URL ?>assets/icons/tiktok.png" alt="TikTok" class="social-icon-img">
            <img src="<?= BASE_URL ?>assets/icons/instagram.png" alt="IG" class="social-icon-img">
            <img src="<?= BASE_URL ?>assets/icons/youtube.png" alt="YT" class="social-icon-img">
        </div>
    </div>
</aside>