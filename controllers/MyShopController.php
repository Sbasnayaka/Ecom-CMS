<?php
/**
 * My Shop Controller
 */
require_once 'models/Setting.php';

class MyShopController extends BaseController
{

    private $settingModel;

    public function __construct()
    {
        $this->settingModel = new Setting();
    }

    public function index()
    {
        // Fetch all relevant settings
        $keys = [
            'shop_qr',
            'shop_logo',
            'shop_url',
            'review_link',
            'social_fb',
            'social_tiktok',
            'social_insta',
            'social_youtube',
            'social_whatsapp'
        ];

        $settings = $this->settingModel->getMultiple($keys);

        $this->view('admin/myshop/index', [
            'title' => 'My Shop',
            'settings' => $settings
        ]);
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Shop Owner can only update Socials and Review Link
            $allowedKeys = [
                'review_link',
                'social_fb',
                'social_tiktok',
                'social_insta',
                'social_youtube',
                'social_whatsapp'
            ];

            foreach ($allowedKeys as $key) {
                if (isset($_POST[$key])) {
                    $this->settingModel->set($key, $_POST[$key]);
                }
            }

            // Redirect back with success
            $this->redirect('myShop/index');
        }
    }
}
?>