<?php
/**
 * Created by IntelliJ IDEA.
 * User: pavindersingh
 * Date: 16/11/2017
 * Time: 22:02
 */ ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    session_start();
    if (!empty($_SESSION['isStaff'])) {
        header("Location: ../../MainPage/indexStaff.php"); /* Redirect browser */
        exit();
    }
    if (!empty($_SESSION['userId'])) {
        header("Location: ../pages/index.php"); /* Redirect browser */
        exit();
    }
    ?>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>WAD Gym - Register</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <?php
    function cleanInput($input)
    {
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars(strip_tags($input));
        return $input;

    }

    function safePost($conn, $name)
    {
        if (isset($_POST[$name])) {
            return $conn->real_escape_string(strip_tags($_POST[$name]));
        } else {
            return "";
        }
    }

    //Connecting to the database
    $host = "devweb2017.cis.strath.ac.uk";
    $user = "cs312_a";
    $password = "Thi0Eiwophe3";
    $dbname = "cs312_a";
    $conn = new mysqli($host, $user, $password, $dbname);

    //Check for information given
    $firstName = isset($_POST["firstName"]) ? cleanInput($_POST["firstName"]) : "";
    $secondName = isset($_POST["secondName"]) ? cleanInput($_POST["secondName"]) : "";
    $email = isset($_POST["email"]) ? cleanInput($_POST["email"]) : "";
    $address = isset($_POST["address"]) ? cleanInput($_POST["address"]) : "";
    $city = isset($_POST["city"]) ? cleanInput($_POST["city"]) : "";
    $postcode = isset($_POST["postcode"]) ? cleanInput($_POST["postcode"]) : "";
    $username = isset($_POST["username"]) ? cleanInput($_POST["username"]) : "";
    $password = isset($_POST["password"]) ? cleanInput($_POST["password"]) : "";
    $confirmPassword = isset($_POST["ConfirmPassword"]) ? cleanInput($_POST["ConfirmPassword"]) : "";
    $rowNum = 0;

    $firstName = safePost($conn, "firstName");
    $secondName = safePost($conn, "secondName");
    $email = safePost($conn, "email");
    $address = safePost($conn, "address");
    $city = safePost($conn, "city");
    $postcode = safePost($conn, "postcode");
    $username = safePost($conn, "username");
    $password = safePost($conn, "password");
    $confirmPassword = safePost($conn, "ConfirmPassword");


    //make sure both passwords match
    if (!empty($username)) {
        if (($password != $confirmPassword)) {
            $errorMesg = "Passwords do not match please try again";
            echo "<script type='text/javascript'>alert('$errorMesg');</script>";
        } else {
            //sql query to check if the username is already taken
            $sql = "SELECT * FROM `Gym Membership`WHERE `username` = \"$username\"";// change to a variable
            $result = $conn->query($sql);
            $rowNum = $result->num_rows;

            //if the result is not zero means the username is already taken
            if ($rowNum != 0) {
                //display error message
                $errorUser = "Username is already taken!";
                echo "<script type='text/javascript'>alert('$errorUser');</script>";
            } else {
                //creating the account
                $sql = "INSERT INTO `userClasses` (`UserID`, `class1`, `class2`, `class3`, `class4`, `class5`) VALUES (Null, 0 , 0 ,0 ,0 ,0 );";
                $conn->multi_query($sql);

                $newPassword = md5($password);
                $sql = "INSERT INTO `Gym Membership`(`id`, `first name`, `second name`, `email address`, `address`, `city`, `postcode`, `username`, `password`) VALUES (NULL, '$firstName', '$secondName', '$email', '$address', '$city', '$postcode', '$username', '$newPassword')";
                $result = $conn->multi_query($sql);

                if (!$result === TRUE) {
                    die("Error on insert" . $conn->error);
                } else {
                    //creating a session key
                    $rowNum = 1;
                    $sql = "SELECT * FROM `Gym Membership`WHERE `username` = \"$username\" AND `password` = \"$password\"";// change to a variable
                    $result = $conn->query($sql);
                    $rowNum = $result->num_rows;
                    //ro results from database will redirect back to index.
                    if ($rowNum == 0) {
                        $loginError = "Error: Please contact System Admin with your username and email address";
                        echo "<script type='text/javascript'>alert('$loginError');</script>";
                    } else {
                        while ($row = $result->fetch_assoc()) {
                            $firstName = $row["first name"];
                            $secondName = $row["second name"];
                            $userId = $row["id"];
                            //session for welcome message which can be used in any page.
                            $_SESSION['login'] = "Welcome, " . $firstName . " " . $secondName;
                            $_SESSION['userId'] = $userId;

                        }
                        //session for user account which means we can then access any part of their account details on any page.
                        $_SESSION['userAccount'] = $result;
                        header("Location: index.php"); /* Redirect browser */
                        exit();
                    }
                    header('location:index.php');
                }
            }
        }
    }
    ?>

    <script>
        function validateInputForm() {
            var inUsername = document.forms["loginForm"]["Username"].value;
            var inPassword = document.forms["loginForm"]["Password"].value;
            var message = "Please enter your :\n";
            if (inUsername == "") {
                message = message + "Username\n";
            }
            if (inPassword == "") {
                message = message + "Password\n";
            }
            if (inUsername == "" || inPassword == "") {
                alert(message);
                return false;
            }
        }
    </script>

</head>

<body>

<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Please Register</h3>
                </div>
                <div class="panel-body">
                    <fieldset>
                        <form name="registerForm" method="post" onsubmit="return validateInputForm()">


                            <div class="form-group">
                                <input class="form-control" placeholder="First Name" name="firstName" type="name"
                                       autofocus value="<?php $firstName ?>">
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Second Name" name="secondName" type="name"
                                       autofocus value="<?php $secondName ?>">
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="E-mail" name="email" type="email" autofocus
                                       value="<?php $email ?>">
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="1st Line of Address" name="address"
                                       type="address" autofocus value="<?php $address ?>">
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="City" name="city" type="city" autofocus
                                       value="<?php $city ?>">
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="PostCode" name="postcode" type="postcode"
                                       autofocus value="<?php $postcode ?>">
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Username" name="username" type="username"
                                       autofocus value="<?php $username ?>">
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Password" name="password" type="password"
                                       autofocus value="<?php $password ?>">
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Confirm Password" name="ConfirmPassword"
                                       type="password" autofocus value="<?php $confirmPassword ?>">
                            </div>
                            <!-- Change this to a button or input when using this as a form -->
                            <input type="submit" value="Register" class="btn btn-lg btn-success btn-block"/>
                        </form>
                        <br/>
                        <form action="../../MainPage/index.php">
                            <input type="submit" value="Back" class="btn btn-lg btn-success btn-block"/>
                        </form>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="../vendor/jquery/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="../vendor/metisMenu/metisMenu.min.js"></script>

<!-- Custom Theme JavaScript -->
<script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>
