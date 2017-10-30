<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New gym membership form</title>
</head>
<style>
    h1 {
        text-align: center;
    }

    form {
        width: 70%;
        text-align: center;
        margin: 0 auto;
    }

    label, input {
        display: inline-block;
    }

    label {
        width: 30%;
        text-align: right;
    }

    label + input {
        width: 20%;
        margin: 0 30% 0 4%;
    }

</style>

<body>
<h1>New gym membership form</h1>

<?php
$host = "devweb2017.cis.strath.ac.uk";
$user = "gmb15147";
$password = "Cei7wevoh4ti";
$dbname = "gmb15147";
$conn = new mysqli($host, $user, $password, $dbname);

    ?>
    <form method="POST">
        <p><label>First name:</label>
            <input type="text" name="firstName"/><br></p>
        <p><label>Second name:</label>
            <input type="text" name="secondName"/><br></p>
        <p><label>Email address:</label>
            <input type="text" name="email"/><br></p>
        <p><label>Home address:</label>
            <input type="text" name="address"/><br></p>
        <p><label>City:</label>
            <input type="text" name="city"/><br></p>
        <p><label>Postcode:</label>
            <input type="text" name="postcode"/><br></p>
        <p><label>Username:</label>
            <input type="text" name="username"/><br></p>
        <p><label>Password:</label>
            <input type="text" name="password"/><br></p>
        <p><input type="submit"/></p>
    </form>
    <?php

    $sql = "TRUNCATE TABLE `Gym Membership`";
    $conn->query($sql);

    $firstName = $_POST["firstName"];
    $secondName = $_POST["secondName"];
    $email = $_POST["email"];
    $address = $_POST["address"];
    $city = $_POST["city"];
    $postcode = $_POST["postcode"];
    $username = $_POST["username"];
    $password = md5($_POST["password"]);

    $sql = "INSERT INTO `Gym Membership`(`id`, `first name`, `second name`, `email address`, `address`, `city`, `postcode`, `username`, `password`) VALUES (NULL, '$firstName', '$secondName', '$email', '$address', '$city', '$postcode', '$username', '$password')";
    $conn->query($sql);

?>
</body>
</html>