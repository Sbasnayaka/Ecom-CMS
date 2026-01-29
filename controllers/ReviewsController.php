<?php
/**
 * Reviews Controller
 * Handles the Customer Feedback Page
 */
require_once 'models/Feedback.php';
require_once 'models/Setting.php';

class ReviewsController extends BaseController
{
    private $feedbackModel;
    private $settingModel;

    public function __construct()
    {
        $this->feedbackModel = new Feedback();
        $this->settingModel = new Setting();
    }

    public function index()
    {
        // 1. Fetch Feedbacks (Images)
        $feedbacks = $this->feedbackModel->getAll();

        // 2. Fetch Settings (Shop Name, Logo, etc)
        $settings = $this->settingModel->getAllPairs();

        // 3. Load View
        $this->view('customer/reviews', [
            'title' => 'Customer Reviews',
            'feedbacks' => $feedbacks,
            'settings' => $settings
        ]);
    }
}
?>