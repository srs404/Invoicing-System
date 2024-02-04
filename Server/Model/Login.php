<?php

namespace Server\Model;

use Server\Controller\User;

class Login extends User
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
     * TITLE: Validate Login Credentials [MAIN FUNCTION]
     * ~ DESCRIPTION: This function will validate the login credentials
     * ~ PRIVATE Function
     * @param string $email
     * @param string $password
     * @exception EMAIL_NOT_FOUND, INVALID_PASSWORD, DATABASE_ERROR
     * @session $_SESSION['agent']['id'], $_SESSION['agent']['loggedin']
     * @return boolean true
     */
    public function login($email, $password)
    {
        $row = $this->get($email, "email", "email, password, agent_id");

        if ($row) {
            // Verify the password using password_verify
            if (password_verify($password, $row['password'])) {
                $_SESSION['agent']['id'] = $row['agent_id'];
                $_SESSION['agent']['loggedin'] = true;
                return true;
            } else {
                // Invalid password
                echo "<script>alert('Invalid password.');</script>";
            }
        } else {
            // Username not found
            echo "<script>alert('Email not found.');</script>";
        }
    }

    /**
     * TITLE: Last Logged In [PLACEHOLDER FUNCTION]
     * ~ DESCRIPTION: This function will call the last_logged_in function
     * ~ PUBLIC Function
     * @param string $agent_id
     * @return void
     */
    public function last_logged_in_update($agent_id)
    {
        $this->last_logged_in($agent_id);
    }

    /**
     * TITLE: Logout
     * ~ DESCRIPTION: This function will logout the user
     * ~ PUBLIC Function
     * @return void
     */
    public function logout()
    {
        // Logout
        $_SESSION = array();
        session_destroy();
        exit;
    }

    /**
     * TITLE: Destructor
     * ~ DESCRIPTION: This function will close the database connection
     * @return void
     */
    function __destruct()
    {
        // Close the database connection
        parent::__destruct();
    }
}
