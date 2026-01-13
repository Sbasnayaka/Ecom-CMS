<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $title ?>
    </title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/admin.css">
    <style>
        .page-header {
            margin-bottom: 20px;
        }

        /* QR & Logo Section */
        .assets-row {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
        }

        .asset-card {
            flex: 1;
            text-align: center;
        }

        .asset-label {
            font-size: 11px;
            color: #666;
            margin-bottom: 5px;
            text-align: left;
            display: block;
        }

        .asset-box {
            background: #fdfdfd;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            margin-bottom: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 120px;
        }

        .asset-img {
            max-width: 100px;
            max-height: 100px;
        }

        .btn-download {
            background-color: #007aff;
            color: white;
            border: none;
            padding: 8px 0;
            width: 100%;
            border-radius: 6px;
            font-size: 13px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 5px;
        }

        /* Shop Link */
        .shop-link-section {
            margin-bottom: 30px;
        }

        .readonly-input-group {
            position: relative;
        }

        .readonly-input {
            width: 100%;
            padding: 12px 40px 12px 15px;
            background: #f0f0f0;
            border: none;
            border-radius: 8px;
            color: #888;
            font-size: 14px;
            box-sizing: border-box;
        }

        .copy-icon {
            position: absolute;
            right: 10px;
            top: 10px;
            cursor: pointer;
            opacity: 0.6;
            font-size: 18px;
        }

        /* Gray Form Area */
        .gray-form-card {
            background-color: #e0e0e0;
            /* Gray background from screenshot */
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 80px;
        }

        .section-title {
            font-weight: bold;
            color: #555;
            margin-bottom: 10px;
            display: block;
            font-size: 14px;
        }

        .input-white {
            width: 100%;
            padding: 12px 15px;
            background: white;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            box-sizing: border-box;
            margin-bottom: 15px;
        }

        .social-row {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
        }

        .social-icon {
            width: 32px;
            height: 32px;
            object-fit: contain;
        }

        .publish-btn {
            background-color: #007aff;
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="page-header">
            <h2 style="margin:0;">My Shop 🏁</h2>
            <p style="margin:0; font-size:11px; color:#888;">Wow! Now your Shop is open to World.</p>
        </div>

        <!-- QR & Logo -->
        <div class="assets-row">
            <!-- QR -->
            <div class="asset-card">
                <span class="asset-label">My shop QR Code</span>
                <div class="asset-box">
                    <?php if ($settings['shop_qr']): ?>
                        <img src="<?= $settings['shop_qr'] ?>" class="asset-img" alt="QR">
                    <?php else: ?>
                        <span style="color:#ccc; font-size:40px;">🔳</span>
                    <?php endif; ?>
                </div>
                <a href="<?= $settings['shop_qr'] ?? '#' ?>" download class="btn-download">
                    💾 Download QR
                </a>
            </div>

            <!-- Logo -->
            <div class="asset-card">
                <span class="asset-label">My shop Logo</span>
                <div class="asset-box">
                    <?php if ($settings['shop_logo']): ?>
                        <img src="<?= $settings['shop_logo'] ?>" class="asset-img" alt="Logo">
                    <?php else: ?>
                        <span style="color:#ccc; font-size:40px;">🌸</span>
                    <?php endif; ?>
                </div>
                <a href="<?= $settings['shop_logo'] ?? '#' ?>" download class="btn-download">
                    💾 Download Logo
                </a>
            </div>
        </div>

        <!-- Shop Link -->
        <div class="shop-link-section">
            <span class="asset-label" style="font-size:13px; font-weight:bold; margin-bottom:8px;">My Shop Link</span>
            <div class="readonly-input-group">
                <input type="text" class="readonly-input"
                    value="<?= htmlspecialchars($settings['shop_url'] ?? 'yourshopname.freezone.lk') ?>" readonly
                    id="shopLinInput">
                <span class="copy-icon" onclick="copyLink()">📋</span>
            </div>
        </div>

        <!-- Edit Form -->
        <form action="<?= BASE_URL ?>myshop/update" method="POST">
            <div class="gray-form-card">

                <label class="section-title">My shop Review Link:</label>
                <input type="text" name="review_link" class="input-white" placeholder="Enter Review Link here"
                    value="<?= htmlspecialchars($settings['review_link']) ?>">

                <label class="section-title" style="margin-top:20px;">My Social Links</label>

                <!-- Facebook -->
                <div class="social-row">
                    <img src="<?= BASE_URL ?>assets/icons/facebook.png" class="social-icon">
                    <input type="text" name="social_fb" class="input-white" style="margin-bottom:0;"
                        placeholder="Enter Link here" value="<?= htmlspecialchars($settings['social_fb']) ?>">
                </div>

                <!-- Tiktok -->
                <div class="social-row">
                    <img src="<?= BASE_URL ?>assets/icons/tiktok.png" class="social-icon">
                    <input type="text" name="social_tiktok" class="input-white" style="margin-bottom:0;"
                        placeholder="Enter Link here" value="<?= htmlspecialchars($settings['social_tiktok']) ?>">
                </div>

                <!-- Instagram -->
                <div class="social-row">
                    <img src="/Ecom-CMS/assets/icons/Instagram.png" class="social-icon">
                    <input type="text" name="social_insta" class="input-white" style="margin-bottom:0;"
                        placeholder="Enter Link here" value="<?= htmlspecialchars($settings['social_insta']) ?>">
                </div>

                <!-- Youtube -->
                <div class="social-row">
                    <img src="/Ecom-CMS/assets/icons/youtube.png" class="social-icon">
                    <input type="text" name="social_youtube" class="input-white" style="margin-bottom:0;"
                        placeholder="Enter Link here" value="<?= htmlspecialchars($settings['social_youtube']) ?>">
                </div>

                <!-- Whatsapp -->
                <div class="social-row">
                    <img src="/Ecom-CMS/assets/icons/whatsapp.png" class="social-icon">
                    <input type="text" name="social_whatsapp" class="input-white" style="margin-bottom:0;"
                        placeholder="Enter Link here" value="<?= htmlspecialchars($settings['social_whatsapp']) ?>">
                </div>

                <button type="submit" class="publish-btn" style="margin-top:20px;">
                    💾 PUBLISH
                </button>
            </div>
        </form>
    </div>

    <!-- Bottom Navigation -->
    <?php $current_page = 'myshop';
    include 'views/layouts/bottom_nav.php'; ?>

    <script>
        function copyLink() {
            const copyText = document.getElementById("shopLinInput");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            navigator.clipboard.writeText(copyText.value);
            alert("Copied the text: " + copyText.value);
        }
    </script>

</body>

</html>