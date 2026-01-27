<?php
/**
 * Shop Controller
 * Handles Public Product Browsing
 */
require_once 'models/Product.php';
require_once 'models/Category.php';
require_once 'models/Variation.php';
require_once 'models/Setting.php';

class ShopController extends BaseController
{
    private $productModel;
    private $categoryModel;
    private $settingModel;

    public function __construct()
    {
        $this->productModel = new Product();
        $this->categoryModel = new Category();
        $this->settingModel = new Setting();
    }

    // List all products (Shop Index / Search Results)
    public function index()
    {
        // 1. Get Filters
        $search = $_GET['search'] ?? null;
        $min = $_GET['min'] ?? null;
        $max = $_GET['max'] ?? null;
        $catParam = $_GET['cat'] ?? null;

        $categoryIds = [];
        if (!empty($catParam)) {
            $categoryIds = explode(',', $catParam);
            $categoryIds = array_filter($categoryIds, 'is_numeric');
        }

        // 2. Fetch Data
        // Use getFiltered to handle all filter cases (Search + Price + Category)
        $products = $this->productModel->getFiltered($min, $max, $search, $categoryIds);
        $categories = $this->categoryModel->getAll();
        $settings = $this->settingModel->getAllPairs();

        // 3. Prepare View Data
        $title = 'Shop';
        if ($search) {
            $title = 'Search Results for "' . htmlspecialchars($search) . '"';
        }

        // 4. Load View
        $this->view('customer/shop/index', [
            'title' => $title,
            'products' => $products,
            'categories' => $categories,
            'settings' => $settings,
            'search_query' => $search
        ]);
    }

    // Single Product View
    public function product($id)
    {
        $product = $this->productModel->getById($id);

        if (!$product) {
            // Handle 404
            echo "Product not found.";
            return;
        }

        // Fetch additional details
        $gallery = $this->productModel->getGalleryImages($id);
        $variations = $this->productModel->getVariations($id);
        $relatedProducts = $this->productModel->getRelated($product['category_id'], $id, 3);

        // Fetch Categories for Sidebar
        $categories = $this->categoryModel->getAll();

        // Pass global settings for currency etc
        $settings = $this->settingModel->getAllPairs();

        $this->view('customer/shop/product', [
            'title' => $product['title'],
            'product' => $product,
            'gallery' => $gallery,
            'variations' => $variations,
            'relatedProducts' => $relatedProducts,
            'categories' => $categories, // For sidebar
            'settings' => $settings
        ]);
    }

    // AJAX Filter Handler (Price Range)
    public function filter()
    {
        $min = $_GET['min'] ?? null;
        $max = $_GET['max'] ?? null;
        $search = $_GET['search'] ?? null;

        // Handle Category Filter (Comma separated IDs: 1,2,3)
        $catParam = $_GET['cat'] ?? null;
        $categoryIds = [];
        if (!empty($catParam)) {
            $categoryIds = explode(',', $catParam);
            // Sanitize integers
            $categoryIds = array_filter($categoryIds, 'is_numeric');
        }

        // Fetch Settings for Currency Symbol
        $settings = $this->settingModel->getAllPairs();

        // Get Filtered Products
        $products = $this->productModel->getFiltered($min, $max, $search, $categoryIds);

        if (empty($products)) {
            echo '<div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #777;">
                    <h3>No products found.</h3>
                    <p>Try adjusting your price range.</p>
                  </div>';
            return;
        }

        // Render Partial HTML
        foreach ($products as $prod) {
            include 'views/customer/partials/product_card.php';
        }
    }
    // List All Categories Page (Task 2.1)
    public function categories()
    {
        $categories = $this->categoryModel->getAll();
        $settings = $this->settingModel->getAllPairs();

        $this->view('customer/shop/categories', [
            'title' => 'All Categories',
            'categories' => $categories,
            'settings' => $settings
        ]);
    }
    // Single Category Detail Page (Task 2.2)
    public function category($id)
    {
        // 1. Get Main Category
        $category = $this->categoryModel->getById($id);

        if (!$category) {
            // Fallback or 404
            $this->redirect('shop/categories');
            return;
        }

        // 2. Get Sub-Categories (Filter from all)
        $allCats = $this->categoryModel->getAll();
        $subCategories = array_filter($allCats, function ($c) use ($id) {
            return $c['parent_id'] == $id;
        });

        // 3. Get Products (Include Main + Sub Categories)
        $catIds = array_column($subCategories, 'id');
        $catIds[] = $id;

        // Pass IDs to filter
        $products = $this->productModel->getFiltered(null, null, null, $catIds);

        $settings = $this->settingModel->getAllPairs();

        $this->view('customer/shop/category_detail', [
            'category' => $category,
            'subCategories' => $subCategories,
            'products' => $products,
            'settings' => $settings
        ]);
    }
}
?>