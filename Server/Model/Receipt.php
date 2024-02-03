<?php

require_once "../Server/Controller/Customer.php";

class Receipt extends Customer
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
        if ($advance_payment == 0) {
            $payment_status = "Paid";
        } else {
            $payment_status = "Partially Paid";
        }

        // Check if due_date initialized
        // if ($due_date == "" || $due_date == null && $due_date == 0 || $due_date == "0000-00-00" || $due_date == "1970-01-01" || $due_date == "1969-12-31") {
        //     $due_date = NULL;
        // }

        $data = array(
            'receipt_id' => $this->generateReceiptID(),
            'customer_name' => $customer_name,
            'customer_email' => $customer_email,
            'customer_phone' => $customer_phone,
            'payment_date' => $payment_date,
            'due_date' => $due_date,
            'payment_status' => $payment_status,
            'item_list' => json_encode($item_list),
            'subtotal' => (float)$subtotal,
            'discount_percentage' => (float)$discount_percentage,
            'discount_amount' => (float)$discount_amount,
            'payable' => (float)$payable,
            'convenience_fee' => (float)$convenience_fee,
            'advance_payment' => (float)$advance_payment,
            'due_payment' => (float)$due_payment,
            'agent_id' => $agent_id,
        );

        return parent::post($data);
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
        return parent::get($receipt_id);
    }

    /**
     * Title: Get All [PLACEHOLDER FUNCTION]
     * ~ PUBLIC FUNCTION
     * 
     * @param string $receipt_id
     * 
     * @return array $receipt
     */
    public function getAll()
    {
        return parent::getAll();
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
        parent::delete($receipt_id);
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
    public function update(
        $receipt_id,
        $customer_name,
        $customer_email,
        $customer_phone,
        $payment_date,
        $due_date,
        $payment_status,
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
        if ($advance_payment == 0) {
            $payment_status = "Paid";
        } else {
            $payment_status = "Partially Paid";
        }

        $data = array(
            'customer_name' => $customer_name,
            'customer_email' => $customer_email,
            'customer_phone' => $customer_phone,
            'payment_date' => $payment_date,
            'due_date' => $due_date,
            'payment_status' => $payment_status,
            'item_list' => $item_list,
            'subtotal' => (float)$subtotal,
            'discount_percentage' => (float)$discount_percentage,
            'discount_amount' => (float)$discount_amount,
            'payable' => (float)$payable,
            'convenience_fee' => (float)$convenience_fee,
            'advance_payment' => (float)$advance_payment,
            'due_payment' => (float)$due_payment,
            'agent_id' => $agent_id,
        );

        parent::put((string)$receipt_id, $data);
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
