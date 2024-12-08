<?php

namespace App\Controllers;

use App\Models\Superuser;

class LoginController extends BaseController
{ 
    public function loginForm() {
        $this->initializeSession();
        // Render the superuser login form (You can change the view template if needed)
        return $this->renderView('login-form', []);
    }

    public function login() {
        $this->initializeSession();



        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            file_put_contents('log.txt', "Login attempt: Username = $username, Password = $password\n", FILE_APPEND);
    
            if (empty($username) || empty($password)) {
                return $this->renderView('login-form', [
                    'errors' => ["Username and password are required."]
                ]);
            }

            $superuser = new Superuser();
            if ($superuser->validateSuperuser($username, $password)) {
                $this->onSuccessfulLogin($username);
            } else {
                return $this->renderView('login-form', [
                    'errors' => ["Invalid username or password."]
                ]);
            }
        } else {
            return $this->loginForm();
        }
    }

    private function onSuccessfulLogin($username) {
        $_SESSION['superuser'] = true;
        $_SESSION['username'] = $username;

        // Redirect to admin page after successful login
        header("Location: /admin");
        exit;
    }

    public function logout() {
        $this->initializeSession();
        session_destroy();
        header("Location: /");
        exit;
    }

    private function renderView($template, $data = []) {
        return $this->render($template, $data);
    }
}
