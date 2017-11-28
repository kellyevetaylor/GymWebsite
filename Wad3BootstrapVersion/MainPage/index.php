<?php
/**
 * Created by IntelliJ IDEA.
 * User: pavindersingh
 * Date: 14/11/2017
 * Time: 17:10
 */ ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <?php
    session_start();
    //check for a logout
    if(!empty($_POST['Logout'])) {
        session_destroy();
        $logoutMes = "Successfully Logged Out.";
        echo "<script type='text/javascript'>alert('$logoutMes');</script>";
    }else{
        //connects to database
        $host = "devweb2017.cis.strath.ac.uk";
        $user = "cs312_a";
        $password = "Thi0Eiwophe3";
        $dbname = "cs312_a";
        $conn = new mysqli($host, $user, $password, $dbname);

        $loginError = "";
        $username = "";
        $password = "";

        $rowNum = 1;
        //making sure that the user is not logged in
        if(empty($_SESSION['userId']) && empty($_SESSION['isStaff'])){
            //check to make sure the username and password are correct
            if(isset($_POST["Username"]) && isset($_POST["Password"])){
                $username = htmlspecialchars($_POST['Username']);
                $password = htmlspecialchars($_POST['Password']);
                $password = md5($password);
                //getting the account information.
                $sql = "SELECT * FROM `Gym Membership`WHERE `username` = \"$username\" AND `password` = \"$password\"";// change to a variable
                $result = $conn->query($sql);
                $rowNum = $result->num_rows;
                //ro results from database will redirect back to index.
                if($rowNum == 0){
                    $loginError = "Incorrect Username and/or Password entered, Please try again";
                    echo "<script type='text/javascript'>alert('$loginError');</script>";
                }
                else{
                    while ($row = $result->fetch_assoc()) {
                        $firstName = $row["first name"];
                        $secondName = $row["second name"];
                        $userId = $row["id"];
                        //session for welcome message which can be used in any page.
                        $_SESSION['login'] = "Welcome, ".$firstName . " " . $secondName;
                        $_SESSION['userId'] = $userId;

                    }
                    //session for user account which means we can then access any part of their account details on any page.
                    $_SESSION['userAccount'] = $result;
                    header("Location: ../Dashboard/pages/index.php"); /* Redirect browser */
                    exit();
                }
            }
        }
        else {
            if(empty($_SESSION['isStaff'])){
                header("Location: ../Dashboard/pages/index.php"); /* Redirect browser */
            }
            else{
                header("Location: ../Dashboard/pages/indexStaff.php"); /* Redirect browser */
            }
        }
    }
    ?>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="the index page, information regarding the WAD Gym, login and re-direct for signing up" content="">
    <meta name="cs312" content="">

    <title>WAD 3 - Gym</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Cabin:700' rel='stylesheet' type='text/css'>

    <!-- Custom styles for this template -->
    <link href="css/grayscale.min.css" rel="stylesheet">

    <script>
        function validateInputForm() {
            var inUsername = document.forms["loginForm"]["Username"].value;
            var inPassword = document.forms["loginForm"]["Password"].value;
            var message = "Please enter your :\n";
            if(inUsername == ""){
                message = message + "Username\n";
            }
            if(inPassword == ""){
                message = message + "Password\n";
            }
            if (inUsername == "" || inPassword == "") {
                alert(message);
        return false;
        }
        }
        </script>

          <style>
        #errorMessFont {

            color: red;
            background-color: #1b1e21;
        }
    </style>

</head>

<body id="page-top">

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="#page-top">WAD Gym</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="fa fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="#about">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="#signInUp">Account</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="#contact">Contact</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Intro Header -->
<header class="masthead">
    <div class="intro-body">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <h1 class="brand-heading">WAD GYM</h1>
                    <p class="intro-text">
                        WAD GYM offers top quality, next generation equipment for fitness enthusiasts as well beginners.
                        <br>
                        Everything you could need is here so join today with no joining fee!
                    </p>
                    <a href="#about" class="btn btn-circle js-scroll-trigger">
                        <i class="fa fa-angle-double-down animated"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- About Section -->
<section id="about" class="content-section text-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <h2>About WAD GYM</h2>
                <p>
                    We have over 200 gyms across UK with each gym containing roughly 15 personal trainers who are well educated in fitness and are kept up to date with the latest fitness trends and information to ensure quality programs designed specific to you.
                    <br>
                    Our gyms are also kept up to date with the latest technology and receive regular inspections to ensure consistent high quality for customers.
                    <br>
                    So join today for the opportunity to make a new you!
                <p>
            </div>
        </div>
    </div>
</section>

<!-- Download Section -->
<section id="signInUp" class="download-section content-section text-center">
        <div class="container">
            <div class="col-lg-8 mx-auto">
                <p>
                <h2>Account</h2>
                <form name="loginForm" method="post" onsubmit="return validateInputForm()">
                    <ul class="list-inline banner-social-buttons">
                        <li class="list-inline-item">
                            <input type="text" name="Username" placeholder="Username"/>
                        </li>
                    </ul>
                    <ul class="list-inline banner-social-buttons">
                        <li class="list-inline-item">
                            <input type="password" name="Password" placeholder="Password"/>
                        </li>
                    </ul>
                    <ul class="list-inline banner-social-buttons">
                        <input type="submit" name="SignIn" value="Sign In" class="btn btn-default btn-lg"/>
                    </ul>
                </form>
                <form action="../Dashboard/pages/register.php">
                    <ul class="list-inline banner-social-buttons">
                        <input type="submit" href="test" name="SignIn" value="Sign Up" class="btn btn-default btn-lg"/>
                    </ul>
                </form>
                </p>
            </div>
        </div>

</section>

<!-- Contact Section -->
<section id="contact" class="content-section text-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <h2>Contact Us</h2>
                <p>
                    Feel free to contact us with the details below:
                    <br>
                    <br>
                    Tel No. 01632 960806
                    <br>
                    <br>
                    Opening Hours: 24/7
                    <br>
                    <br>
                    Address:
                    <br>
                    742 Evergreen Terrace,
                    <br>
                    Springfield, SP2 9HP
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<div id="map"></div>

<!-- Footer -->
<footer>
    <div class="container text-center">
        <p><a href="../Dashboard/pages/staffLogin.php">Staff Login</a><br/>Copyright &copy; WAD Gym 2017</p>
    </div>
</footer>

<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Plugin JavaScript -->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Google Maps API Key - Use your own API key to enable the map feature. More information on the Google Maps API can be found at https://developers.google.com/maps/ -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCRngKslUGJTlibkQ3FkfTxj3Xss1UlZDA&sensor=false"></script>

<!-- Custom scripts for this template -->
<script src="js/grayscale.min.js"></script>

</body>

</html>
