<?php

require_once "App/Controller/Database.php";

class Receipt extends Database
{
    function __construct()
    {
        // Initialize new database connection
        parent::__construct();
    }

    public function generateReceiptID()
    {
        $receipt_id = "R" . date("dmy") . "-" . $this->getLast("receipts");
        return $receipt_id;
    }

    /**
     * Title: Create Receipt [MAIN FUNCTION]
     * ~ Description: Create a new receipt
     * ~ PRIVATE FUNCTION
     * 
     * @param string $customer_name
     * @param string $invoice_id
     * @param string $receipt_id
     * @param string $receipt_date
     * @param string $receipt_amount
     * @param string $receipt_description
     * 
     * @return void
     */
    private function createReceipt(
        $customer_name,
        $customer_email,
        $customer_phone,
        $payment_date,
        $due_date,
        $item_list,
        $subtotal,
        $discount_percentage,
        $discount_amount,
        $payable,
        $convenience_fee,
        $advance_payment,
        $due_payment,
        $agent_id
    ) {
        $sql = "INSERT INTO receipts (
            customer_name,
            customer_email,
            customer_phone,
            payment_date,
            due_date,
            item_list,
            subtotal,
            discount_percentage,
            discount_amount,
            payable,
            convenience_fee,
            advance_payment,
            due_payment,
            agent_id
        ) VALUES (
            :customer_name,
            :customer_email,
            :customer_phone,
            :payment_date,
            :due_date,
            :item_list,
            :subtotal,
            :discount_percentage,
            :discount_amount,
            :payable,
            :convenience_fee,
            :advance_payment,
            :due_payment,
            :agent_id
        )";

        try {
            $stmt = $this->getConnection()->prepare($sql);

            // Binding parameters
            $stmt->bindParam(':customer_name', $customer_name);
            $stmt->bindParam(':customer_email', $customer_email);
            $stmt->bindParam(':customer_phone', $customer_phone);
            $stmt->bindParam(':payment_date', $payment_date);
            $stmt->bindParam(':due_date', $due_date);
            $stmt->bindParam(':item_list', $item_list);
            $stmt->bindParam(':subtotal', $subtotal);
            $stmt->bindParam(':discount_percentage', $discount_percentage);
            $stmt->bindParam(':discount_amount', $discount_amount);
            $stmt->bindParam(':payable', $payable);
            $stmt->bindParam(':convenience_fee', $convenience_fee);
            $stmt->bindParam(':advance_payment', $advance_payment);
            $stmt->bindParam(':due_payment', $due_payment);
            $stmt->bindParam(':agent_id', $agent_id);

            // Execute the prepared statement
            $stmt->execute();

            // Return the ID of the inserted row
            return true;
        } catch (PDOException $e) {
            // Handle error
            die("Error: " . $e->getMessage());
        }
    }

    /**
     * Title: Create [PLACEHOLDER FUNCTION]
     * ~ PUBLIC FUNCTION
     * 
     * @param string $customer_name
     * @param string $customer_email
     * @param int $customer_phone
     * @param date $payment_date
     * @param date $due_date
     * @param JSON $item_list
     * @param float $subtotal
     * @param float $discount_percentage
     * @param float $discount_amount
     * @param float $payable
     * @param float $convenience_fee
     * @param float $advance_payment
     * @param float $due_payment
     * @param string $agent_id
     * 
     * @return boolean true
     */
    public function create(
        $customer_name,
        $customer_email,
        $customer_phone,
        $payment_date,
        $due_date,
        $item_list,
        $subtotal,
        $discount_percentage,
        $discount_amount,
        $payable,
        $convenience_fee,
        $advance_payment,
        $due_payment,
        $agent_id
    ) {
        return $this->createReceipt(
            $customer_name,
            $customer_email,
            $customer_phone,
            $payment_date,
            $due_date,
            $item_list,
            $subtotal,
            $discount_percentage,
            $discount_amount,
            $payable,
            $convenience_fee,
            $advance_payment,
            $due_payment,
            $agent_id
        );
    }

    /**
     * Title: GetReceipt [MAIN FUNCTION]
     * ~ Description: Get a receipt
     * ~ PRIVATE FUNCTION
     * 
     * @param string $receipt_id
     * 
     * @return array $receipt
     */
    private function getReceipt($receipt_id)
    {
        $sql = "SELECT * FROM receipts WHERE receipt_id = :receipt_id";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(":receipt_id", $receipt_id, PDO::PARAM_STR);
        $stmt->execute();
        $receipt = $stmt->fetch(PDO::FETCH_ASSOC);
        return $receipt;
    }

    /**
     * Title: GetReceipt [PLACEHOLDER FUNCTION]
     * ~ PUBLIC FUNCTION
     * 
     * @param string $receipt_id
     * 
     * @return array $receipt
     */
    public function get($receipt_id)
    {
        return $this->getReceipt($receipt_id);
    }

    /**
     * Title: Get All [MAIN FUNCTION]
     * ~ Description: Get all receipts
     * ~ PRIVATE FUNCTION
     * 
     * @param string $receipt_id
     * 
     * @return array $receipt
     */
    private function getAllReceipts($receipt_id)
    {
        $sql = "SELECT * FROM receipts WHERE receipt_id = :receipt_id";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(":receipt_id", $receipt_id, PDO::PARAM_STR);
        $stmt->execute();
        $receipt = $stmt->fetch(PDO::FETCH_ASSOC);
        return $receipt;
    }

    /**
     * Title: Get All [PLACEHOLDER FUNCTION]
     * ~ PUBLIC FUNCTION
     * 
     * @param string $receipt_id
     * 
     * @return array $receipt
     */
    public function getAll($receipt_id)
    {
        return $this->getAllReceipts($receipt_id);
    }

    /**
     * Title: Delete [MAIN FUNCTION]
     * ~ Description: Delete a receipt
     * ~ PRIVATE FUNCTION
     * 
     * @param string $receipt_id
     * 
     * @return void
     */
    private function deleteReceipt($receipt_id)
    {
        $sql = "DELETE FROM receipts WHERE receipt_id = :receipt_id";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(":receipt_id", $receipt_id, PDO::PARAM_STR);
        $stmt->execute();
    }

    /**
     * Title: Delete [PLACEHOLDER FUNCTION]
     * ~ PUBLIC FUNCTION
     * 
     * @param string $receipt_id
     * 
     * @return void
     */
    public function delete($receipt_id)
    {
        $this->deleteReceipt($receipt_id);
    }

    /**
     * Title: Update [MAIN FUNCTION]
     * ~ Description: Update a receipt
     * ~ PRIVATE FUNCTION
     * 
     * @param string $receipt_id
     * @param string $customer_name
     * @param string $customer_email
     * @param int $customer_phone
     * @param date $payment_date
     * @param date $due_date
     * @param JSON $item_list
     * @param float $subtotal
     * @param float $discount_percentage
     * @param float $discount_amount
     * @param float $payable
     * @param float $convenience_fee
     * @param float $advance_payment
     * @param float $due_payment
     * @param string $agent_id
     * 
     * @return void
     */
    private function updateReceipt(
        $receipt_id,
        $customer_name,
        $customer_email,
        $customer_phone,
        $payment_date,
        $due_date,
        $item_list,
        $subtotal,
        $discount_percentage,
        $discount_amount,
        $payable,
        $convenience_fee,
        $advance_payment,
        $due_payment,
        $agent_id
    ) {
        $sql = "UPDATE receipts SET
            customer_name = :customer_name,
            customer_email = :customer_email,
            customer_phone = :customer_phone,
            payment_date = :payment_date,
            due_date = :due_date,
            item_list = :item_list,
            subtotal = :subtotal,
            discount_percentage = :discount_percentage,
            discount_amount = :discount_amount,
            payable = :payable,
            convenience_fee = :convenience_fee,
            advance_payment = :advance_payment,
            due_payment = :due_payment,
            agent_id = :agent_id
        WHERE receipt_id = :receipt_id";

        try {
            $stmt = $this->getConnection()->prepare($sql);

            // Binding parameters
            $stmt->bindParam(':receipt_id', $receipt_id);
            $stmt->bindParam(':customer_name', $customer_name);
            $stmt->bindParam(':customer_email', $customer_email);
            $stmt->bindParam(':customer_phone', $customer_phone);
            $stmt->bindParam(':payment_date', $payment_date);
            $stmt->bindParam(':due_date', $due_date);
            $stmt->bindParam(':item_list', $item_list);
            $stmt->bindParam(':subtotal', $subtotal);
            $stmt->bindParam(':discount_percentage', $discount_percentage);
            $stmt->bindParam(':discount_amount', $discount_amount);
            $stmt->bindParam(':payable', $payable);
            $stmt->bindParam(':convenience_fee', $convenience_fee);
            $stmt->bindParam(':advance_payment', $advance_payment);
            $stmt->bindParam(':due_payment', $due_payment);
            $stmt->bindParam(':agent_id', $agent_id);

            // Execute the prepared statement
            $stmt->execute();

            // Return the ID of the inserted row
            return true;
        } catch (PDOException $e) {
            // Handle error
            die("Error: " . $e->getMessage());
        }
    }

    /**
     * Title: Update [PLACEHOLDER FUNCTION]
     * ~ PUBLIC FUNCTION
     * 
     * @param string $receipt_id
     * @param string $customer_name
     * @param string $customer_email
     * @param int $customer_phone
     * @param date $payment_date
     * @param date $due_date
     * @param JSON $item_list
     * @param float $subtotal
     * @param float $discount_percentage
     * @param float $discount_amount
     * @param float $payable
     * @param float $convenience_fee
     * @param float $advance_payment
     * @param float $due_payment
     * @param string $agent_id
     * 
     * @return void
     */
    public function update(
        $receipt_id,
        $customer_name,
        $customer_email,
        $customer_phone,
        $payment_date,
        $due_date,
        $item_list,
        $subtotal,
        $discount_percentage,
        $discount_amount,
        $payable,
        $convenience_fee,
        $advance_payment,
        $due_payment,
        $agent_id
    ) {
        $this->updateReceipt(
            $receipt_id,
            $customer_name,
            $customer_email,
            $customer_phone,
            $payment_date,
            $due_date,
            $item_list,
            $subtotal,
            $discount_percentage,
            $discount_amount,
            $payable,
            $convenience_fee,
            $advance_payment,
            $due_payment,
            $agent_id
        );
    }

    /**
     * Title: Destructor
     * ~ DESCRIPTION: This function will destroy the database connection
     * ~ PROTECTED Function
     * @return void
     */
    function __destruct()
    {
        parent::__destruct();
    }
}
