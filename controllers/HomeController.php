<?php
/**
 * Home Controller
 * Handles the landing page logic.
 */
require_once 'models/Product.php';
require_once 'models/Category.php';
require_once 'models/Settings.php';

class HomeController extends BaseController
{
    private $productModel;
    private $categoryModel;
    private $settingsModel;

    public function __construct()
    {
        $this->productModel = new Product();
        $this->categoryModel = new Category();
        $this->settingsModel = new Settings();
    }

    public function index()
    {
        // 1. Fetch Shop Settings
        $settings = $this->settingsModel->getAll();

        // 2. Fetch Categories (Top level)
        // If we want all, we use getAll, but for home maybe limit or parent only?
        // User design shows "Top Categories" with images.
        $categories = $this->categoryModel->getAll();
        // Filter for valid images if needed, or just take first 8

        // 3. Fetch Products
        $featuredProducts = $this->productModel->getFeatured(4);
        $latestProducts = $this->productModel->getLatest(8); // Infinite scroll placeholder
        $saleProducts = $this->productModel->getOnSale(4);

        $this->view('customer/home', [
            'title' => $settings['shop_name'] ?? 'Home',
            'settings' => $settings,
            'categories' => $categories,
            'featuredProducts' => $featuredProducts,
            'latestProducts' => $latestProducts,
            'saleProducts' => $saleProducts
        ]);
    }
}
?>