<?php

class Database
{
    private $connection = null;

    // Redirect to a URL::Accessed by child classes
    public function redirect($url)
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

    /**
     * TITLE: Connect
     * ~ DESCRIPTION: This function will establish a connection to the database
     * ~ PRIVATE Function
     * @return void
     */
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

    /**
     * TITLE: GET Connection
     * ~ Description: This function will return the database connection
     * ~ PROTECTED Function
     * @return PDO $this->connection
     */
    protected function getConnection()
    {
        if (!$this->connection) {
            $this->connect();
            return $this->connection;
        } else {
            return $this->connection;
        }
    }

    /**
     * Title: Get Last User
     * ~ DESCRIPTION: This function will get the last row
     * ~ PROTECTED Function
     * @return string $agent_id
     */
    protected function getLast($table)
    {
        try {
            $sql = "SELECT * FROM $table ORDER BY id DESC LIMIT 1";

            $stmt = $this->getConnection()->prepare($sql);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                return $row['id'] + 1;
            } else {
                return "1";
            }
        } catch (PDOException $e) {
            // Handle database connection or query errors
            return "5";
            echo "<script>alert('Database error: " . $e->getMessage() . "');</script>";
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
