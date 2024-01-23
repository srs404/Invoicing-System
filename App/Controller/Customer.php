<?php

require_once "App/Controller/Database.php";

class Customer extends Database
{
    /**
     * TITLE: Constructor
     * ~ DESCRIPTION: This function will initialize the database connection
     * @return void
     */
    function __construct()
    {
        // Initialize new database connection
        parent::__construct();
    }

    /**
     * Title: POST
     * ~ DESCRIPTION: This function will create a new user
     * ~ PROTECTED Function
     * @exception EMAIL_ALREADY_EXISTS, DATABASE_ERROR
     *  
     * Perform a dynamic INSERT operation into a table.
     *  
     * @param string $table The name of the table to insert data into.
     * @param array $data An associative array of column names and values to insert.
     *
     * @return bool True if the insertion was successful; otherwise, false.
     */
    protected function post($data)
    {
        // Construct the SQL query
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $sql = "INSERT INTO receipts ($columns) VALUES ($placeholders)";
        $status = false;

        try {
            // Prepare and execute the SQL statement
            $stmt = parent::getConnection()->prepare($sql);
            foreach ($data as $column => $value) {
                $stmt->bindValue(":$column", $value);
            }
            $stmt->execute();
            $status = true;
        } catch (PDOException $e) {
            die("Database error: " . $e->getMessage());
            $status = false;
        } finally {
            return $status;
        }
    }


    /**
     * Title: GET
     * ~ DESCRIPTION: This function will get user data
     * ~ PROTECTED Function
     * @param string $email
     * @return array $row
     */

    protected function get($receipt_id)
    {
        try {
            $sql = "SELECT * FROM receipts WHERE receipt_id = :receipt_id";
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->bindParam(":receipt_id", $receipt_id, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row;
        } catch (PDOException $e) {
            // Log the error to a file or send it to an error tracking system
            error_log('Database error: ' . $e->getMessage());
            // Display a user-friendly error message
            echo "An error occurred while retrieving data. Please try again later.";
            return false;
        }
    }

    /**
     * Title: GET All USERS
     * ~ DESCRIPTION: This function will get all users
     * ~ PROTECTED Function
     * 
     * @return array $row
     */
    protected function getAll()
    {
        try {
            $sql = "SELECT * FROM receipts";
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->execute();
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $row;
        } catch (PDOException $e) {
            // Handle database connection or query errors
            echo "<script>alert('Database error: " . $e->getMessage() . "');</script>";
        }
    }

    /**
     * Title: PUT
     * ~ DESCRIPTION: This function will update a user
     * ~ PROTECTED Function
     * @param string $receipt_id
     * @param array $data
     * 
     * @return bool
     */
    protected function put($receipt_id, $data)
    {
        try {
            $sql = "UPDATE receipts SET ";
            foreach ($data as $column => $value) {
                $sql .= "$column = :$column, ";
            }
            $sql = substr($sql, 0, -2);
            $sql .= " WHERE receipt_id = :receipt_id";
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->bindParam(":receipt_id", $receipt_id, PDO::PARAM_STR);
            foreach ($data as $column => $value) {
                $stmt->bindParam(":$column", $value, PDO::PARAM_STR);
            }
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            // Handle database connection or query errors
            echo "<script>alert('Database error: " . $e->getMessage() . "');</script>";
        }
    }

    /**
     * Title: DELETE
     * ~ DESCRIPTION: This function will delete a user
     * ~ PROTECTED Function
     * @param string $receipt_id
     * 
     * @return bool
     */
    protected function delete($receipt_id)
    {
        try {
            $sql = "DELETE FROM receipts WHERE receipt_id = :receipt_id";
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->bindParam(":receipt_id", $receipt_id, PDO::PARAM_STR);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            // Handle database connection or query errors
            echo "<script>alert('Database error: " . $e->getMessage() . "');</script>";
        }
    }

    /**
     * TITLE: Destructor
     * ~ DESCRIPTION: This function will destroy the database connection
     * @return void
     */
    function __destruct()
    {
        // Destroy the database connection
        parent::__destruct();
    }
}
