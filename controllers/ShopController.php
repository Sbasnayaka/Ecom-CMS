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

        // Fetch Specific Category Details if Filtered
        $currentCategory = null;
        if (!empty($categoryIds) && count($categoryIds) === 1) {
            // Only strictly needed when ONE category is selected (Sub-Category View)
            $currentCategoryId = reset($categoryIds);
            $currentCategory = $this->categoryModel->getById($currentCategoryId);

            // If it has a parent, fetch parent too for breadcrumb
            if ($currentCategory && $currentCategory['parent_id']) {
                $parentCat = $this->categoryModel->getById($currentCategory['parent_id']);
                $currentCategory['parent_name'] = $parentCat['name'];
                $currentCategory['parent_id'] = $parentCat['id'];
            }
        }

        // 4. Load View
        $this->view('customer/shop/index', [
            'title' => $title,
            'products' => $products,
            'categories' => $categories,
            'settings' => $settings,
            'search_query' => $search,
            'currentCategory' => $currentCategory // Pass to view
        ]);
    }

    // Single Product View
    public function product($id)
    {
        $product = $this->productModel->getById($id);

        if (!$product) {
         // Handle 404
         http_response_code(404);
         require_once 'views/errors/404.php';
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

    // --- New Desktop Pages (Task 6.3 Reuse Strategy) ---

    // 1. Sales Page (UI: "Discounts!")
    public function sales()
    {
        // Fetch On Sale Items using existing Model logic
        $products = $this->productModel->getAllOnSale();
        $categories = $this->categoryModel->getAll();
        $settings = $this->settingModel->getAllPairs();

        $this->view('customer/shop/index', [
            'title' => 'Discounts!',
            'products' => $products,
            'categories' => $categories,
            'settings' => $settings,
            'isSpecialPage' => true // Flag to trigger custom header in view
        ]);
    }

    // 2. Featured Page (UI: "Featured Products")
    public function featured()
    {
        // Fetch Featured
        $products = $this->productModel->getFeatured(20); // Limit 20 for now
        $categories = $this->categoryModel->getAll();
        $settings = $this->settingModel->getAllPairs();

        $this->view('customer/shop/index', [
            'title' => 'Featured Products',
            'products' => $products,
            'categories' => $categories,
            'settings' => $settings,
            'isSpecialPage' => true
        ]);
    }

    // 3. New Arrivals (UI: "Recent Items")
    public function new_arrivals()
    {
        // Fetch Latest
        $products = $this->productModel->getLatest(20);
        $categories = $this->categoryModel->getAll();
        $settings = $this->settingModel->getAllPairs();

        $this->view('customer/shop/index', [
            'title' => 'Recent Items',
            'products' => $products,
            'categories' => $categories,
            'settings' => $settings,
            'isSpecialPage' => true
        ]);
    }

    // List All Categories Page
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
    // Single Category Detail Page
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
    // --- Desktop Home Tabs AJAX Handler ---
    public function tab_content()
    {
        $type = $_GET['type'] ?? 'new';
        $products = [];

        if ($type === 'new') {
            $products = $this->productModel->getLatest(12); // Grid of 12
        } elseif ($type === 'featured') {
            $products = $this->productModel->getFeatured(12);
        } elseif ($type === 'sale') {
            $products = $this->productModel->getOnSale(12); // Use getOnSale (limit 12) not All
        }

        if (empty($products)) {
            echo '<p style="text-align:center; padding:20px; color:#777;">No products found.</p>';
            return;
        }

        foreach ($products as $prod) {
            include 'views/customer/partials/product_card.php';
        }
    }
}
?>