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

        $user->validate($username, $password);

        // Register Algo
        // $username = $_POST['username'];
        // $password = $_POST['password'];

        // $user->register($username, $password);
    }
}

// Session Destroy Purpose
// $user->logout();
// $user = null;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login Panel | TripUp</title>
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
    <img class="companyLogo" src="https://tripup.info/wp-content/uploads/2023/01/Tripup-logo-1.png" size="200px">
    <!-- <script>
        function redirect() {
            window.location.href = "index.html";
        }
    </script> -->
</body>

</html>