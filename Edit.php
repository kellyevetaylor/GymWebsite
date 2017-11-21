<?php
/**
 * Created by IntelliJ IDEA.
 * User: xwb15122
 * Date: 16/11/2017
 * Time: 13:35
 */

session_start();
if(empty($_SESSION['userId'])){
    session_destroy();
    header("Location: index.php"); /* Redirect browser */
    exit();
}
function safePOST($conn, $name)
{
    if (isset($_POST[$name])) {
        return $conn->real_escape_string(strip_tags($_POST[$name]));
    } else
        return "";
}

function cleanInput($input)
{
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars(strip_tags($input));
    return $input;

}

$host = "devweb2017.cis.strath.ac.uk";
$user = "cs312_a";
$password = "Thi0Eiwophe3";
$dbname = "cs312_a";
$conn = new mysqli($host, $user, $password, $dbname);



$firstName="";
$secondName ="";
$emailAddress="";
$address ="";
$city="";
$postcode ="";

$newFirstName = isset($_POST["newFirstName"]) ? cleanInput($_POST["newFirstName"]) : $firstName;
$newSecondName = isset($_POST["newSecondName"]) ? cleanInput($_POST["newSecondName"]) : $secondName;
$newEmail = isset($_POST["newEmail"]) ? cleanInput($_POST["newEmail"]) : $emailAddress;
$newAddress = isset($_POST["newAddress"]) ? cleanInput($_POST["newAddress"]) : $address;
$newCity = isset($_POST["newCity"]) ? cleanInput($_POST["newCity"]) : $city;
$newPostcode = isset($_POST["newPostcode"]) ? cleanInput($_POST["newPostcode"]) : $postcode;

$newFirstName = safePost($conn,"newFirstName");
$newSecondName = safePost($conn,"newSecondName");
$newEmail = safePost($conn,"newEmail");
$newAddress =safePost($conn,"newAddress");
$newCity = safePost($conn,"newCity");
$newPostcode = safePost($conn,"newPostcode");



$userId = $_SESSION['userId'];
$sql = "SELECT * FROM `Gym Membership` WHERE `Gym Membership`.id= '$userId'";
$result = $conn->query($sql);


while ($row = $result->fetch_assoc()){
    $firstName= $row["first name"];
    $secondName = $row["second name"];
    $emailAddress= $row["email address"];
    $address = $row["address"];
    $city= $row["city"];
    $postcode = $row["postcode"];
}


if(isset($_POST["updateDetails"])){
    $userId = $_SESSION['userId'];


    $sql = "UPDATE `Gym Membership` SET `first name`= '$newFirstName',`second name`= '$newSecondName',`email address`= '$newEmail',`address`= '$newAddress',`city`= '$newCity',`postcode`='$newPostcode' WHERE `Gym Membership`.`id` = '$userId' ";
   $result= $conn->query($sql);
    if (!$result) {
        die("Query failed" . $conn->error);//get rid of error line
    }
    header("location:MyAccount.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<div>
    <div>
        <form method="POST">
            <p><label>First name:</label>
                <input type="text" name="newFirstName" value="<?php echo $firstName ?>"/><br></p>
            <p><label>Second name:</label>
                <input type="text" name="newSecondName" value="<?php echo $secondName ?>"/><br></p>
            <p><label>Email address:</label>
                <input type="text" name="newEmail" value="<?php echo $emailAddress ?>" /><br></p>
            <p><label>Home address:</label>
                <input type="text" name="newAddress" value="<?php echo $address ?>"/><br></p>
            <p><label>City:</label>
                <input type="text" name="newCity" value="<?php echo $city ?>"/><br></p>
            <p><label>Postcode:</label>
                <input type="text" name="newPostcode" value="<?php echo $postcode ?>"/><br></p>

            <p><input type="submit" name="updateDetails" value="Update"/></p>
        </form>
    </div>

</div>


</body>
</html>

