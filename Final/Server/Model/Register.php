<?php

require_once "../Server/Controller/User.php";

class Register extends User
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
     * TITLE: POST
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
        $sql = "INSERT INTO users ($columns) VALUES ($placeholders)";

        try {
            // Prepare and execute the SQL statement
            $stmt = $this->getConnection()->prepare($sql);
            foreach ($data as $column => $value) {
                $stmt->bindParam(":$column", $value, PDO::PARAM_STR);
            }
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            // Handle the error as needed
            die("Error: " . $e->getMessage());
        }
    }
}
