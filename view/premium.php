<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premium</title>
    <style>
        /* Button style */
        button {
            padding: 10px 20px;
            margin: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        /* Button hover effect */
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Premium</h1>
    <!-- Button to go to loan.php -->
    <button onclick="goToLoanPage()">Go to Loan Page</button>
    <!-- Button to go to savings.php -->
    <button onclick="goToSavingsPage()">Go to Savings Page</button>
    <!-- Button to go to billings.php -->
    <button onclick="goToBillingsPage()">Go to Billings Page</button>
    <!-- Button to go to accountdet.php -->
    <button onclick="goToAccountDetPage()">Go to Account Details Page</button>

    <script>
        // Function to redirect to loan.php
        function goToLoanPage() {
            window.location.href = 'premiumloan.php';
        }

        // Function to redirect to savings.php
        function goToSavingsPage() {
            window.location.href = 'savings.php';
        }

        // Function to redirect to billings.php
        function goToBillingsPage() {
            window.location.href = 'billings.php';
        }

        // Function to redirect to accountdet.php
        function goToAccountDetPage() {
            window.location.href = 'accountdet.php';
        }
    </script>
</body>
</html>
