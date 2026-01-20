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
        // Future: $catId = $_GET['cat'] ?? null;

        // 2. Fetch Data
        $products = $this->productModel->getAll($search);
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
}
?>