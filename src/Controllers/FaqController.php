<?php

namespace App\Controllers;

use App\Models\Faq;

class FaqController extends BaseController
{
    private $faqModel;

    public function __construct()
    {
        // Access the global database connection
        global $conn; // Access the database connection from init.php

        // Instantiate the Faq model with the global $conn
        $this->faqModel = new Faq($conn);
    }

    public function showFaqs()
    {
        // Start the session to check if the user is logged in
        session_start();

        // Fetch FAQs from the model
        $faqs = $this->faqModel->getAllFaqs();

        // Check the session to see if the user is logged in and pass the data to the view
        $data = [
            'title' => 'FAQs',
            'faqs' => $faqs,
            'firstname' => isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true 
                ? $_SESSION['firstname'] 
                : null, // null means logged out
        ];

        // Render the Mustache template
        global $mustache;
        echo $mustache->render('Faq', $data);
    }
}
