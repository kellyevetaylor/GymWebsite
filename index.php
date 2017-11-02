<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>WAD Gym </title>
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
        padding-top: 10%;

    }

    p {
        text-align: center;
        font-size: 25px;
        font-family: Courier;
        color: dodgerblue;
    }

    #GYM {
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


</style>
<body>

<?php


if (isset($_POST["login"])) {
    ?>


    <form action="post">
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
            <p><input type="submit" name="dashboard" value="Login" formaction="Dashboard.php"></p>

        </div>
    </form>


    <?php

} else {

    ?>

    <form method="post">

        <div id="GYM">

            <h1>WAD Gym</h1>

            <input id=inputButton type="submit" value="Creat Account" name="createAccount"
                   formaction="CreateAccount.php">
            <input id=inputButton type="submit" value="Login" name="login" formaction="index.php">

        </div>


    </form>

<?php } ?>

</body>
</html>