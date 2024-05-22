<?php
require_once 'config.php';

class SavingsTransactionModel {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function addTransaction($savingsId, $transactionType, $amount, $lastAmount, $status) {
        $transactionId = uniqid('DP', true); 
        $dateTime = date("Y-m-d");
        $stmt = $this->db->prepare("INSERT INTO savingstransaction (transaction_id, savings_id, transaction_type, amount, last_amount, status, date_time) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$transactionId, $savingsId, $transactionType, $amount, $lastAmount, $status, $dateTime]);
        return $stmt->rowCount() > 0;
    }

    public function searchTransactionById($transactionId) {
        $stmt = $this->db->prepare("SELECT * FROM savingstransaction WHERE transaction_id = ?");
        $stmt->execute([$transactionId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getTransactionsByType($type) {
        $stmt = $this->db->prepare("SELECT * FROM savingstransaction WHERE transaction_type = ?");
        $stmt->execute([$type]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateTransactionStatus($transactionId, $status) {
        $stmt = $this->db->prepare("UPDATE savingstransaction SET status = ? WHERE transaction_id = ?");
        $stmt->execute([$status, $transactionId]);
        return $stmt->rowCount() > 0;
    }

    public function countWithdrawalsToday($savingsId) {
        $today = date("Y-m-d");
        $stmt = $this->db->prepare("SELECT COUNT(*) as withdrawal_count FROM savingstransaction WHERE savings_id = ? AND transaction_type = 'Withdrawal' AND DATE(date_time) = ?");
        $stmt->execute([$savingsId, $today]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['withdrawal_count'];
    }
}
?>
