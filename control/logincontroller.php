<?php
require_once '../models/config.php';
require_once '../models/loginmodel.php';

class LoginController {
    private $model;

    public function __construct() {
        $dbInstance = Database::getInstance();
        $dbConnection = $dbInstance->getConnection();
        $this->model = new LoginModel($dbConnection);
    }

    public function validateUsername($username) {
        return preg_match('/^[a-zA-Z0-9_@.]{6,}$/', $username);
    }

    public function validatePassword($password) {
        // Example password validation: at least 6 characters, can include letters, numbers, and special characters
        return preg_match('/^[\w@#$%^&*]{6,}$/', $password);
    }

    public function login($postData) {
        $errors = [];

        // Validate username and password
        if (empty($postData['username']) || !$this->validateUsername($postData['username'])) {
            $errors[] = "Invalid username.";
        }

        if (empty($postData['password']) || !$this->validatePassword($postData['password'])) {
            $errors[] = "Invalid password. ";
        }

        if (!empty($errors)) {
            return $errors;
        }

        // Get user by username
        $user = $this->model->getUserByUsername($postData['username']);
        if (!$user) {
            return ["Username or password is incorrect."];
        }

        // Check password
        if (!password_verify($postData['password'], $user['password'])) {
            return ["Username or password is incorrect."];
        }

        // Check account status
        if ($user['status'] === 'pending') {
            return ["Account is in process. Please wait for approval."];
        }

        if ($user['status'] === 'disabled') {
            return ["Account is blocked."];
        }

        // Store user data in session (to show only the user's own data)
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['account_type'] = $user['account_type'];

        // Redirect based on account type
        if ($user['account_type'] === 'Basic') {
            header("Location: ../view/basic.php");
        } elseif ($user['account_type'] === 'Premium') {
            header("Location: ../view/premium.php");
        } elseif ($user['account_type'] === 'Admin') {
            header("Location: ../view/admindash.php");
        } else {
            return ["Unknown account type."];
        }

        
        return "Login successful.";
    }
}
?>
