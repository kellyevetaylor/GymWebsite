<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    session_start();
    if (empty($_SESSION['userId'])) {
        session_destroy();
        header("Location: index.php"); /* Redirect browser */
        exit();
    }


    function safePost($conn, $name)
    {
        if (isset($_POST[$name])) {
            return $conn->real_escape_string(strip_tags($_POST[$name]));
        } else {
            return "";
        }
    }

    ?>
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
    <li><a href="Dashboard.php">Dashboard</a></li>
    <li><a href="MyAccount.php">My Account</a></li>
    <li><a href="PersonalDiary.php">Personal Diary</a></li>
    <li><a href="Classes.php">Classes</a></li>
    <li><a href="Contact.php">Contact us</a></li>
</ul>
<?php

//connects to database
$host = "devweb2017.cis.strath.ac.uk";
$user = "cs312_a";
$password = "Thi0Eiwophe3";
$dbname = "cs312_a";
$conn = new mysqli($host, $user, $password, $dbname);


$newPassword1 = safePost($conn,"newPassword1");
$newPassword2 = safePost($conn,"newPassword2");
$oldPassword = safePost($conn,"oldPassword");






if (isset($_POST["updatePassword"])) {
    if (updatePassword($conn) == false) {
        displayForm();
        echo "Error - your passwords don't match.";
    } else {
        displayInfo($conn);
    }
} else {

    if (isset($_POST["editDetails"])) {
        editDetails();
    } else if (isset($_POST["changePassword"])) {
        displayForm();
    } else {
        displayInfo($conn);
    }
}


function updatePassword($conn){



    $newPassword1 = isset($_POST["newPassword1"]) ? cleanInput($_POST["newPassword1"]) : "";
    $newPassword2 = isset($_POST["newPassword2"]) ? cleanInput($_POST["newPassword2"]) : "";
    $oldPassword = isset($_POST["oldPassword"]) ? cleanInput($_POST["oldPassword"]) : "";





    if ($newPassword1 == $newPassword2) {
        $newPassword1 = md5($newPassword1);
        $userId = $_SESSION['userId'];
        $sql = "UPDATE `Gym Membership` SET `password` = '$newPassword1' WHERE id = \"$userId\"";
        $conn->query($sql);
        return true;
    } else {
        return false;
    }

}

function editDetails()
{
    ?>
    <form method="post">
        <h1>Edit details</h1>


    </form>


    <?php
    echo "Edit details";


    ?>
    <p>
        <button onclick="history.go(-1);">Back</button>
    <?php
}

function displayForm()
{
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
    <?php
}

function displayInfo($conn)
{
    //by default will display the info and buttons
    ?><h1>My Account</h1><?php
    ?><p><img src="MyAccountImage.png" width="125"></p><?php
    $userId = $_SESSION['userId'];
    $sql = "SELECT `id`, `first name`, `second name`, `email address`, `address`, `city`, `postcode`, `username`, `password` FROM `Gym Membership`WHERE `id`=\"$userId\"";// change to a variable
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
                   formaction="Edit.php">
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

