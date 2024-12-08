<?php

namespace App\Controllers;

use App\Models\ContactMessage;
use PDO;

class ContactController extends BaseController
{
    private $contactModel;
    private $db;

    public function __construct($conn = null)
    {
        $this->db = $conn ?: new PDO('mysql:host=localhost;dbname=barako', 'root', '');
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Enable exceptions for errors
        $this->contactModel = new ContactMessage($this->db);
    }

    // Show the contact form page
    public function showContactForm()
    {
        session_start();
        // Pass data to the view
        $template = 'Contact'; // Name of the view
        $data = ['title' => 'Contact Us', 'firstname' => isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true 
                ? $_SESSION['firstname'] 
                : null, ];

        echo $this->render($template, $data);
    }

    // Handle form submission
    public function submitContactForm()
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $message = $_POST['message'];

            // Save the message to the database
            $this->contactModel->saveMessage($name, $email, $message);

            // Redirect to a thank you page or show a success message
            $template = 'contact'; // Name of the view
            $data = ['title' => 'Contact Us'];
    
            echo $this->render($template, $data);
            exit();
        }
    }
}
