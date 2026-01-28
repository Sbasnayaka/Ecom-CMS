<?php
class CartController extends BaseController
{
    public function index()
    {
        // 1. Fetch Settings (for Logo, WhatsApp, Currency)
        // We need to instantiate Setting model
        // BaseController does not instantiate models automatically usually, relying on Child.
        // Let's rely on standard pattern.
        require_once 'models/Setting.php';
        $settingModel = new Setting();
        $settings = $settingModel->getAllPairs();

        // 2. Load View
        // Logic will be handled on Client Side via LocalStorage for WhatsApp Order Flow
        $this->view('customer/shop/cart', [
            'title' => 'My Cart',
            'settings' => $settings
        ]);
    }
}
?>