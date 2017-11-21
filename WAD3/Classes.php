<?php
/**
 * Created by IntelliJ IDEA.
 * User: Ryan
 * Date: 02/11/2017
 * Time: 14:00
 */

?>


<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <?php
    session_start();
    if(empty($_SESSION['userId'])){
        session_destroy();
        header("Location: index.php"); /* Redirect browser */
        exit();
    }
    ?>
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

        .right {
            padding-right: 25%;
            text-align: center;
            float: right;
        }

        .left {
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
$user = "cs312_a";
$password = "Thi0Eiwophe3";
$dbname = "cs312_a";
$conn = new mysqli($host, $user, $password, $dbname);


?>
<form method="post">
    <div id="Nav">
        <p>
        <ul>
            <li><a href="Dashboard.php">Dashboard</a></li>
            <li><a href="MyAccount.php">My Account</a></li>
            <li><a href="PersonalDiary.php">Personal Diary</a></li>
            <li><a href="Classes.php">Classes</a></li>
            <li><a href="Contact.php">Contact us</a></li>
        </ul>
        </p>

    </div>
    <h1 id="GYM">WAD GYM</h1>

    <div class="left">

        <h2>Classes Available</h2>

        <table>
            <?php

            $userId = $_SESSION['userId'];
            $sql = "SELECT * FROM Classes,`userClasses` WHERE `userClasses`.UserID = '$userId'";
            $result = $conn->query($sql);

            if (!$result) {
                die("Query failed" . $conn->error);//get rid of error line
            }
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {


                    $limit = $row["classCapacity"];
                    $capacity= $row["Capacity"];

                    $i = $row["ClassID"];
                    if($row["class$i"]==0) {
                        echo "<tr>";
                        echo "<td>" . "<br>";
                        echo "Date: " . $row["Date"] . "<br>";
                        echo "Class: " . $row["Class"] . "<br>" . " Length: " . $row["Length"] . " minutes<br> ";
                        echo "Capacity: " . $row["Capacity"] . "/" . $row["classCapacity"]
                            . "<br> Trainer: " . $row["Trainer"] . "<br>" . "</n>" . "<input type='submit' name='class$i' value='Add Class' formaction='Classes.php '>
            </td>";
                        echo "</tr>";
                    }
                    if (isset($_POST["class$i"])) {
                        //$i is the id of classes class
                        $userId = $_SESSION['userId'];

                       if($capacity<$limit){
                           $sql = "UPDATE `Classes` SET `Capacity`=`Capacity`+1 WHERE `ClassID`=$i AND `Capacity`<`classCapacity`";
                           $conn->query($sql);
                           $sql = "UPDATE `userClasses` SET `class$i`= 1 WHERE `UserID` =\"$userId\"";
                           $result=   $conn->query($sql);
                       }else {
                           $sql = "UPDATE `userClasses` SET `class$i`= 0 WHERE `UserID` =\"$userId\"";
                           $result=   $conn->query($sql);
                       }




                        if (!$result) {
                            die("Query Fail" . $conn->error);
                        }
                        unset($_POST["class$i"]);
                        header('location:Classes.php');
                    }
                }

            }
            ?>
        </table>

    </div>

    <div class="right">
        <h2>Current Classes</h2>

        <table>
            <?php



            $userId = $_SESSION['userId'];
            $sql = "SELECT * FROM `Classes`,`userClasses` WHERE `userClasses`.UserID = '$userId' ";
            $result = $conn->query($sql);

            if (!$result) {
                die("Query failed" . $conn->error);//get rid of error line
            }
            if ($result->num_rows > 0) {

                while ($row = $result->fetch_assoc()) {

                    $classID =$row["ClassID"];
                    if ($row["class$classID"] == 1) {

                        echo "<tr>";
                        echo "<td>" . "<br>";
                        echo "Date: " . $row["Date"] . "<br>";
                        echo "Class: " . $row["Class"] . "<br>" . " Length: " . $row["Length"] . " minutes<br> ";
                        echo "Capacity: " . $row["Capacity"] . "/" . $row["classCapacity"]
                            . "<br> Trainer: " . $row["Trainer"] . "<br>" . "</n>" . " </td>";
                        echo "</tr>";
                    }
                }



            }

            ?>
        </table>


    </div>
</form>


</body>
</html>

