<?php

require_once "App/Model/Login.php";

$user = new Login();

if (isset($_SESSION['agent']['loggedin'])) {
    if ($_SESSION['agent']['loggedin']) {
        $user->redirect('index.php');
    }
}

if (isset($_POST['username']) && isset($_POST['password'])) {
    if (empty($_POST['username']) || empty($_POST['password'])) {
        echo "<script>alert('Please fill in all the fields.');</script>";
    } else {
        // Login Algo
        $username = $_POST['username'];
        $password = $_POST['password'];

        if ($user->login($username, $password)) {
            $user->last_logged_in_update($_SESSION['agent']['id']);
            $user->redirect('index.php');
        }

        // Register Algo
        // $username = $_POST['username'];
        // $password = $_POST['password'];

        // $user->register($username, $password);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=0.8">
    <title>Login Panel | Invoicing System | TripUp</title>
    <!--Google Font-->
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;600&display=swap" rel="stylesheet">
    <!--Stylesheet-->
    <link rel="stylesheet" href="Assets/CSS/login.css">
</head>

<body>
    <div class="loginCard">
        <center>
            <h2 style="font-weight: bold;">Invoice System Panel</h2>
            <!-- <img src="Assets/Images/loginIcon.png" alt="" width="200px"> -->
        </center><br>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <div class="input-wrapper">
                <div class="prefix">Username ~/</div>
                <input type="text" id="username" name="username" autocomplete="off" placeholder="demo@tripup.io">
            </div>

            <div class="input-wrapper">
                <div class="prefix">Password ~/</div>
                <input type="password" name="password" id="password" placeholder="********">
            </div>
            <br>
            <div style="text-align: center; width: 100%;">
                <input type="submit" class="customBTN" style="width: 100%; border-radius: 10px; box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px; font-weight: bold;" value="Login">
            </div>
        </form>
    </div>
    <!-- <img class="companyLogo" src="Assets/Images/tripuplogocircle.png" style="width: 290px;"> -->
</body>

</html>