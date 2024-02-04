<?php

namespace Server\Model;

use Server\Controller\User;

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
     * TITLE: Validate Agent ID
     * ~ DESCRIPTION: This function will validate the agent ID
     * ~ PUBLIC Function
     * @param int $quantity
     * @return string $id
     */
    public function validate_Agent_ID($quantity)
    {
        while (true) {
            $id = $this->uniqID_generator($quantity);
            if ($this->validate_Unique_ID($id)) {
                return $id;
            }
        }
    }

    /**
     * TITLE: Unique ID Generator
     * ~ DESCRIPTION: This function will generate a unique ID
     * ~ PRIVATE Function
     * @param int $quantity ~ Length of the string
     * @return string $randomString
     */
    private function uniqID_generator($quantity)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $quantity; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }


    /**
     * TITLE: Register New User [MAIN FUNCTION]
     * ~ DESCRIPTION: This function will register a new user
     * ~ PRIVATE Function
     * @param string $email
     * @param string $password
     * @return void
     */
    private function register($email, $password, $name = "Demo")
    {
        $data = array(
            'agent_id' => $this->validate_Agent_ID(10),
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        );
        if ($this->post($data)) {
            echo "Data inserted successfully.";
        } else {
            echo "Error inserting data.";
        }
    }
}
