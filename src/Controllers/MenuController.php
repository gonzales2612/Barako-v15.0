<?php

namespace App\Controllers;

use App\Models\Menu;
use App\Models\Category;
use App\Models\Rating; // Import the Rating model
use PDO;

class MenuController extends BaseController
{
    private $menuModel;
    private $categoryModel;
    private $ratingModel; // Add a property for the Rating model
    private $db;

    public function __construct($conn = null)
    {
        // Create database connection if not provided
        $this->db = $conn ?: new PDO('mysql:host=localhost;dbname=barako', 'root', '');
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->menuModel = new Menu($this->db);
        $this->categoryModel = new Category($this->db);
        $this->ratingModel = new Rating($this->db); // Initialize the Rating model
    }

    // Method to show the menu
    public function showMenu()
{
    session_start();
    $categories = $this->categoryModel->getAllCategories();
    $filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';

    switch ($filter) {
        case 'top-rated':
            $menuItems = $this->menuModel->getTopRatedMenu();
            break;
        case 'most-ordered':
            $menuItems = $this->menuModel->getMostOrderedMenu();
            break;
        default:
            $menuItems = $this->menuModel->getAllMenu();
            break;
    }

    foreach ($menuItems as &$menuItem) {
        $menuItem['average_rating'] = $this->ratingModel->getRatingForMenuItem($menuItem['Id']);
    }

    $data = [
        'title' => 'Menu',
        'menu' => $menuItems,
        'categories' => $categories,
        'firstname' => isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true
            ? $_SESSION['firstname']
            : null,
    ];

    echo $this->render('menu', $data);
}
    
    
}
