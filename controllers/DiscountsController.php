<?php
/**
 * Discounts Controller
 * Handles the Discounts / Sale Page
 */
require_once 'models/Product.php';
require_once 'models/Setting.php';

class DiscountsController extends BaseController
{
    private $productModel;
    private $settingModel;

    public function __construct()
    {
        $this->productModel = new Product();
        $this->settingModel = new Setting();
    }

    public function index()
    {
        // 1. Fetch All Discounted Products
        $products = $this->productModel->getAllOnSale();

        // 2. Fetch Related Products (Random/Featured for bottom section)
        // Using 'Featured' as a proxy for 'Related' or general engagement
        $relatedProducts = $this->productModel->getFeatured(6);

        // 3. Fetch Settings (for Colors, Currency, etc.)
        $settings = $this->settingModel->getAllPairs();

        // 4. Load View
        $this->view('customer/discounts', [
            'title' => 'Discounts & Offers',
            'products' => $products,
            'relatedProducts' => $relatedProducts,
            'settings' => $settings
        ]);
    }
}
?>