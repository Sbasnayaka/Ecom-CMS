<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $title ?>
    </title>
    <link rel="stylesheet" href="/Ecom-CMS/assets/css/admin.css">
    <style>
        .header-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .logo-top {
            font-size: 20px;
            font-weight: bold;
        }

        .publish-txt {
            color: #007aff;
            font-weight: bold;
            cursor: pointer;
            border: none;
            background: none;
            font-size: 16px;
        }

        .label {
            font-weight: bold;
            color: #555;
            font-size: 13px;
            margin-bottom: 5px;
            display: block;
        }

        .input-box {
            width: 100%;
            padding: 12px 15px;
            background: #f9f9f9;
            border: 1px solid #eee;
            border-radius: 8px;
            font-size: 14px;
            box-sizing: border-box;
            margin-bottom: 20px;
        }

        .img-row {
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
        }

        .img-card {
            flex: 1;
            text-align: center;
        }

        .img-upload-box {
            background: white;
            border: 1px solid #eee;
            border-radius: 12px;
            height: 120px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .preview-thumb {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: contain;
            padding: 10px;
            box-sizing: border-box;
        }

        /* Red Border Section for User Management */
        .user-mgmt-box {
            border: 1px solid #ff3b30;
            border-radius: 15px;
            padding: 20px;
            margin-top: 30px;
            background: #fff5f5;
        }

        .user-mgmt-title {
            color: #ff3b30;
            font-weight: bold;
            margin-bottom: 15px;
            font-size: 12px;
        }

        .input-pink {
            background: #ffeaea;
            border: none;
        }

        .update-link {
            color: #ff3b30;
            text-decoration: underline;
            font-weight: bold;
            float: right;
            font-size: 14px;
            cursor: pointer;
            border: none;
            background: none;
        }
    </style>
</head>

<body>

    <form action="/Ecom-CMS/settings/update" method="POST" enctype="multipart/form-data">
        <div class="container" style="padding-bottom:100px;">

            <div class="header-bar">
                <div class="logo-top"><span style="color:#2ea043;">🍃</span> Asseminate</div>
                <button type="submit" class="publish-txt">PUBLISH</button>
            </div>

            <h2 style="margin:0 0 20px 0;">Shop Settings</h2>

            <label class="label">Shop Name</label>
            <input type="text" name="shop_name" class="input-box" placeholder="Enter Shop Name"
                value="<?= htmlspecialchars($settings['shop_name'] ?? '') ?>">

            <label class="label">Shop Link</label>
            <input type="text" name="shop_url" class="input-box" placeholder="Enter Shop URL"
                value="<?= htmlspecialchars($settings['shop_url'] ?? '') ?>">

            <div class="img-row">
                <!-- Logo -->
                <div class="img-card">
                    <span class="label">Shop Logo</span>
                    <div class="img-upload-box" onclick="document.getElementById('logoInput').click()">
                        <?php if (!empty($settings['shop_logo'])): ?>
                            <img src="<?= $settings['shop_logo'] ?>" class="preview-thumb">
                        <?php endif; ?>
                        <div style="font-size:20px;">📷</div>
                        <p style="font-size:10px; color:#999;">Tap here to<br>upload a photo</p>
                        <input type="file" name="shop_logo" id="logoInput" style="display:none;">
                    </div>
                </div>
                <!-- QR -->
                <div class="img-card">
                    <span class="label">Shop QR</span>
                    <div class="img-upload-box" onclick="document.getElementById('qrInput').click()">
                        <?php if (!empty($settings['shop_qr'])): ?>
                            <img src="<?= $settings['shop_qr'] ?>" class="preview-thumb">
                        <?php endif; ?>
                        <div style="font-size:20px;">📷</div>
                        <p style="font-size:10px; color:#999;">Tap here to<br>upload a photo</p>
                        <input type="file" name="shop_qr" id="qrInput" style="display:none;">
                    </div>
                </div>
            </div>

            <label class="label">Shop About</label>
            <textarea name="shop_about" class="input-box" rows="4"
                placeholder="Insert Shop Slogan, Address, Email..."><?= htmlspecialchars($settings['shop_about'] ?? '') ?></textarea>

            <label class="label">Shop Owner's Whatsapp Number</label>
            <p style="font-size:10px; color:#999; margin-bottom:5px;">Order request notifications will be sent to this
                number.</p>
            <input type="text" name="shop_whatsapp" class="input-box" placeholder="+94XXXXXX"
                value="<?= htmlspecialchars($settings['shop_whatsapp'] ?? '') ?>">

            <label class="label">Currency Symbol</label>
            <input type="text" name="currency_symbol" class="input-box" placeholder="LKR"
                value="<?= htmlspecialchars($settings['currency_symbol'] ?? '') ?>">

            <!-- User Management -->
            <?php if ($owner): ?>
                <div class="user-mgmt-box">
                    <input type="hidden" name="owner_id" value="<?= $owner['id'] ?>">

                    <span class="user-mgmt-title">Shop Owner Username</span>
                    <input type="text" name="owner_username" class="input-box input-pink"
                        value="<?= htmlspecialchars($owner['username']) ?>">

                    <span class="user-mgmt-title">Shop Owner Password</span>
                    <input type="text" name="owner_password" class="input-box input-pink" placeholder="***********">

                    <button type="submit" class="update-link">Update</button>
                    <div style="clear:both;"></div>
                </div>
            <?php endif; ?>

        </div>
    </form>

    <?php $current_page = 'settings';
    include 'views/layouts/bottom_nav.php'; ?>

</body>

</html>