<?php

namespace App\Controllers;

class ThankYouController extends BaseController
{
    public function showThankYouPage()
    {
        $template = 'Thank-You';
        $data = ['title' => 'Thank You'];

        echo $this->render($template, $data);
    }
}
