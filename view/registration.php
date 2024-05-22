<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration Form</title>
    <style>
        
    </style>
    <script>
        function calculateAge() {
            const birthday = document.getElementById('birthday').value;
            const ageInput = document.getElementById('age');

            if (birthday) {
                const birthDate = new Date(birthday);
                const today = new Date();
                let age = today.getFullYear() - birthDate.getFullYear();
                const monthDifference = today.getMonth() - birthDate.getMonth();

                if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthDate.getDate())) {
                    age--;
                }

                ageInput.value = age;
            } else {
                ageInput.value = '';
            }
        }
    </script>
</head>
<body>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../control/registrationcontroller.php';
    $registrationController = new RegistrationController();
    $result = $registrationController->register($_POST, $_FILES);
    if (is_string($result)) {
        echo "<p style='color: red;'>$result</p>";
    } else {
        // If result is an array of errors
        foreach ($result as $error) {
            echo "<p style='color: red;'>$error</p>";
        }
    }
}
?>

<div class="container">
        <form action="registration.php" method="post" enctype="multipart/form-data">
            <h2>Registration Form</h2>
            <div class="form-row column">
                <label for="account_type">Account Type:</label>
                <select name="account_type" id="account_type" required>
                    <option value="Basic">Basic</option>
                    <option value="Premium">Premium</option>
                </select><br>

                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" required><br>

                <label for="address">Address:</label>
                <input type="text" id="address" name="address" value="<?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : ''; ?>" required><br>

                <label for="gender">Gender:</label>
                <select name="gender" id="gender">
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select><br>

                <label for="birthday">Birthday:</label>
                <input type="date" id="birthday" name="birthday" value="<?php echo isset($_POST['birthday']) ? $_POST['birthday'] : ''; ?>" required onchange="calculateAge()"><br>

                <label for="age">Age:</label>
                <input type="number" id="age" name="age" readonly value="<?php echo isset($_POST['age']) ? $_POST['age'] : ''; ?>"><br>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required><br>

                <label for="contact_number">Contact Number:</label>
                <input type="text" id="contact_number" name="contact_number" value="<?php echo isset($_POST['contact_number']) ? htmlspecialchars($_POST['contact_number']) : ''; ?>" required><br>

                <h3>Bank Details</h3>
                <label for="bank_name">Bank Name:</label>
                <input type="text" id="bank_name" name="bank_name" value="<?php echo isset($_POST['bank_name']) ? htmlspecialchars($_POST['bank_name']) : ''; ?>" required><br>

                <label for="bank_account_number">Bank Account Number:</label>
                <input type="text" id="bank_account_number" name="bank_account_number" value="<?php echo isset($_POST['bank_account_number']) ? htmlspecialchars($_POST['bank_account_number']) : ''; ?>" required><br>

                <label for="card_holder_name">Card Holder's Name:</label>
                <input type="text" id="card_holder_name" name="card_holder_name" value="<?php echo isset($_POST['card_holder_name']) ? htmlspecialchars($_POST['card_holder_name']) : ''; ?>" required><br>
                <p>Please make sure that the card holder's name is correct to avoid transaction interruptions.</p>

                <label for="tin_number">TIN Number:</label>
                <input type="text" id="tin_number" name="tin_number" value="<?php echo isset($_POST['tin_number']) ? htmlspecialchars($_POST['tin_number']) : ''; ?>" required><br>

                <h3>Company Information</h3>
                <label for="company_name">Company Name:</label>
                <input type="text" id="company_name" name="company_name" value="<?php echo isset($_POST['company_name']) ? htmlspecialchars($_POST['company_name']) : ''; ?>" required><br>

                <label for="company_address">Company Address:</label>
                <input type="text" id="company_address" name="company_address" value="<?php echo isset($_POST['company_address']) ? htmlspecialchars($_POST['company_address']) : ''; ?>" required><br>

                <label for="company_phone_number">Company Phone Number:</label>
                <input type="text" id="company_phone_number" name="company_phone_number" value="<?php echo isset($_POST['company_phone_number']) ? htmlspecialchars($_POST['company_phone_number']) : ''; ?>" required><br>
                <p>Please put a number directed to your HR to confirm employment.</p>

                <label for="position">Position:</label>
                <input type="text" id="position" name="position" value="<?php echo isset($_POST['position']) ? htmlspecialchars($_POST['position']) : ''; ?>"><br>

                <label for="monthly_earnings">Monthly Earnings:</label>
                <input type="number" id="monthly_earnings" name="monthly_earnings" step="0.01" value="<?php echo isset($_POST['monthly_earnings']) ? $_POST['monthly_earnings'] : ''; ?>"><br>

                <h3>Uploads</h3>
                <label for="proof_of_billing">Proof of Billing:</label>
                <input type="file" id="proof_of_billing" name="proof_of_billing" required><br>

                <label for="valid_id_primary">Valid ID (Primary):</label>
                <input type="file" id="valid_id_primary" name="valid_id_primary" required><br>

                <label for="coe">Certificate of Employment (COE):</label>
                <input type="file" id="coe" name="coe" required><br>

                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" required><br>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required><br>       
                <input type="submit" value="Register">
                <p>already have an account?<a href="login.php">login</a></p>
            </div>
        </form>
    </div>    
</body>
</html>

