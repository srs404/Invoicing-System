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
        $this->connect();
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

    protected function close()
    {
        $this->connection = null;
    }

    protected function __destruct()
    {
        $this->close();
    }

    function query($sql, $params = [])
    {
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            // Handle database query error
            die("Database query failed: " . $e->getMessage());
        }
    }

    function fetch($sql, $params = [])
    {
        try {
            $stmt = $this->query($sql, $params);
            return $stmt->fetch();
        } catch (PDOException $e) {
            // Handle database query error
            die("Database query failed: " . $e->getMessage());
        }
    }

    function fetchAll($sql, $params = [])
    {
        try {
            $stmt = $this->query($sql, $params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            // Handle database query error
            die("Database query failed: " . $e->getMessage());
        }
    }
}
