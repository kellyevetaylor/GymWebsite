<!DOCTYPE html>
<html lang="en">
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
    <title>Personal Diary</title>
</head>
<p>
<p>
<ul>
    <li><a href=" Dashboard.php">Dashboard</a></li>
    <li><a href="MyAccount.php">My Account</a></li>
    <li><a href="AddActivity.php">Add Activity</a></li>
    <li><a href=" Classes.php">Classes</a></li>
    <li><a href="Contact.php">Contact us</a></li>
</ul>
</p>
<?php
//connects to database
$host = "devweb2017.cis.strath.ac.uk";
$user = "cs312_a";
$password = "Thi0Eiwophe3";
$dbname = "cs312_a";
$conn = new mysqli($host, $user, $password, $dbname);

date_default_timezone_set('GMT');
$date = date('Y-m-j');

function activityQuery($conn, $newdate){
    $userId = $_SESSION['userId'];

    $sql = "SELECT `userActivities`.Activity, `userActivities`.Duration FROM `userActivities` WHERE `userActivities`.Date = '$newdate' AND `userActivities`.UserID = '$userId'";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        echo "</br>";
        echo $row['Activity'];
        echo "</br>";
        echo $row['Duration'];
        echo "</br>";


    }
}

function classQuery($conn, $newdate){
    $userId = $_SESSION['userId'];

    $sql = "SELECT * FROM `Classes`,`userClasses`WHERE `Classes`.Date = '$newdate' AND `userClasses`.UserID = '$userId'";
    $result = $conn->query($sql);

    if (!$result) {
        die("Query failed" . $conn->error);//get rid of error line
    }
    if ($result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {

            $classID =$row["ClassID"];
            if ($row["class$classID"] == 1) {

                echo "<br>";
                echo "Class: " . $row["Class"] . "<br>" . " Length: " . $row["Length"] . " minutes<br> ";
                echo "Capacity: " . $row["Capacity"] . "/" . $row["classCapacity"]
                    . "<br> Trainer: " . $row["Trainer"] . "<br>" . "</n>";

            }
        }

    }
}

?>
<div class="right">
    <h2>Personal Diary</h2>

    <table>
        <tr><th><?php
                $newdate = strtotime ( '-2 day' , strtotime ( $date ) ) ;
                $newdate = date ( "Y-m-d" , $newdate );
                echo $newdate;

                ?></th>
            <th><?php
                $newdate1 = strtotime ( '-1 day' , strtotime ( $date ) ) ;
                $newdate1 = date ( "Y-m-d" , $newdate1 );
                echo $newdate1;
                ?></th>
            <th><?php
                $newdate2 = date ("Y-m-d");
                echo $newdate2;  ?>
            <th><?php
                $newdate3 = strtotime ( '+1 day' , strtotime ( $date ) ) ;
                $newdate3 = date ( "Y-m-d" , $newdate3 );
                echo $newdate3;
                echo "</th>";
                ?>
            <th><?php
                $newdate4 = strtotime ( '+2 day' , strtotime ( $date ) ) ;
                $newdate4 = date ( "Y-m-d" , $newdate4 );
                echo $newdate4;
                ?></th>
        </tr>
        <tr>
            <td><?php activityQuery($conn, $newdate);
                classQuery($conn, $newdate)
                ?></td>
            <td><?php activityQuery($conn, $newdate1);
                classQuery($conn, $newdate1);
                ?></td>
            <td><?php activityQuery($conn, $newdate2);
                classQuery($conn, $newdate2);
                ?></td>
            <td><?php activityQuery($conn, $newdate3);
                classQuery($conn, $newdate3);
                ?></td>
            <td><?php activityQuery($conn, $newdate4);
                classQuery($conn, $newdate4);
                ?></td>

        </tr>
        <?php

        $sql = "SELECT * FROM `Classes`,`userClasses`";


        ?>
    </table>


</div>
<?php
//disconnect
$conn->close();
?>
</body>
</html>

