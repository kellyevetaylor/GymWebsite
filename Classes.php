<?php
/**
 * Created by IntelliJ IDEA.
 * User: Ryan
 * Date: 02/11/2017
 * Time: 14:00
 */

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        body {
            background-color: dimgrey;

        }

        #GYM {
            text-align: center;
            color: dodgerblue;
            font-size: 50px;
        }

        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            text-decoration: none;
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

        h2 {
            color: dodgerblue;
            text-decoration: underline;
        }

        .right{
            padding-right: 25%;
            text-align: center;
            float: right;
        }

        .left{
            padding-left: 25%;

            text-align: left;
            float: left;
        }




    </style>
    <meta charset="UTF-8">
    <title>Classes</title>
</head>


<?php

$host = "devweb2017.cis.strath.ac.uk";
$user = "gmb15147";
$password = "Cei7wevoh4ti";
$dbname = "gmb15147";
$conn = new mysqli($host, $user, $password, $dbname);


?>
<div id="Nav">
    <p>
    <ul>
        <li><a href="Dashboard.php">Dashboard</a></li>
        <li><a href="MyAccount.php">My Account</a></li>
        <li><a href="PersonalDiary.php">Personal Diary</a></li>
        <li><a href="Classes.php">Classes</a></li>
    </ul>
    </p>

</div>
<h1 id="GYM">WAD GYM</h1>

<div class="left">

    <h2>Classes Available</h2>


    <table>
        <?php

        $sql = "SELECT * FROM `Classes`";
        $result = $conn->query($sql);

        if (!$result) {
            die("Query failed" . $conn->error);//get rid of error line
        }
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . "<br>";
                echo "Date: " . $row["Date"]
                    . "<br>";
                echo "Class: " . $row["Classes"]
                    . "<br> Length: " . $row["Length"] . " minutes<br> ";
                echo "Capacity: " . $row["Capacity"]
                    . "<br> Trainer: " . $row["Trainer"] . "<br>" . "</n>" . "<input type='submit' name='addClass' value='Add Class'/></td>";

                echo "</tr>";


            }
        }

        ?>
    </table>

</div>

<div class="right">
    <h2 >Current Classes</h2>
<table>


</table>

</div>




</body>
</html>
