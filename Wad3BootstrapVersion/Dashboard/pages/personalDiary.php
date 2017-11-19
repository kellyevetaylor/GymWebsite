<?php
/**
 * Created by IntelliJ IDEA.
 * User: pavindersingh
 * Date: 16/11/2017
 * Time: 23:18
 */ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    session_start();
    if(empty($_SESSION['userId'])){
        session_destroy();
        header("Location: ../../MainPage/index.php"); /* Redirect browser */
        exit();
    }
    ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>WAD Gym - Dashboard</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../vendor/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<?php
//connects to database
$host = "devweb2017.cis.strath.ac.uk";
$user = "gmb15147";
$password = "Cei7wevoh4ti";
$dbname = "gmb15147";
$conn = new mysqli($host, $user, $password, $dbname);

date_default_timezone_set('GMT');
$date = date('Y-m-j');

function activityQuery($conn, $newdate){
    $sql = "SELECT `userActivities`.Activity, `userActivities`.Duration FROM `userActivities` WHERE `userActivities`.Date = '$newdate'";
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
    $sql = "SELECT * FROM `Classes`,`userClasses`WHERE `Classes`.Date = '$newdate'";
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

<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.html"><?php echo $_SESSION['login']?></a>
        </div>
        <!-- /.navbar-header -->

        <ul class="nav navbar-top-links navbar-right">
            <!-- /.dropdown -->
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-tasks fa-fw"></i> <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-tasks">
                    <li>
                        <a href="#">
                            <div>
                                <p>
                                    <strong>Task 1</strong>
                                    <span class="pull-right text-muted">40% Complete</span>
                                </p>
                                <div class="progress progress-striped active">
                                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                        <span class="sr-only">40% Complete (success)</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="#">
                            <div>
                                <p>
                                    <strong>Task 2</strong>
                                    <span class="pull-right text-muted">20% Complete</span>
                                </p>
                                <div class="progress progress-striped active">
                                    <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                                        <span class="sr-only">20% Complete</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="#">
                            <div>
                                <p>
                                    <strong>Task 3</strong>
                                    <span class="pull-right text-muted">60% Complete</span>
                                </p>
                                <div class="progress progress-striped active">
                                    <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                        <span class="sr-only">60% Complete (warning)</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="#">
                            <div>
                                <p>
                                    <strong>Task 4</strong>
                                    <span class="pull-right text-muted">80% Complete</span>
                                </p>
                                <div class="progress progress-striped active">
                                    <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                                        <span class="sr-only">80% Complete (danger)</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a class="text-center" href="#">
                            <strong>See All Tasks</strong>
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </li>
                </ul>
                <!-- /.dropdown-tasks -->
            </li>
            <!-- /.dropdown -->
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li>
                        <form action="../../MainPage/index.php" method="post">
                            <i class="fa fa-sign-out fa-fw"></i><input type="submit" name="Logout" value="Logout" class="btn btn-outline btn-primary"/>
                        </form>
                    </li>
                </ul>
                <!-- /.dropdown-user -->
            </li>
            <!-- /.dropdown -->
        </ul>
        <!-- /.navbar-top-links -->

        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <li>
                        <a href="index.php"><i class="fa fa-dashboard fa-fw"></i> MyAccount</a>
                    </li>
                    <li>
                        <a href="personalDiary.php"><i class="fa fa-calendar fa-fw"></i> Personal Diary</a>
                    </li>
                    <li>
                        <a href="Classes.php"><i class="fa fa-users fa-fw"></i> Classes</a>
                    </li>
                    <li>
                        <a href="contactUs.php"><i class="glyphicon glyphicon-earphone"></i> Contact Us</a>
                    </li>
                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>



    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Personal Diary</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
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
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /#page-wrapper -->
</div>
<!-- /#wrapper -->

<!-- jQuery -->
<script src="../vendor/jquery/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="../vendor/metisMenu/metisMenu.min.js"></script>

<!-- Morris Charts JavaScript -->
<script src="../vendor/raphael/raphael.min.js"></script>
<script src="../vendor/morrisjs/morris.min.js"></script>
<script src="../data/morris-data.js"></script>

<!-- Custom Theme JavaScript -->
<script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>

