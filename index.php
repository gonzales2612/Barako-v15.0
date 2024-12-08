<?php

require "vendor/autoload.php";
require "init.php";

global $conn;

try {
    // Create Router instance
    $router = new \Bramus\Router\Router();

    // Define routes
    $router->get('/', '\App\Controllers\HomeController@index');

    // User authentication routes
    $router->get('/register', '\App\Controllers\RegisterController@registrationForm');
    $router->post('/register', '\App\Controllers\RegisterController@register');
    $router->get('/login', '\App\Controllers\LoginController@loginForm');
    $router->post('/login', '\App\Controllers\LoginController@login');

    // Menu routes
    $router->get('/menu', '\App\Controllers\MenuController@showMenu');

    // Inventory routes
    $router->get('/admin/inventory', '\App\Controllers\InventoryController@showInventory');
    $router->post('/admin/inventory/update', '\App\Controllers\InventoryController@updateInventoryAjax'); // Update inventory item
    $router->post('/admin/inventory/delete', '\App\Controllers\InventoryController@deleteInventoryAjax'); // Delete inventory item
    $router->post('/admin/inventory/add', '\App\Controllers\InventoryController@addInventoryAjax'); // Add inventory item

    // Rating routes
    $router->get('/rate-menu', '\App\Controllers\RatingController@showRatingPage');
    $router->post('/rate-menu', '\App\Controllers\RatingController@rateMenuItem');

    // FAQ routes
    $router->get('/faqs', 'App\Controllers\FaqController@showFaqs');
    $router->get('/contact', 'App\Controllers\ContactController@showContactForm');
    $router->post('/contact/submit', 'App\Controllers\ContactController@submitContactForm');
    $router->get('/contact/thank-you', '\App\Controllers\ContactController@showThankYouPage');
    $router->get('/about', 'App\Controllers\AboutController@showAboutPage');

    // Admin routes
    $router->get('/admin', '\App\Controllers\AdminController@index');

    // Order routes
    $router->post('/orders/create', '\App\Controllers\OrderController@createOrder'); // Create a new order
    $router->get('/orders', '\App\Controllers\OrderController@showOrders'); // View all orders
    $router->get('/orders/update/{id}', '\App\Controllers\OrderController@showUpdateForm'); // Show the update order form
    $router->post('/orders/update/{id}', '\App\Controllers\OrderController@updateOrderStatus'); // Update order status
    $router->get('/orders/remove/{id}', '\App\Controllers\OrderController@removeOrder'); // Delete an order
    $router->get('/orders/receipt/{id}', '\App\Controllers\OrderController@generateReceipt'); // Generate receipt for an order

    // Run it!
    $router->run();
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
