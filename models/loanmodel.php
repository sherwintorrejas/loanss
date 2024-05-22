<?php
include_once('config.php');

class LoanModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getLoansByUserId($userId) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM loans WHERE user_id = :UserID");
            $stmt->bindParam(':UserID', $userId);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log("Error in getLoansByUserId: " . $e->getMessage());
            return false;
        }
    }

    public function applyLoan($userId, $amount, $duration) {
    try {
        $interest = $amount * 0.03;
        $loanAmount = $amount - $interest;

        $stmt = $this->db->prepare("INSERT INTO loans (user_id, loan_amount, payable_months, status) VALUES (:UserID, :LoanAmount, :PayableMonths, 'Pending')");
        $stmt->bindParam(':UserID', $userId);
        $stmt->bindParam(':LoanAmount', $loanAmount);
        $stmt->bindParam(':PayableMonths', $duration);
        $stmt->execute();
        $loanId = $this->db->lastInsertId();

        // Record loan transaction
        $result = $this->recordLoanTransaction($loanId, 'LoanApplication', $loanAmount, $duration, 'Loan application submitted');
        if ($result) {
            return $loanId;
        } else {
            throw new Exception("Failed to record loan transaction.");
        }
    } catch(PDOException $e) {
        error_log("Error in applyLoan: " . $e->getMessage());
        return false;
    }
}


    private function recordLoanTransaction($loanId, $transactionType, $amountIncrease, $payableMonthsIncrease, $adminRemarks) {
        try {
            $transactionDate = date('Y-m-d H:i:s');
            $stmt = $this->db->prepare("INSERT INTO loan_transactions (loan_id, transaction_type, amount_increase, payable_months_increase, admin_remarks, transaction_date) VALUES (:LoanID, :TransactionType, :AmountIncrease, :PayableMonthsIncrease, :AdminRemarks, :TransactionDate)");
            $stmt->bindParam(':LoanID', $loanId);
            $stmt->bindParam(':TransactionType', $transactionType);
            $stmt->bindParam(':AmountIncrease', $amountIncrease);
            $stmt->bindParam(':PayableMonthsIncrease', $payableMonthsIncrease);
            $stmt->bindParam(':AdminRemarks', $adminRemarks);
            $stmt->bindParam(':TransactionDate', $transactionDate);
            $stmt->execute();
            return true;
        } catch(PDOException $e) {
            error_log("Error in recordLoanTransaction: " . $e->getMessage());
            return false;
        }
    }

    public function getLoanDetailsByUserId($userId) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM loans WHERE user_id = :UserID");
            $stmt->bindParam(':UserID', $userId);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log("Error in getLoanDetailsByUserId: " . $e->getMessage());
            return false;
        }
    }

    public function getLoanById($loanId) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM loans WHERE loanid = :LoanID");
            $stmt->bindParam(':LoanID', $loanId);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log("Error in getLoanById: " . $e->getMessage());
            return false;
        }
    }

    public function updateRemainingPayment($loanId, $remainingPayment) {
        try {
            $stmt = $this->db->prepare("UPDATE loans SET RemainingPayment = :RemainingPayment WHERE loanid = :LoanID");
            $stmt->bindParam(':RemainingPayment', $remainingPayment);
            $stmt->bindParam(':LoanID', $loanId);
            $stmt->execute();
            return true;
        } catch(PDOException $e) {
            error_log("Error in updateRemainingPayment: " . $e->getMessage());
            return false;
        }
    }
}
?>
