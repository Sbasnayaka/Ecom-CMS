<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $title ?>
    </title>
    <link rel="stylesheet" href="/Ecom-CMS/assets/css/admin.css">
</head>

<body>
    <div class="container">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
            <h2>All Products</h2>
            <a href="/Ecom-CMS/product/add" class="btn btn-primary"
                style="background:#007aff; color:white; padding:10px 20px; border-radius:8px; text-decoration:none;">Add
                New</a>
        </div>

        <!-- Search Bar -->
        <div style="position:relative; margin-bottom:20px;">
            <input type="text" placeholder="Type here to search..."
                style="width:100%; padding:15px; border-radius:30px; border:none; background:#f5f5f5; padding-right:50px; box-sizing:border-box;">
            <div
                style="position:absolute; right:5px; top:5px; width:40px; height:40px; background:#fdd835; border-radius:50%; display:flex; justify-content:center; align-items:center;">
                🔍
            </div>
        </div>

        <!-- Placeholder List -->
        <p style="text-align:center; color:#999;">Product list loading... (Backend implementation pending)</p>
    </div>
    <?php $current_page = 'products';
    include 'views/layouts/bottom_nav.php'; ?>
</body>

</html>