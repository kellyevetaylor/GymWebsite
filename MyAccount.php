<!DOCTYPE html>
<html lang="en">
<head>
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

        a {
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

        #GYM {
            text-align: left;
            color: dodgerblue;
            font-size: 65px;
        }

        input[type=submit], button {
            color: dodgerblue;
            cursor: pointer;
            margin: 5px 5px;
            padding: 10px 10px;
            background-color: slategray;
            text-decoration: solid;
            font-size: 20px;
            border: none;
            width: 20%;
        }

        input[type=submit]:hover {
            color: whitesmoke;
        }

        form {
            width: 70%;
            text-align: left;
        }

        label, input {
            color: dodgerblue;
            display: inline-block;
        }

        label {
            width: 30%;
            text-align: left;
        }

        label + input {
            background-color: beige;
            width: 20%;

        }

    </style>
    <meta charset="UTF-8">
    <title>My Account</title>
</head>
<body>
<ul>
    <li><a href=" Dashboard.php">Dashboard</a></li>
    <li><a href="MyAccount.php">My Account</a></li>
    <li><a href="PersonalDiary.php">Personal Diary</a></li>
    <li><a href=" Classes.php">Classes</a></li>
    <li><a href="Contact.php">Contact us</a></li>
</ul>
<?php

//connects to database
$host = "devweb2017.cis.strath.ac.uk";
$user = "gmb15147";
$password = "Cei7wevoh4ti";
$dbname = "gmb15147";
$conn = new mysqli($host, $user, $password, $dbname);

$newPassword1 = isset($_POST["newPassword1"]) ? cleanInput($_POST["newPassword1"]) : "";


if (isset($_POST["updatePassword"])) {

    $sql = "UPDATE `Gym Membership` SET `password` = '$newPassword1' WHERE id = 1";
   $result= $conn->query($sql);


    if (!$result) {
        die("Query failed" . $conn->error);//get rid of error line
    }



}

if (isset($_POST["editDetails"])) {


    ?><h1>Edit details</h1><?php


    echo "Edit details";
    ?>
    <p>
        <button onclick="history.go(-1);">Back</button>
    </p><?php


} else if (isset($_POST["changePassword"])) {
    ?><h1>Change password</h1><?php
    ?>
    <div>
        <form method="POST">
            <p><label>Current password:</label>
                <input type="password" name="oldPassword" required/><br></p>
            <p><label>New password:</label>
                <input type="password" name="newPassword1" required/><br></p>
            <p><label>Re-type new password:</label>
                <input type="password" name="newPassword2" required/><br></p>
            <p><input type="submit" name="updatePassword"></p>
            <p>
                <button onclick="history.go(-1);">Back</button>
            </p>
        </form>
    </div>

<?php } else {
    //by default will display the info and buttons
    ?><h1>My Account</h1><?php
    ?><p><img src="MyAccountImage.png" width="125"></p><?php
    $sql = "SELECT `id`, `first name`, `second name`, `email address`, `address`, `city`, `postcode`, `username`, `password` FROM `Gym Membership`WHERE `id`=1";// change to a variable
    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {
        $firstName = $row["first name"];
        $email = $row["email address"];
        $address = $row["address"];
        $city = $row["city"];
        $postcode = $row["postcode"];
    }
    ?>

    <p><?php echo "Hi " . $firstName . "!"; ?></p>
    <p><?php echo "Email: " . $email; ?></p>
    <p><?php echo "Home address: " . $address; ?></p>
    <p><?php echo "City: " . $city; ?></p>
    <p><?php echo "Postcode: " . $postcode; ?></p>

    <?php
    ?>
    <form method="post">
        <div id="GYM">
            <input id=inputButton type="submit" value="Edit details" name="editDetails"
                   formaction="MyAccount.php">
            <input id=inputButton type="submit" value="Change password" name="changePassword"
                   formaction="MyAccount.php">
        </div>
    </form>
<?php
}

function cleanInput($input)
{
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars(strip_tags($input));
    return $input;

}

?>
</body>
</html>