<?php
/**
 * Created by IntelliJ IDEA.
 * User: pavindersingh
 * Date: 14/11/2017
 * Time: 21:38
 */ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    session_start();
    if(empty($_SESSION['userId']) || empty($_SESSION['isStaff'])){
        session_destroy();
        header("Location: ../../MainPage/index.php"); /* Redirect browser */
        exit();
    }

    function cleanInput($input)
    {
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars(strip_tags($input));
        return $input;

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
$user = "cs312_a";
$password = "Thi0Eiwophe3";
$dbname = "cs312_a";
$conn = new mysqli($host, $user, $password, $dbname);

$userID = "";
$userID = $_SESSION['userId'];

//get staff information
$sql = "SELECT * FROM `staff` WHERE `id` = $userID";// change to a variable
$result = $conn->query($sql);
$rowNum = $result->num_rows;

while ($row = $result->fetch_assoc()) {
    $level = $row["level"];
}



$id = "";
$class = "";
$date = "";
$time = "";
$length = "";
$trainer = "";
$capacity = "";
$classCap = "";

if (isset($_POST["SelectClass"])) {
    $id = safePost($conn, "SelectClass");

    //get all classes information
    $sql1 = "SELECT * FROM `Classes` WHERE `ClassID` = $id";
    $result1 = $conn->query($sql1);

    while ($row = $result1->fetch_assoc()) {
        $class = $row["Class"];
        $date = $row["Date"];
        $time = $row["Time"];
        $length = $row["Length"];
        $trainer = $row["Trainer"];
        $capacity = $row["Capacity"];
        $classCap = $row["classCapacity"];
    }
}

if (isset($_POST["update"])) {
    $selectId = safePost($conn, "classid");
    $selectClass = safePost($conn, "class");
    $selectDate = safePost($conn, "date");
    $selectTime = safePost($conn, "time");
    $selectLength = safePost($conn, "length");
    $selectTrainer = safePost($conn, "trainer");
    $selectCapacity = safePost($conn, "capacity");
    $selectCapacity=(int)$selectCapacity;
    $selectClassCap = safePost($conn, "classcap");
    $selectClassCap=(int)$selectClassCap;

    //update the class information
    $sql = "UPDATE `Classes` SET `Class`= '$selectClass',`Date`= '$selectDate',`Time`= '$selectTime',`Length`= '$selectLength',`Trainer`='$selectTrainer',`Capacity`='$selectCapacity' ,`classCapacity`='$selectClassCap'WHERE `ClassID` = '$selectId' ";

    $result = $conn->query($sql);
    if (!$result) {
        die("Query failed" . $conn->error);//get rid of error line
    }
    $error = "Class Updated.";
    echo "<script type='text/javascript'>alert('$error');</script>";
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
            <a class="navbar-brand" href="indexStaff.php"><?php echo $_SESSION['login']?></a>
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
                        <a href="indexStaff.php"><i class="fa fa-dashboard fa-fw"></i> My Account</a>
                    </li>
                    <?php
                    if($level == "admin"){
                        ?>
                        <li>
                            <a href="adminAccounts.php"><i class="fa fa-users fa-fw"></i> Staff/Customer Accounts</a>
                        </li>
                        <?php
                    }
                    ?>
                    <li>
                        <a href="staffClasses.php"><i class="fa fa-dashboard fa-fw"></i> Classes</a>
                    </li>
                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>

    <div id="page-wrapper">
        <div>
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">(Staff) Classes</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Classes
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover"
                                   id="dataTables-classes">
                                <thead>
                                <tr>
                                    <th>Class ID</th>
                                    <th>Class</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Length</th>
                                    <th>Trainer</th>
                                    <th>Capacity</th>
                                    <th>classCapacity</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                //get all classes information
                                $sql = "SELECT * FROM `Classes`";
                                $result = $conn->query($sql);
                                $rowNum = $result->num_rows;

                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr class=\"odd gradeX\">";
                                    echo "<form method=\"post\" action=\"staffClasses.php\">";
                                    echo "<td>";
                                    echo $row["ClassID"];
                                    echo "</td>";
                                    echo "<td>";
                                    echo $row["Class"];
                                    echo "</td>";
                                    echo "<td>";
                                    echo $row["Date"];
                                    echo "</td>";
                                    echo "<td>";
                                    echo $row["Time"];
                                    echo "</td>";
                                    echo "<td>";
                                    echo $row["Length"];
                                    echo "</td>";
                                    echo "<td>";
                                    echo $row["Trainer"];
                                    echo "</td>";
                                    echo "<td>";
                                    echo $row["Capacity"];
                                    echo "</td>";
                                    echo "<td>";
                                    echo $row["classCapacity"];
                                    echo "</td>";
                                    echo "<td>";
                                    echo "<input type=\"submit\" value=\"Select\" name=\"Select\" class=\"btn btn-outline btn-primary\"/>";
                                    ?>
                                    <input type="hidden" value="<?php echo $row["ClassID"]; ?>" name="SelectClass"/>
                                    <?php
                                    echo "</td>";
                                    echo "</form>";
                                    echo "</tr>";
                                }
                                ?>
                                </tbody>
                            </table>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <h3>Selected Class</h3>
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <form method="post" action=" staffClasses.php">
                                            <tr>
                                                <td>
                                                    Class ID:
                                                </td>
                                                <td>
                                                    Class:
                                                </td>
                                                <td>
                                                    Date:
                                                </td>
                                                <td>
                                                    Time:
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="text" value="<?php echo $id; ?>"
                                                           placeholder="Class ID" disabled/>
                                                    <input type="hidden" name="classid" value="<?php echo $id; ?>"/>
                                                </td>
                                                <td>
                                                    <input type="text" name="class" value="<?php echo $class; ?>"
                                                           placeholder="Class" required/>
                                                </td>
                                                <td>
                                                    <input type=text  name="date" value="<?php echo $date; ?>"
                                                           placeholder="YYYY/MM/DD" />
                                                </td>
                                                <td>
                                                    <input type="text" name="time" required
                                                           value="<?php echo $time; ?>" placeholder="Time"/>
                                                </td>
                                            </tr>
                                            <tr>

                                                <td>
                                                    Length:
                                                </td>
                                                <td>
                                                    Trainer:
                                                </td>
                                                <td>
                                                    Capacity:
                                                </td>
                                                <td>
                                                    Class Capacity:
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="text" name="length" required
                                                           value="<?php echo $length; ?>" placeholder="Length"/>
                                                </td>
                                                <td>
                                                    <input type="text" name="trainer" value="<?php echo $trainer; ?>"
                                                           placeholder="Trainer" required/>
                                                </td>
                                                <td>
                                                    <input type="text" name="capacity" disabled
                                                           value="<?php echo $capacity; ?>" placeholder="Capacity"/>
                                                </td>
                                                <td>
                                                    <input type="text" name="classcap" required value="<?php echo $classCap; ?>"
                                                           placeholder="Class Capacity"/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="submit" value="Update" name="update"
                                                           class="btn btn-outline btn-primary"
                                                        <?php if (!isset($_POST["SelectClass"])) {
                                                            echo "disabled";
                                                        } ?>/>
                                                </td>
                                                <td>
                                                </td>
                                                <td>
                                                </td>
                                                <td>
                                                </td>
                                            </tr>
                                        </form>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
            </div>
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->

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
