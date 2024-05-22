<?php
require_once '../models/config.php';
require_once '../models/registrationmodel.php';

class RegistrationController {
    private $model;

    public function __construct() {
        $dbInstance = Database::getInstance();
        $dbConnection = $dbInstance->getConnection();
        $this->model = new RegistrationModel($dbConnection);
    }

    public function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public function validateContactNumber($number) {
        return preg_match('/^(\+63|0)\d{10}$/', $number);
    }

    public function calculateAge($birthday) {
        $dob = new DateTime($birthday);
        $now = new DateTime();
        return $dob->diff($now)->y;
    }

    public function isUnderage($birthday) {
        return $this->calculateAge($birthday) < 18;
    }

    public function register($postData, $fileData) {
        $errors = []; // Initialize an array to store errors
    
        // Validate required fields
        $requiredFields = [
            'account_type', 'name', 'address', 'birthday', 'email', 'contact_number',
            'bank_name', 'bank_account_number', 'card_holder_name', 'tin_number', 'company_name',
            'company_address', 'company_phone_number', 'username', 'password'
        ];
    
        foreach ($requiredFields as $field) {
            if (empty($postData[$field])) {
                $errors[] = "The field {$field} is required.";
            }
        }
    
        // Validate email
        if (!$this->validateEmail($postData['email'])) {
            $errors[] = "Invalid email address.";
        }
    
        if ($this->model->isEmailRegistered($postData['email'])) {
            $errors[] = "Email is already registered or blocked.";
        }
    
        // Validate contact number
        if (!$this->validateContactNumber($postData['contact_number'])) {
            $errors[] = "Invalid contact number.";
        }
    
        // Validate age
        if ($this->isUnderage($postData['birthday'])) {
            $errors[] = "User must be at least 18 years old.";
        }
    
        // Validate username
        if (strlen($postData['username']) < 6) {
            $errors[] = "Username must be at least 6 characters.";
        }
    
        // Handle file uploads
        $uploadDirectories = ['pof' => 'proof_of_billing', 'vid' => 'valid_id_primary', 'coe' => 'coe'];
        if (empty($errors)) {
            foreach ($uploadDirectories as $dir => $field) {
                if (!isset($fileData[$field]) || $fileData[$field]['error'] != UPLOAD_ERR_OK) {
                    $errors[$field] = "Failed to upload {$field}.";
                } else {
                    $uploadPath = __DIR__ . "/../view/{$dir}/";
                    $fileName = basename($fileData[$field]['name']);
                    $uploadFile = $uploadPath . $fileName;
    
                    // Check if file already exists
                    if (file_exists($uploadFile)) {
                        $errors[$field] = "File '{$fileName}' already exists.";
                    } else {
                        // Move uploaded file to destination directory
                        if (!move_uploaded_file($fileData[$field]['tmp_name'], $uploadFile)) {
                            $errors[$field] = "Failed to move uploaded file for {$field}.";
                        } else {
                            $postData[$field] = $uploadFile; // Store the file path in postData
                        }
                    }
                }
            }
        }
    
        if ($postData['account_type'] === 'Premium' && $this->model->countPremiumMembers() >= 50) {
            $errors[] = "Premium account limit reached.";
        }
    
        // Set additional data
        $postData['age'] = $this->calculateAge($postData['birthday']);
        $postData['password'] = password_hash($postData['password'], PASSWORD_BCRYPT);
    
     
        if (!empty($errors)) {
            return $errors;
        }
    
   
        if ($this->model->registerUser($postData)) {
         
            header("Location: ../view/login.php");
            exit();
        } else {
            return "Registration failed. Please try again.";
        }
    }
    
}
?>    