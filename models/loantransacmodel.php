<?php
include_once('config.php');

class LoanTransacModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAllTransactionsWithLoanAmountAndMonths($userId) {
        try {
            $stmt = $this->db->prepare("SELECT lt.lntranid, lt.loan_id, lt.transaction_type, lt.amount_increase, lt.payable_months_increase, lt.admin_remarks, lt.transaction_date, l.loan_amount AS LoanAmount, l.payable_months AS PayableMonths, l.status AS LoanStatus
                                        FROM loan_transactions lt
                                        INNER JOIN loans l ON lt.loan_id = l.loanid
                                        WHERE l.user_id = :UserID");
            $stmt->bindParam(':UserID', $userId);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log("Error in getAllTransactionsWithLoanAmountAndMonths: " . $e->getMessage());
            return false;
        }
    }
    
    

    public function recordTransaction($loanId, $transactionType, $transactionDate, $status, $details) {
        try {
            $stmt = $this->db->prepare("INSERT INTO loan_transactions (loan_id, transaction_type, amount_increase, payable_months_increase, admin_remarks, transaction_date) VALUES (:LoanID, :TransactionType, NULL, NULL, :AdminRemarks, :TransactionDate)");
            $stmt->bindParam(':LoanID', $loanId);
            $stmt->bindParam(':TransactionType', $transactionType);
            $stmt->bindParam(':AdminRemarks', $details);
            $stmt->bindParam(':TransactionDate', $transactionDate);
            $stmt->execute();
            return true;
        } catch(PDOException $e) {
            error_log("Error in recordTransaction: " . $e->getMessage());
            return false;
        }
    }

}
?>
