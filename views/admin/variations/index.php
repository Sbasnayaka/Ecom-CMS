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
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .back-circle {
            background: #000;
            color: white;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            justify-content: center;
            align-items: center;
            text-decoration: none;
            margin-right: 15px;
        }

        .create-btn {
            background-color: #d4ac0d;
            /* Mustard yellow from screenshot */
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            display: inline-block;
            margin-bottom: 25px;
        }

        .var-item {
            margin-bottom: 25px;
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
        }

        .var-name {
            font-weight: bold;
            font-size: 18px;
            color: #555;
            margin-bottom: 5px;
        }

        .var-values {
            color: #888;
            font-size: 14px;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="header-bar">
            <div style="display:flex; align-items:center;">
                <a href="/Ecom-CMS/admin/dashboard" class="back-circle">❮</a>
                <div>
                    <h2 style="margin:0;">Variation</h2>
                    <p style="margin:0; font-size:12px; color:#999;">Add Variations to your Product</p>
                </div>
            </div>
            <!-- Logo placeholder top right if needed -->
        </div>

        <a href="/Ecom-CMS/variation/add" class="create-btn">Create Variations +</a>

        <div class="variation-list">
            <?php foreach ($variations as $var): ?>
                <div class="var-item">
                    <div class="var-name">
                        <?= htmlspecialchars($var['name']) ?>
                        <!-- Delete (Optional, not in screenshot but needed for CRUD) -->
                        <a href="/Ecom-CMS/variation/delete/<?= $var['id'] ?>"
                            style="float:right; text-decoration:none; font-size:14px;"
                            onclick="return confirm('Delete?')">🗑️</a>
                    </div>
                    <div class="var-values">
                        <?php
                        $valNames = array_map(function ($v) {
                            return $v['value']; }, $var['values']);
                        echo implode(", ", $valNames);
                        ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</body>

</html>