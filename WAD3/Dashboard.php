<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    session_start();
    ?>
    <style>
        body {

            background-color: dimgrey;
        }

        h1 {
            text-align: center;
            color: dodgerblue;
            font-family: Courier;
            font-size: 50px;
            padding-top: 10%;
        }

        #GYM {
            padding-top: 10%;
            text-align: center;
            color: dodgerblue;
            text-decoration: underline;
            font-size: 65px;

        }

        #GYM2 {
            padding-top: 10%;
            text-align: center;
            color: dodgerblue;
            text-decoration: underline;
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

        input[type=submit]:hover {
            color: whitesmoke;
        }

        p {
            text-align: center;

        }


    </style>
    <meta charset="UTF-8">
    <title>Dashboard</title>

    <script>
        function validateInputForm() {
            var inUsername = document.forms["retryLogin"]["Username"].value;
            var inPassword = document.forms["retryLogin"]["Password"].value;
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
<body>
<?php
//checking to see the account exists.
$username = "";
$password = "";
$firstName = "";
$secondName = "";
//connects to database
$host = "devweb2017.cis.strath.ac.uk";
$user = "cs312_a";
$password = "Thi0Eiwophe3";
$dbname = "cs312_a";
$conn = new mysqli($host, $user, $password, $dbname);
if((!empty($_POST['Username']) && !empty($_POST['Password']))||!empty($_SESSION['login'])){
    $rowNum = 1;
    if(empty($_SESSION['login'])){
        $username = htmlspecialchars($_POST['Username']);
        $password = htmlspecialchars($_POST['Password']);
        //getting the account information.
        $sql = "SELECT * FROM `Gym Membership`WHERE `username` = \"$username\" AND `password` = \"$password\"";// change to a variable
        $result = $conn->query($sql);
        $rowNum = $result->num_rows;
    }
    if(($rowNum)==0 && empty($_SESSION['login']))
    {

        //display html to get them re-etner their username and passwords
        ?>
        <form name="retryLogin" action="Dashboard.php" onsubmit="return validateInputForm()" method="post">
            <div>
                Error: Invalid input
            </div>
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
                <p><input type="submit" name="dashboard" value="Login"  formaction="Dashboard.php"></p>

            </div>
        </form>
        <?php
    }
    else{
        if(empty($_SESSION['login'])) {
            while ($row = $result->fetch_assoc()) {
                $firstName = $row["first name"];
                $secondName = $row["second name"];
                $userId = $row["id"];
                //session for welcome message which can be used in any page.
                $_SESSION['login'] = "Welcome," . $firstName . " " . $secondName;
                $_SESSION['userId'] = $userId;

            }
            //session for user account which means we can then access any part of their account details on any page.
            $_SESSION['userAccount'] = $result;
        }
        ?>
        <form method="post">
            <h1 id="GYM">WAD Gym</h1>

            <div>

                <p id="myAccount">
                    <input type="submit" value="My Account" formaction="MyAccount.php">
                    <input id="diary" type="submit" value="Personal Diary" formaction="PersonalDiary.php">
                    <input id=classes type="submit" value="Classes" formaction="Classes.php">
                    <input id=Contact type="submit" value="Contact Information" formaction="Contact.php">
                    <input id=Logout name=Logout type="submit" value="Logout" formaction="index.php">


                </p>
            </div>

            <div>
                <?php
                $loginName = $_SESSION['login'];
                echo $loginName;
                $_SESSION['login'] = $loginName;
                ?>
            </div>


        </form>
        <?php

    }

}
else{
    session_destroy();
    header("Location: index.php"); /* Redirect browser */
    exit();
}
?>
</body>
</html>

