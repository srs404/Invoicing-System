<?php

class Database
{
    private $connection = null;

    // Redirect to a URL::Accessed by child classes
    protected function redirect($url)
    {
        header("Location: $url");
    }

    function __construct()
    {
        if (!$this->connection) {
            $this->connect();
        } else {
            echo "<script>alert('Connection already established');</script>";
        }
    }

    private function connect()
    {
        $host = "localhost"; // Change this to your MySQL server host
        $database = "tripup_invoice"; // Change this to your database name
        $username = "root"; // Change this to your MySQL username
        $password = ""; // Change this to your MySQL password

        try {
            $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);

            // Set PDO attributes (optional)
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            $this->connection = $pdo;
        } catch (PDOException $e) {
            // Handle database connection error
            die("Database connection failed: " . $e->getMessage());
        }
    }

    protected function getConnection()
    {
        return $this->connection;
    }

    protected function validate_Unique_ID($id)
    {
        $sql = "SELECT * FROM users WHERE agent_id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return false;
        } else {
            return true;
        }
    }

    protected function getLastRow()
    {
        $sql = "SELECT * FROM users ORDER BY id DESC LIMIT 1";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return $row;
        } else {
            return 1;
        }
    }

    protected function validate_Unique_Email($email)
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * TITLE: Destructor
     * ~ DESCRIPTION: This function will destroy the database connection
     * ~ PROTECTED Function
     * @return void
     */
    protected function __destruct()
    {
        $this->connection = null;
    }
}
