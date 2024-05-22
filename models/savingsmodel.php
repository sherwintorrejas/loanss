<?php
require_once 'config.php';

class SavingsModel {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function getSavingByUserId($userId) {
        $stmt = $this->db->prepare("SELECT * FROM savingdatabase WHERE user_id = ?");
        $stmt->execute([$userId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$result) {
            // If no savings record is found, create one
            $result = $this->createSavingsRecord($userId);
        }
        
        return $result;
    }

    private function createSavingsRecord($userId) {
        // Generate a unique savings ID
        $savingsId = uniqid('SAV', true);

        // Insert a new savings record
        $stmt = $this->db->prepare("INSERT INTO savingdatabase (savings_id, user_id, savings_amount, last_activity_date) VALUES (?, ?, 0, NOW())");
        $stmt->execute([$savingsId, $userId]);

        if ($stmt->rowCount() > 0) {
            // Return the newly created record
            return [
                'savings_id' => $savingsId,
                'user_id' => $userId,
                'savings_amount' => 0,
                'last_activity_date' => date('Y-m-d H:i:s')
            ];
        } else {
            // Handle error if the insertion failed
            return null;
        }
    }

    public function depositToSavings($userId, $amount) {
        $savingsRecord = $this->getSavingByUserId($userId);

        if (!$savingsRecord) {
            return false; // If creating the savings record failed
        }
        $transactionId = substr(uniqid('DP', true), 0, 10);
        $stmt = $this->db->prepare("UPDATE savingdatabase SET savings_amount = savings_amount + ?, last_activity_date = NOW() WHERE savings_id = ?");
        $stmt->execute([$amount, $savingsRecord['savings_id']]);
        return $stmt->rowCount() > 0;
    }

    public function withdrawFromSavings($userId, $amount) {
        $savingsRecord = $this->getSavingByUserId($userId);
    
        if (!$savingsRecord) {
            error_log("Error: No savings record found for user ID: $userId");
            return false;
        }
    
        if ($savingsRecord['savings_amount'] < $amount) {
            error_log("Error: Insufficient funds for withdrawal. User ID: $userId");
            return false;
        }
    
        try {
            $this->db->beginTransaction();
    
            $stmt = $this->db->prepare("INSERT INTO savingstransaction (transaction_id, savings_id, transaction_type, amount, last_amount, status, date_time) VALUES (?, ?, 'Withdrawal', ?, ?, 'Pending', NOW())");
    
            // Ensure transaction ID fits in the column
            $transactionId = substr(uniqid('WT', true), 0, 10);
            $stmt->execute([$transactionId, $savingsRecord['savings_id'], $amount, $savingsRecord['savings_amount']]);
    
            if ($stmt->rowCount() > 0) {
                $this->db->commit();
                return true;
            } else {
                $this->db->rollBack();
                error_log("Error: Failed to insert withdrawal transaction for user ID: $userId");
                return false;
            }
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Exception during withdrawal for user ID: $userId - " . $e->getMessage());
            return false;
        }
    }
    
    

    public function deductFromSavings($savingsId, $amount) {
        $stmt = $this->db->prepare("UPDATE savingdatabase SET savings_amount = savings_amount - ?, last_activity_date = NOW() WHERE savings_id = ?");
        $stmt->execute([$amount, $savingsId]);
        return $stmt->rowCount() > 0;
    }

    public function updateLastActivityDate($userId, $date) {
        $stmt = $this->db->prepare("UPDATE savingdatabase SET last_activity_date = ? WHERE user_id = ?");
        $stmt->execute([$date, $userId]);
        return $stmt->rowCount() > 0;
    }
}
?>
