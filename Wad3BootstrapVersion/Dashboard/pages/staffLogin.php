<?php
/**
 * Created by IntelliJ IDEA.
 * User: pavindersingh
 * Date: 21/11/2017
 * Time: 11:33
 */ ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <?php
    session_start();
    //make sure the user is not already logged in
    if(!empty($_SESSION['userId'])){
        if(empty($_SESSION['isStaff'])){
            header("Location: ../Dashboard/pages/index.php"); /* Redirect browser */
        }
        else{
            header("Location: ../Dashboard/pages/indexStaff.php"); /* Redirect browser */
        }
    }
    //connects to database
    $host = "devweb2017.cis.strath.ac.uk";
    $user = "cs312_a";
    $password = "Thi0Eiwophe3";
    $dbname = "cs312_a";
    $conn = new mysqli($host, $user, $password, $dbname);

    $loginError = "";
    $username = "";
    $password = "";

    if(isset($_POST["login"])){
        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);
        //sql search for account
        //getting the account information.
        $sql = "SELECT * FROM `staff` WHERE `username` = \"$username\" AND `password` = \"$password\"";// change to a variable
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
                $_SESSION['isStaff'] = "true";

            }
            //session for user account which means we can then access any part of their account details on any page.
            $_SESSION['userAccount'] = $result;
            header("Location: ../pages/indexStaff.php"); /* Redirect browser */
            exit();
        }
    }
    ?>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Staff Login</title>

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

</head>

<body>

<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">(Staff) Please Sign In</h3>
                </div>
                <div class="panel-body">

                    <fieldset>
                        <form method="post" action="staffLogin.php">
                            <div class="form-group">
                                <input class="form-control" placeholder="Username" name="username" type="username">
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Password" name="password" type="password">
                            </div>
                            <div class="form-group">
                                <!-- Change this to a button or input when using this as a form -->
                                <input name="login" type="submit" value="Login" class="btn btn-lg btn-success btn-block"/>
                            </div>
                        </form>
                        <form method="post" action="../../MainPage/index.php">
                            <div class="form-group">
                                <!-- Change this to a button or input when using this as a form -->
                                <input name="back" type="submit" value="Back"
                                       class="btn btn-lg btn-success btn-block" />
                            </div>
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

