<?php

namespace App\Controllers;

use App\Models\Menu;
use App\Models\Rating;
use PDO;

class RatingController extends BaseController
{
    private $menuModel;
    private $ratingModel;
    private $db;

    public function __construct($conn = null)
    {
        $this->db = $conn ?: new PDO('mysql:host=localhost;dbname=barako', 'root', '');
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->menuModel = new Menu($this->db);
        $this->ratingModel = new Rating($this->db);
    }

    public function showRatingPage()
    {
        session_start();
        $thankYouMessage = $_SESSION['thank_you_message'] ?? null;

        $menuItems = $this->menuModel->getAllMenu();

        $data = [
            'title' => 'Rate Menu Items',
            'menu' => $menuItems,
            'thankYouMessage' => $thankYouMessage,
            'firstname' => $_SESSION['firstname'] ?? null
        ];

        unset($_SESSION['thank_you_message']);
        echo $this->render('rateMenu', $data);
    }

    public function rateMenuItem()
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rating'], $_POST['menuItemId'])) {
            $rating = (int) $_POST['rating'];
            $menuItemId = (int) $_POST['menuItemId'];

            if ($rating >= 1 && $rating <= 10) {
                $this->ratingModel->addRating($menuItemId, $rating);
                $_SESSION['thank_you_message'] = "Thank you for your rating!";
            } else {
                $_SESSION['thank_you_message'] = "Invalid rating. Please submit a value between 1 and 10.";
            }

            header('Location: /rate-menu');
            exit;
        }

        header('Location: /rate-menu');
        exit;
    }

    public function getRatingForMenuItem($menuItemId)
    {
        // Query to get the average rating for a menu item
        $sql = "SELECT AVG(rating) AS average_rating FROM ratings WHERE menu_item_id = :menu_item_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':menu_item_id', $menuItemId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? round($result['average_rating'], 1) : 0;  // Return the average rating (rounded to 1 decimal place)
    }

}
