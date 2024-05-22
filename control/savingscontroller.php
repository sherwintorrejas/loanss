<?php
require_once '../models/config.php';
require_once '../models/savingsmodel.php';
require_once '../models/savingstransactionmodel.php';

class SavingsController {
    private $savingsModel;
    private $transactionModel;
    private $db;

    public function __construct() {
        $dbInstance = Database::getInstance();
        $dbConnection = $dbInstance->getConnection();
        $this->db = $dbInstance->getConnection();
        $this->savingsModel = new SavingsModel($dbConnection);
        $this->transactionModel = new SavingsTransactionModel($dbConnection);
    }
    
    public function getSavingsModel() {
        return $this->savingsModel;
    }
    
    public function getTransactionsByUserId($userId, $type = '') {
        if ($type === '') {
            $stmt = $this->db->prepare("SELECT * FROM savingstransaction WHERE savings_id = ?");
            $stmt->execute([$userId]);
        } else {
            $stmt = $this->db->prepare("SELECT * FROM savingstransaction WHERE savings_id = ? AND transaction_type = ?");
            $stmt->execute([$userId, $type]);
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deposit($userId, $amount) {
        if ($amount < 100 || $amount > 1000) {
            return ["Amount should be between 100 and 1000"];
        }
    
        $savingsRecord = $this->savingsModel->getSavingByUserId($userId);
        $currentSavingsAmount = $savingsRecord['savings_amount'];
    
        if ($currentSavingsAmount + $amount > 100000) {
            return ["Savings amount has reached the limit of 100000"];
        }
    
        if ($this->savingsModel->depositToSavings($userId, $amount)) {
            $savingsRecord = $this->savingsModel->getSavingByUserId($userId);
            $this->transactionModel->addTransaction($savingsRecord['savings_id'], 'Deposit', $amount, $savingsRecord['savings_amount'], 'Completed');
            header("Location: {$_SERVER['PHP_SELF']}");
            exit();
            return ["Deposit successful"];
        }
    
        return ["Deposit failed"];
    }

    public function withdraw($userId, $amount) {
        if ($amount < 500 || $amount > 5000) {
            return ["Amount should be between 500 and 5000"];
        }
    
        $savingsRecord = $this->savingsModel->getSavingByUserId($userId);
        if (!$savingsRecord) {
            return ["No savings record found for user ID: $userId"];
        }
    
        if ($savingsRecord['savings_amount'] < $amount) {
            return ["Insufficient funds for withdrawal. User ID: $userId"];
        }

        $withdrawalCount = $this->transactionModel->countWithdrawalsToday($savingsRecord['savings_id']);
        if ($withdrawalCount >= 5) {
            return ["You have reached the maximum number of withdrawals for today"];
        }
    
        try {
            $this->db->beginTransaction();
    
            $stmt = $this->db->prepare("INSERT INTO savingstransaction (transaction_id, savings_id, transaction_type, amount, last_amount, status, date_time) VALUES (?, ?, 'Withdrawal', ?, ?, 'Pending', NOW())");
    
            $transactionId = substr(uniqid('WT', true), 0, 10);
            $stmt->execute([$transactionId, $savingsRecord['savings_id'], $amount, $savingsRecord['savings_amount']]);
    
            if ($stmt->rowCount() > 0) {
                $this->db->commit();
                header("Location: {$_SERVER['PHP_SELF']}");
                exit();
                return ["Withdrawal request sent for approval"];
            } else {
                $this->db->rollBack();
                return ["Failed to insert withdrawal transaction for user ID: $userId"];
            }
        } catch (Exception $e) {
            $this->db->rollBack();
            return ["Exception during withdrawal for user ID: $userId - " . $e->getMessage()];
        }
    }

    public function approveWithdrawal($transactionId) {
        $transaction = $this->transactionModel->searchTransactionById($transactionId);

        if ($transaction && $transaction['status'] === 'Pending') {
            if ($this->transactionModel->updateTransactionStatus($transactionId, 'Completed')) {
                if ($this->savingsModel->deductFromSavings($transaction['savings_id'], $transaction['amount'])) {
                    return ["Withdrawal request approved and amount deducted"];
                } else {
                    return ["Failed to deduct amount from savings for transaction ID: $transactionId"];
                }
            } else {
                return ["Failed to update transaction status to 'Completed'"];
            }
        }

        return ["Invalid transaction or transaction already processed"];
    }

    public function downgradeToBasic($userId) {
        $saving = $this->savingsModel->getSavingByUserId($userId);
        $lastActivityDate = strtotime($saving['last_activity_date']);

        if ($lastActivityDate < strtotime('-3 months')) {
            if ($saving['savings_amount'] == 0) {
                $stmt = $this->db->prepare("UPDATE users SET account_type = 'Basic' WHERE id = ?");
                $stmt->execute([$userId]);
                return $stmt->rowCount() > 0;
            }
        }

        return false;
    }

    public function getTransactionsByType($type) {
        return $this->transactionModel->getTransactionsByType($type);
    }
}
?>
