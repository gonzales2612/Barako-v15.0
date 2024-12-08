<?php

namespace App\Controllers;

class AboutController extends BaseController
{
    // Show the About page
    public function showAboutPage()
    {
        $template = 'About'; // Name of the view
        $data = ['title' => 'About Us'];

        echo $this->render($template, $data);
    }
}
