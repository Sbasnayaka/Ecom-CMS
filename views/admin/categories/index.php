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
        .category-list {
            background: #fff;
            border-radius: 12px;
            padding: 10px;
            margin-top: 20px;
        }

        .cat-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #eee;
        }

        .cat-item:last-child {
            border-bottom: none;
        }

        .cat-name {
            font-weight: 600;
            font-size: 16px;
            color: #333;
        }

        .sub-cat-name {
            font-weight: 400;
            font-size: 14px;
            color: #666;
            margin-left: 20px;
        }

        .cat-actions {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .edit-btn {
            background-color: #00c4b4;
            /* teal from screenshot */
            color: white;
            padding: 5px;
            border-radius: 4px;
            width: 24px;
            height: 24px;
            display: flex;
            text-decoration: none;
            justify-content: center;
            align-items: center;
            font-size: 12px;
        }

        .check-box {
            width: 20px;
            height: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .header-bar {
            display: flex;
            align-items: center;
            gap: 15px;
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
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="header-bar">
            <a href="<?= BASE_URL ?>admin/dashboard" class="back-circle">❮</a>
            <h2 style="margin:0;">Categories</h2>
        </div>

        <a href="<?= BASE_URL ?>category/add" class="btn btn-outline-primary btn-block"
            style="border:1px solid var(--primary-color); color:var(--primary-color); background:white;">
            Add New Category
        </a>

        <div class="category-list">
            <?php foreach ($categoryTree as $mainCat): ?>
                <!-- Main Category -->
                <div class="cat-item">
                    <span class="cat-name">
                        <?= htmlspecialchars($mainCat['name']) ?>
                    </span>
                    <div class="cat-actions">
                        <div class="check-box"></div>
                        <a href="/Ecom-CMS/category/edit/<?= $mainCat['id'] ?>" class="edit-btn">✏️</a>
                    </div>
                </div>

                <!-- Sub Categories -->
                <?php if (!empty($mainCat['children'])): ?>
                    <?php foreach ($mainCat['children'] as $subCat): ?>
                        <div class="cat-item">
                            <span class="sub-cat-name">•
                                <?= htmlspecialchars($subCat['name']) ?>
                            </span>
                            <div class="cat-actions">
                                <div class="check-box"></div>
                                <a href="/Ecom-CMS/category/edit/<?= $subCat['id'] ?>" class="edit-btn">✏️</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>

</body>

</html>