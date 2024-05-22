<?php
require_once '../control/savingscontroller.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Assuming you have the user ID stored in session
$userId = $_SESSION['user_id'];

try {
    $savingsController = new SavingsController();
    
    // Get savings model using the getter method
    $savingsModel = $savingsController->getSavingsModel();
    
    // Get savings record for the user
    $savingsRecord = $savingsModel->getSavingByUserId($userId);
    if (!$savingsRecord) {
        throw new Exception("No savings record found for user ID: $userId");
    }

    // Get transactions for the user's savings
    $transactions = $savingsController->getTransactionsByUserId($savingsRecord['savings_id']);

    // Handle deposit form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deposit'])) {
        $amount = $_POST['amount'];
        $result = $savingsController->deposit($userId, $amount);
        echo '<p>' . htmlspecialchars($result[0]) . '</p>';
        // Refresh the savings record after deposit
        $savingsRecord = $savingsModel->getSavingByUserId($userId);
        
    }

    // Handle withdrawal form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['withdraw'])) {
        $amount = $_POST['amount'];
        $result = $savingsController->withdraw($userId, $amount);
        echo '<p>' . htmlspecialchars($result[0]) . '</p>';
        // Refresh the savings record after withdrawal
        $savingsRecord = $savingsModel->getSavingByUserId($userId);
        
    }

} catch (Exception $e) {
    echo '<p>Error: ' . htmlspecialchars($e->getMessage()) . '</p>';
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Savings</title>
    
</head>
<body>
    <h1>Welcome, User</h1>
    <h2>Savings Details:</h2>
    <p>Savings ID: <?php echo htmlspecialchars($savingsRecord['savings_id']); ?></p>
    <p>Savings Amount: <?php echo htmlspecialchars($savingsRecord['savings_amount']); ?></p>

    <h3>Deposit Form:</h3>
    <form method="post">
        <label for="deposit_amount">Amount:</label>
        <input type="number" id="deposit_amount" name="amount" min="100" max="1000" required>
        <button type="submit" name="deposit">Deposit</button>
    </form>

    <h3>Withdrawal Form:</h3>
    <form method="post">
        <label for="withdraw_amount">Amount:</label>
        <input type="number" id="withdraw_amount" name="amount" min="500" max="5000" required>
        <button type="submit" name="withdraw">Withdraw</button>
    </form>
    <a href="premium.php">back</a>
    <h3>Savings Transactions</h3>
    <table border="1">
        <tr>
            <th>No.</th>
            <th>Date</th>
            <th>Transaction ID</th>
            <th>Category</th>
            <th>Amount</th>
            <th>Current Amount</th>
            <th>Status</th>
        </tr>
        <?php
        $i = 1;
        foreach ($transactions as $transaction) {
            echo '<tr>';
            echo '<td>' . $i++ . '</td>';
            echo '<td>' . htmlspecialchars($transaction['date_time']) . '</td>';
            echo '<td>' . htmlspecialchars($transaction['transaction_id']) . '</td>';
            echo '<td>' . htmlspecialchars($transaction['transaction_type']) . '</td>';
            echo '<td>' . htmlspecialchars($transaction['amount']) . '</td>';
            echo '<td>' . htmlspecialchars($transaction['last_amount']) . '</td>';
            echo '<td>' . htmlspecialchars($transaction['status']) . '</td>';
            echo '</tr>';
        }
        ?>
    </table>
</body>
</html>
