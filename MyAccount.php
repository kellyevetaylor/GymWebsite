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

//if either button is pressed then goes to that function
if (isset($_POST["editDetails"])) {
    ?><h1>Edit details</h1><?php
    editDetails();
} else if (isset($_POST["changePassword"])) {
    ?><h1>Change password</h1><?php
    changePasswordForm();
    updatePassword($conn);
} else {
    //by default will display the info and buttons
    ?><h1>My Account</h1><?php
    ?><p><img src="MyAccountImage.png" width="125"></p><?php
    displayUserInfo($conn);
    displayButtons();
}

function cleanInput($input)
{
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars(strip_tags($input));
    return $input;

}

//gets info from database and displays it
function displayUserInfo($conn)
{
    $sql = "SELECT `id`, `first name`, `second name`, `email address`, `address`, `city`, `postcode`, `username`, `password` FROM `Gym Membership`";
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
}

//displays buttons to allow user to edit their info
function displayButtons()
{
    ?>
    <form method="post">
        <div id="GYM">
            <input id=inputButton type="submit" value="Edit details" name="editDetails"
                   formaction="MyAccount.php">
            <input id=inputButton type="submit" value="Change password" name="changePassword"
                   formaction="MyAccount.php">
        </div>
    </form>
<?php }

//allows user to edit their details
function editDetails()
{
    echo "Edit details";
    ?>
    <p>
        <button onclick="history.go(-1);">Back</button>
    </p><?php
}

//allows user to change their password
function changePasswordForm()
{
    ?>
    <div>
        <form method="POST">
            <p><label>Current password:</label>
                <input type="password" name="oldPassword" required/><br></p>
            <p><label>New password:</label>
                <input type="password" name="newPassword1" required/><br></p>
            <p><label>Re-type new password:</label>
                <input type="password" name="newPassword2" required/><br></p>
            <p><input type="submit"></p>
            <p>
                <button onclick="history.go(-1);">Back</button>
            </p>
        </form>
    </div>

    <?php
}

function updatePassword($conn)
{
    $oldPassword = isset($_POST["oldPassword"]) ? cleanInput($_POST["oldPassword"]) : "";
    $newPassword1 = isset($_POST["newPassword1"]) ? cleanInput($_POST["newPassword1"]) : "";
    $newPassword2 = isset($_POST["newPassword2"]) ? cleanInput($_POST["newPassword2"]) : "";

    $sql = "UPDATE Gym Membership SET password = '$newPassword1' WHERE password = '$oldPassword'";
    $conn->query($sql);
}


?>
</body>
</html>
