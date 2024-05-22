<?php
session_start();
include_once('../models/loantransacmodel.php');
$loanTransacModel = new LoanTransacModel();
$userId = $_SESSION['user_id'];
$transactions = $loanTransacModel->getAllTransactionsWithLoanAmountAndMonths($userId);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan Transactions</title>
    <style>
        table {
            width: 100%; border-collapse: collapse;
        }
        th, td {
            border: 1px solid #dddddd; text-align: left; padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<a href="basicloan.php">Back</a>

<h2>Loan Transactions</h2>

<table>
    <thead>
        <tr>
            <th>No.</th>
            <th>Date</th>
            <th>Transaction ID</th>
            <th>Amount</th>
            <th>Status</th>
            <th>Note</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Counter variable
        $counter = 1;

        // Loop through each transaction
        foreach ($transactions as $transaction) {
            ?>
            <tr>
                <td><?php echo $counter++; ?></td>
                <td><?php echo date('m/d/y', strtotime($transaction['transaction_date'])); ?></td>
                <td><?php echo $transaction['lntranid']; ?></td>
                <td><?php echo $transaction['amount_increase']; ?></td>
                <td><?php echo $transaction['LoanStatus']; ?></td>
                <td><?php echo $transaction['admin_remarks']; ?></td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>

</body>
</html>
