<?php
// Hide Default Mobile Header
$hide_mobile_welcome = true;
require_once 'views/layouts/customer_header.php';
?>

<div class="home-layout">

    <!-- Desktop Sidebar -->
    <?php include 'views/customer/partials/sidebar.php'; ?>

    <main class="main-content" style="padding-top: 0;">

        <!-- Mobile-Only Layout Wrapper -->
        <div class="reviews-page-mobile d-lg-none">

            <!-- 1. Header Area with Back Button & Logo -->
            <div style="position: relative; margin-bottom: 20px; align-items: center; padding-top: 10px;">

                <!-- Back Button -->
                <a href="javascript:history.back()" style="
                    position: absolute; 
                    left: 20px; 
                    top: 10px; 
                    width: 35px; 
                    height: 35px; 
                    background: #000; 
                    border-radius: 50%; 
                    display: flex; 
                    align-items: center; 
                    justify-content: center; 
                    color: white; 
                    text-decoration: none;
                    z-index: 20; /* Ensure above everything */
                ">
                    <i class="fas fa-chevron-left" style="font-size: 14px;"></i>
                </a>

                <!-- Shop Logo Container (Centered & Overlapping) -->
                <div style="text-align: center; position: relative; z-index: 10;">
                    <?php
                    $logoUrl = $settings['shop_logo'] ?? '';
                    $logoUrl = str_replace('/Ecom-CMS/', BASE_URL, $logoUrl);
                    $physicalPath = $_SERVER['DOCUMENT_ROOT'] . $logoUrl;
                    $logo = (!empty($logoUrl) && file_exists($physicalPath))
                        ? $logoUrl
                        : 'https://via.placeholder.com/120';
                    ?>
                    <img src="<?= $logo ?>" alt="Shop Logo" style="
                        width: 120px; 
                        height: 120px; 
                        border-radius: 50%; 
                        object-fit: cover;
                        border: 3px solid #eee; /* Light border */
                        background: #fff;
                    ">
                </div>

                <!-- Gray Box with Info (Pulled up to be behind/under logo) -->
                <div style="
                    background: #f5f5f5; 
                    border-radius: 20px; 
                    padding: 30px 20px 20px 20px; 
                    margin: 0 10px;
                    margin-top: -60px; /* Overlap Factor */
                    padding-top: 70px; /* Compensate for overlap */
                    text-align: center;
                    position: relative;
                    z-index: 5;
                ">
                    <h1 style="font-size: 20px; font-weight: 800; margin: 0 0 10px 0; color: #000;">
                        <?= !empty($settings['shop_name']) ? htmlspecialchars($settings['shop_name']) : 'Dark Lavender Clothing' ?>
                    </h1>

                    <p style="font-size: 14px; color: #666; margin: 0 0 15px 0;">
                        <?= !empty($settings['shop_about']) ? htmlspecialchars($settings['shop_about']) : 'Tailored to your tastes...' ?>
                    </p>

                    <div style="font-size: 13px; color: #333; line-height: 1.6;">
                        <div style="margin-bottom: 5px;">No: 213/7, Ghanawimala Mw,<br>Hewagama, Kaduwela.</div>
                        <div style="margin-bottom: 5px;">076 260 00 00 / 077 255 55 55</div>
                        <div>info@darklavender.com</div>
                    </div>
                </div>
            </div>

            <!-- 2. "Give us a Review!" Button (Green) -->
            <div style="padding: 0 20px; margin-bottom: 25px;">
                <?php
                $shopPhone = isset($settings['shop_whatsapp']) ? str_replace(['+', ' '], '', $settings['shop_whatsapp']) : '';
                ?>
                <a href="https://wa.me/<?= $shopPhone ?>?text=I%20would%20like%20to%20leave%20a%20review!" target="_blank" style="
                    display: block;
                    width: 100%;
                    background: #50d176; /* Accurate Green */
                    color: white;
                    text-align: center;
                    padding: 15px;
                    border-radius: 12px;
                    font-weight: 600;
                    text-decoration: none;
                    box-shadow: 0 4px 10px rgba(80, 209, 118, 0.4);
                    font-size: 16px;
                ">
                    Give us a Review!
                </a>
            </div>

            <!-- 3. Social Media Icons (Centered Row) -->
            <div style="display: flex; justify-content: center; gap: 20px; margin-bottom: 40px;">
                <!-- Facebook -->
                <a href="#" style="width: 50px; height: 50px; display: block;">
                    <img src="<?= BASE_URL ?>assets/icons/facebook.png" alt="FB" style="width: 100%; height: 100%;">
                </a>
                <!-- Tiktok -->
                <a href="#" style="width: 50px; height: 50px; display: block;">
                    <img src="<?= BASE_URL ?>assets/icons/tiktok.png" alt="Tiktok" style="width: 100%; height: 100%;">
                </a>
                <!-- Instagram -->
                <a href="#" style="width: 50px; height: 50px; display: block;">
                    <img src="<?= BASE_URL ?>assets/icons/instagram.png" alt="IG" style="width: 100%; height: 100%;">
                </a>
                <!-- Youtube -->
                <a href="#" style="width: 50px; height: 50px; display: block;">
                    <img src="<?= BASE_URL ?>assets/icons/youtube.png" alt="YT" style="width: 100%; height: 100%;">
                </a>
                <!-- WhatsApp -->
                <a href="https://wa.me/<?= $shopPhone ?>" style="width: 50px; height: 50px; display: block;">
                    <img src="<?= BASE_URL ?>assets/icons/whatsapp.png" alt="WA" style="width: 100%; height: 100%;">
                </a>
            </div>

            <!-- 4. Customer Feedbacks -->

                                <div style="padding: 0 20px;">

                                   <h2 style="font-size: 20px; font-weight: 800; margin: 0 0 5px 0; text-align: center; color: #000;">Customer Feedbacks</h2>
                <p style="font-size: 13px; color: #888; margin: 0 0 25px 0; text-align: center;">We are always try to make to fully satisfied!</p>

                <!-- Feedback Images Scroll -->
                <div class="feedback-scroll" style="
                    display: flex; 
                    overflow-x: auto; 
                    gap: 15px; 
                    padding-bottom: 20px;
                    scroll-snap-type: x mandatory;
                ">

                                        <?php if (empty($feedbacks)): ?>
                        <div style="width:100%; text-align:center; padding: 20px; color:#aaa;">No feedback available yet.</div>
                    <?php else: ?>
                            <?php foreach ($feedbacks as $fb):
                                $fbPath = 'assets/uploads/' . $fb['image_path'];
                                $fbImg = (file_exists(ROOT_PATH . $fbPath)) ? BASE_URL . $fbPath : '';

                                if ($fbImg):
                                    ?>
                                        <div style="
                                flex: 0 0 85%; /* Slightly wider card */
                                scroll-snap-align: center;
                                border-radius: 15px;
                                overflow: hidden;
                                box-shadow: 0 5px 15px rgba(0,0,0,0.1);
                        border: 1px solid #f0f0f0;
                    ">
                                        <img src="<?= $fbImg ?>" alt="Feedback" style="width: 100%; display: block;">
                                        </div>
                                <?php endif; endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

        </div>

        <!-- Desktop View Fallback -->
        <div class="d-none d-lg-block">
            <div class="section-header">
                <h2 class="section-title">Customer Reviews</h2>
            </div>
            <div class="shop-grid" style="grid-template-columns: repeat(4, 1fr);">
                <?php if (!empty($feedbacks)):
                    foreach ($feedbacks as $fb):
                        $fbPath = 'assets/uploads/' . $fb['image_path'];
                        if (file_exists(ROOT_PATH . $fbPath)):
                            ?>
                            <div style="border-radius: 10px; overflow: hidden; border: 1px solid #eee;">
                                    <img src="<?= BASE_URL . $fbPath ?>" style="width: 100%;">
                                        </div>
                                <?php endif; endforeach; endif; ?>
            </div>
        </div>

    </main>
</div>

<?php require_once 'views/layouts/customer_footer.php'; ?>