<?php
class RegistrationModel {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function isEmailRegistered($email) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM users WHERE email = ? AND status != 'blocked'");
        $stmt->execute([$email]);
        return $stmt->fetchColumn() > 0;
    }

    public function countPremiumMembers() {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM users WHERE account_type = 'Premium'");
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function registerUser($data) {
        $stmt = $this->db->prepare("
            INSERT INTO users (
                account_type, name, address, gender, birthday, age, email, contact_number, bank_name, 
                bank_account_number, card_holder_name, tin_number, company_name, company_address, 
                company_phone_number, position, monthly_earnings, proof_of_billing, valid_id_primary, 
                coe, username, password, status
            ) VALUES (
                :account_type, :name, :address, :gender, :birthday, :age, :email, :contact_number, :bank_name, 
                :bank_account_number, :card_holder_name, :tin_number, :company_name, :company_address, 
                :company_phone_number, :position, :monthly_earnings, :proof_of_billing, :valid_id_primary, 
                :coe, :username, :password, 'pending'
            )
        ");

        return $stmt->execute($data);
    }
}
?>
