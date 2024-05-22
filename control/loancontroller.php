<?php
session_start();
include_once('../models/loanmodel.php');
include_once('../models/loantransacmodel.php');

class LoanController {
    private $loanModel;
    private $loanTransacModel;

    public function __construct() {
        $this->loanModel = new LoanModel();
        $this->loanTransacModel = new LoanTransacModel();
    }

    public function applyLoan($amount, $duration, $userId) {
        if ($amount < 5000 || $amount > 10000) {
            return "Loan amount must be between 5000 and 10000";
        } elseif ($amount % 1000 !== 0) {
            return "Loan amount must be in increments of 1000";
        } else {
            $interest = $amount * 0.03;
            $amount -= $interest;

            $loanId = $this->loanModel->applyLoan($userId, $amount, $duration);

            if ($loanId) {
                $this->loanTransacModel->recordTransaction($loanId, $userId, 'LoanApplication', date('Y-m-d H:i:s'), 'Pending', 'Loan application submitted');
                return true;
            } else {
                return "Failed to apply for loan.";
            }
        }
    }

    public function getLoansByUserId($userId) {
        return $this->loanModel->getLoansByUserId($userId);
    }
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Initialize LoanController
    $loanController = new LoanController();

    // Validate form inputs
    $amount = $_POST["amount"];
    $duration = $_POST["duration"];
    $userId = $_SESSION['user_id'];

    // Apply for loan
    $result = $loanController->applyLoan($amount, $duration, $userId);
    if ($result === true) {
        echo "Loan application submitted successfully";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "Failed to submit loan application. Error: " . $result;
    }
}
?>
