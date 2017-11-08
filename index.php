<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>WAD Gym </title>
    <?php
    //check if they have tried to log in
    session_start();
    $loginError = "";
    if(!empty($_POST['Logout'])){
        unset($_SESSION['login']);
        unset($_SESSION['login_error']);
        echo "Successfully logout";
        session_destroy();
    }else {
        if (!empty($_SESSION['login'])) {
            header("Location: Dashboard.php"); /* Redirect browser */
            exit();
        }
    }
    ?>

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
</head>
<style>
    body {

        background-color: dimgrey;
    }

    h1 {
        text-align: center;
        color: dodgerblue;
        font-family: Courier;
        font-size: 50px;
    }

    p {
        text-align: center;
        font-size: 25px;
        font-family: Courier;
        color: dodgerblue;
    }

    #GYM {
        text-align: center;
        color: dodgerblue;
        font-size: 65px;
    }

    input[type=submit] {
        color: dodgerblue;
        cursor: pointer;
        margin: 15px 20px;
        padding: 20px 20px;
        background-color: slategray;
        text-decoration: solid;
        font-size: 20px;
        border: none;
        width: 50%;
    }
</style>
<body>
<div>
    <?php echo $loginError;?>
</div>
<?php
if (isset($_POST["login"])) {
    ?>
    <form name="loginForm" action="Dashboard.php" method="post" onsubmit="return validateInputForm()">
        <div>
            <p id="GYM">WAD GYM</p>
            <p>
                Enter Username below:<br>
                <input type="text" name="Username" placeholder="Username"/>
            </p>
            <p>
                Enter Password below:<br>
                <input type="password" name="Password" placeholder="Password" />
            </p>
            <p><input type="submit" name="dashboard" value="Login"></p>

        </div>
    </form>
    <?php
} else {
    ?>
    <form method="post">
        <div id="GYM">
            <h1>WAD Gym</h1>
            <input id=inputButton type="submit" value="Create Account" name="createAccount"
                   formaction="CreateAccount.php">
            <input id=inputButton type="submit" value="Login" name="login" formaction="index.php">
        </div>
    </form>
<?php } ?>

</body>
</html>