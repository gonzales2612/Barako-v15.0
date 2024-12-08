<?php

namespace App\Controllers;

use App\Core\Controller;

class LogoutController extends Controller
{
    public function logout()
    {
        // Start the session
        session_start();

        // Destroy the session to log out the user
        session_unset();
        session_destroy();

        // Redirect to the login page
        header('Location: /login');
        exit;
    }
}
