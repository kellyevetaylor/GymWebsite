<?php
/**
 * Created by IntelliJ IDEA.
 * User: Ryan
 * Date: 03/11/2017
 * Time: 12:35
 */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    session_start();
    if(empty($_SESSION['userId'])){
        session_destroy();
        header("Location: index.php"); /* Redirect browser */
        exit();
    }
    ?>
    <meta charset="UTF-8">
    <title>Contact us</title>
</head>
<style>
    body {
        background-color: dimgrey;

    }
    ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
        text-decoration: none;
    }
    h1 {
        text-align: left;
        color: dodgerblue;
        font-family: Courier;
        font-size: 40px;
    }

    p {
        text-align: left;
        font-size: 25px;
        font-family: Courier;
        color: dodgerblue;
    }

    a{
        padding: 15px;
        color: black;
        background-color: dodgerblue;
    }

    li {
        text-decoration: none;
        display: inline;
    }

    li a:hover {
        color: whitesmoke;
    }

</style>
<body>

<ul>
    <li><a href=" Dashboard.php">Dashboard</a></li>
    <li><a href="MyAccount.php">My Account</a></li>
    <li><a href="PersonalDiary.php">Personal Diary</a></li>
    <li><a href=" Classes.php">Classes</a></li>
    <li><a href="Contact.php">Contact us</a></li>
</ul>

<h1>Contact us</h1>

<p><b>Phone number</b>: 01632 960806</p>
<p><b>Address</b>: 742 Evergreen Terrace, Springfield, SP2 9HP</p>
<p><b>Opening hours</b>: 24 hours/day, 7 days a week</p>
</body>
</html>
