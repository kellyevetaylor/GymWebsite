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

        input[type=submit] {
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


    </style>
    <meta charset="UTF-8">
    <title>My Account</title>
</head>
<body>
<p>
<ul>
    <li><a href=" Dashboard.php">Dashboard</a></li>
    <li><a href="MyAccount.php">My Account</a></li>
    <li><a href="PersonalDiary.php">Personal Diary</a></li>
    <li><a href=" Classes.php">Classes</a></li>
    <li><a href="Contact.php">Contact us</a></li>
</ul>
</p>
<h1>My Account</h1>

<p><img src="MyAccountImage.png" width="125"></p>

<?php
$host = "devweb2017.cis.strath.ac.uk";
$user = "gmb15147";
$password = "Cei7wevoh4ti";
$dbname = "gmb15147";
$conn = new mysqli($host, $user, $password, $dbname);

$sql = "SELECT `id`, `first name`, `second name`, `email address`, `address`, `city`, `postcode`, `username`, `password` FROM `Gym Membership`";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    $firstName = $row["first name"];
    $secondName = $row["second name"];
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

<div>
    <p>
        <input type="submit" value="Edit details">


        <input type="submit" value="Change password">
    </p>
</div>

</body>
</html>
