<?php
/**
 * Created by IntelliJ IDEA.
 * User: Ryan
 * Date: 02/11/2017
 * Time: 13:59
 */

?>

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
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<p>
<p>
<ul>
    <li><a href="Dashboard.php">Dashboard</a></li>
    <li><a href="MyAccount.php">My Account</a></li>
    <li><a href="PersonalDiary.php">Personal Diary</a></li>
    <li><a href="Classes.php">Classes</a></li>
    <li><a href="Contact.php">Contact us</a></li>
</ul>
</p>
<?php

//connects to database
$host = "devweb2017.cis.strath.ac.uk";
$user = "gmb15147";
$password = "Cei7wevoh4ti";
$dbname = "gmb15147";
$conn = new mysqli($host, $user, $password, $dbname);

$activity = isset($_POST["activity"]) ? cleanInput($_POST["activity"]) : "";
$duration = isset($_POST["time"]) ? cleanInput($_POST["time"]) : "";


function cleanInput($input)
{
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars(strip_tags($input));
    return $input;
}

if(isset($_POST['addactivity'])){

    $sql = "INSERT INTO `userActivities` (`UserID`, `Date`, `Activity`, `Duration`) VALUES ('1', CURRENT_DATE, '$activity', '$duration')";
    $conn->query($sql);
}
?>
<form method="post">
    Add an activity from today:</br>
    <input type="text" name="activity"></br>
    Duration:</br>
    <input type="number" name="time" min="0"></br>

    <input type="submit" name="addactivity" formaction="AddActivity.php"/>
</form>
<?php




//Disconnect
$conn->close();
?>

</body>
</html>

