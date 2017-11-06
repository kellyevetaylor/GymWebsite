<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New gym membership form</title>
</head>
<style>

    body {
        background-color: dimgrey;
    }

    #GYM {
        text-align: center;
        color: dodgerblue;
        font-size: 50px;
    }

    h2 {
        text-align: center;
        color: dodgerblue;
    }

    form {
        width: 70%;
        text-align: center;
        margin: 0 auto;
    }

    label, input {

        color: dodgerblue;
        display: inline-block;
    }

    label {

        width: 30%;
        text-align: right;
    }

    label + input {
        background-color: beige;
        width: 20%;
        margin: 0 30% 0 4%;
    }

    input[type=submit] {
        color: dodgerblue;
        cursor: pointer;
        margin: 15px 20px;
        padding: 10px 10px;
        background-color: slategray;
        text-decoration: solid;
        font-size: 20px;
        border: none;
        width: 50%;
    }

</style>

<body>
<h1 id=GYM>WAD GYM</h1>
<h2>Create Account</h2>


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


$host = "devweb2017.cis.strath.ac.uk";
$user = "gmb15147";
$password = "Cei7wevoh4ti";
$dbname = "gmb15147";
$conn = new mysqli($host, $user, $password, $dbname);

$firstName = isset($_POST["firstName"]) ? cleanInput($_POST["firstName"]) : "";
$secondName = isset($_POST["secondName"]) ? cleanInput($_POST["secondName"]) : "";
$email = isset($_POST["email"]) ? cleanInput($_POST["email"]) : "";
$address = isset($_POST["address"]) ? cleanInput($_POST["address"]) : "";
$city = isset($_POST["city"]) ? cleanInput($_POST["city"]) : "";
$postcode = isset($_POST["postcode"]) ? cleanInput($_POST["postcode"]) : "";
$username = isset($_POST["username"]) ? cleanInput($_POST["username"]) : "";
$password = isset($_POST["password"]) ? cleanInput($_POST["password"]) : "";



if(isset($_POST["toDashboard"])){

        $sql= "INSERT INTO `userClasses` (`UserID`, `class1`, `class2`, `class3`, `class4`, `class5`) VALUES (Null, NULL , NULL ,NULL ,NULL ,NULL );";
        $conn->multi_query($sql);

            $password = ($password);
            $sql = "INSERT INTO `Gym Membership`(`id`, `first name`, `second name`, `email address`, `address`, `city`, `postcode`, `username`, `password`) VALUES (NULL, '$firstName', '$secondName', '$email', '$address', '$city', '$postcode', '$username', '$password')";
            $result=$conn->multi_query($sql);

    if (!$result === TRUE) {
        die("Error on insert" . $conn->error);
    }else{
    header('location:Dashboard.php');
}

}else {
    ?>
    <div id="createAccount">
        <form method="POST">
            <p><label>First name:</label>
                <input type="text" name="firstName" required/><br></p>
            <p><label>Second name:</label>
                <input type="text" name="secondName" required/><br></p>
            <p><label>Email address:</label>
                <input type="text" name="email" required/><br></p>
            <p><label>Home address:</label>
                <input type="text" name="address" required/><br></p>
            <p><label>City:</label>
                <input type="text" name="city" required/><br></p>
            <p><label>Postcode:</label>
                <input type="text" name="postcode" required/><br></p>
            <p><label>Username:</label>
                <input type="text" name="username" required/><br></p>
            <p><label>Password:</label>
                <input type="password" name="password" required/><br></p>

            <p><input type="submit" name="toDashboard"/></p>
        </form>
    </div>
    <?php
}
?>

</body>
</html>