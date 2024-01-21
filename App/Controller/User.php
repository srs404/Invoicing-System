<?php

require_once "App/Controller/Database.php";

class User extends Database
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
     * @param string $email
     * @param string $password
     * @param string $name
     * 
     * @return boolean true
     */
    // protected function post($agent_id, $email, $password, $username)
    // {
    //     $sql = "INSERT INTO users (agent_id, email, password, name) VALUES (:agent_id, :email, :password, :username)";
    //     $stmt = $this->getConnection()->prepare($sql);
    //     $stmt->bindParam(":agent_id", $agent_id, PDO::PARAM_STR);
    //     $stmt->bindParam(":email", $email, PDO::PARAM_STR);
    //     $stmt->bindParam(":password", $password, PDO::PARAM_STR);
    //     $stmt->bindParam(":name", $username, PDO::PARAM_STR);
    //     $stmt->execute();
    //     return true;
    // }

    /**
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



    /**
     * Title: GET
     * ~ DESCRIPTION: This function will get user data
     * ~ PROTECTED Function
     * @param string $email
     * @return array $row
     */
    protected function get($email)
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return $row;
        } else {
            return false;
        }
    }

    /**
     * Title: GET All USERS
     * ~ DESCRIPTION: This function will get all users data
     * ~ PROTECTED Function
     * @param string $email
     * @return array $row
     */
    protected function getAll($email)
    {
        $sql = "SELECT * FROM users";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($row) {
            return $row;
        } else {
            return false;
        }
    }

    /**
     * Title: PUT
     * ~ DESCRIPTION: This function will update user data
     * ~ PROTECTED Function
     * @param string $email
     * @param string $password
     * @param string $name
     * @return boolean true
     */
    protected function put($agent_id, $email, $password, $username, $logged_in_at)
    {
        $sql = "UPDATE users SET agent_id = :agent_id, email = :email, password = :password, name = :username, logged_in_at = :logged_in_at WHERE email = :email";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(":agent_id", $agent_id, PDO::PARAM_STR);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->bindParam(":password", $password, PDO::PARAM_STR);
        $stmt->bindParam(":username", $username, PDO::PARAM_STR);
        $stmt->bindParam(":logged_in_at", $logged_in_at, PDO::PARAM_STR);
        $stmt->execute();
        return true;
    }

    /**
     * Title: DELETE
     * ~ DESCRIPTION: This function will delete user data
     * ~ PROTECTED Function
     * @param string $email
     * @return boolean true
     */
    protected function delete($agent_id)
    {
        $sql = "DELETE FROM users WHERE email = :email";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(":email", $agent_id, PDO::PARAM_STR);
        $stmt->execute();
        return true;
    }
}
