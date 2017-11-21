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

    <!-- DataTables CSS -->
    <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

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
$level = "";
$firstName = "";
$secondName = "";
$email = "";
$address = "";
$city = "";
$postcode = "";

//get staff information
$sql = "SELECT * FROM `staff` WHERE `id` = $userID";// change to a variable
$result = $conn->query($sql);
$rowNum = $result->num_rows;

while ($row = $result->fetch_assoc()) {
    $firstName = $row["first name"];
    $secondName = $row["second name"];
    $level = $row["level"];
    $email = $row["email"];
    $address = $row["address"];
    $city = $row["city"];
    $postcode = $row["postcode"];
}

$selectID = "";
$selectFName = "";
$selectSName = "";
$selectUsername = "";
$selectEmail = "";
$selectAddress = "";
$selectCity = "";
$selectPostcode = "";

if(isset($_POST["SelectCust"])){
    //get customer information
    $selectID = $_POST["SelectCust"];
    echo "testing ".$selectID;
    $sql = "SELECT * FROM `Gym Membership` WHERE `id` = $selectID";// change to a variable
    $result = $conn->query($sql);
    $rowNum = $result->num_rows;

    while ($row = $result->fetch_assoc()) {
        $selectFName = $row["first name"];
        $selectSName = $row["second name"];
        $selectUsername = $row["username"];
        $selectEmail = $row["email address"];
        $selectAddress = $row["address"];
        $selectCity = $row["city"];
        $selectPostcode = $row["postcode"];
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
                    <h1 class="page-header">Accounts</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Customer Accounts
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-customer">
                                <thead>
                                <tr>
                                    <th>customer  id</th>
                                    <th>first name</th>
                                    <th>second name</th>
                                    <th>username</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                //get staff information
                                $sql = "SELECT * FROM `Gym Membership`";
                                $result = $conn->query($sql);
                                $rowNum = $result->num_rows;

                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr class=\"odd gradeX\">";
                                        echo "<form method=\"post\" action=\"adminAccounts.php\">";
                                        echo "<td>";
                                            echo $row["id"];
                                        echo "</td>";
                                        echo "<td>";
                                        echo $row["first name"];
                                        echo "</td>";
                                        echo "<td>";
                                        echo $row["second name"];
                                        echo "</td>";
                                        echo "<td>";
                                        echo $row["username"];
                                        echo "</td>";
                                        echo "<td>";
                                        echo "<input type=\"submit\" value=\"Select\" name=\"Select\" class=\"btn btn-outline btn-primary\"/>";
                                        echo "</td>";
                                        ?>
                                        <input type="hidden" value="<?php echo $row["id"]; ?>" name="SelectCust"/>
                                        <?php
                                        echo "</form>";
                                    echo "</tr>";
                                }
                                ?>
                                </tbody>
                            </table>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <h3>Selected Customer Account</h3>
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
                                        <tr>
                                            <td>
                                                ID:
                                            </td>
                                            <td>
                                                First Name:
                                            </td>
                                            <td>
                                                Second Name:
                                            </td>
                                            <td>
                                                Username:
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="text" name="custID" value="<?php echo $selectID; ?>" placeholder="ID" disabled/>
                                            </td>
                                            <td>
                                                <input type="text" name="custFName" value="<?php echo $selectFName;?>" placeholder="First Name"/>
                                            </td>
                                            <td>
                                                <input type="text" name="custSName" value="<?php echo $selectSName;?>" placeholder="Second Name"/>
                                            </td>
                                            <td>
                                                <input type="text" name="custUsername" value="<?php echo $selectUsername;?>" placeholder="Username"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Address:
                                            </td>
                                            <td>
                                                City:
                                            </td>
                                            <td>
                                                PostCode:
                                            </td>
                                            <td>
                                                Email:
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="text" name="custAddress" value="<?php echo $selectAddress;?>" placeholder="Address"/>
                                            </td>
                                            <td>
                                                <input type="text" name="custCity" value="<?php echo $selectCity;?>" placeholder="City"/>
                                            </td>
                                            <td>
                                                <input type="text" name="custPostcode" value="<?php echo $selectPostcode;?>" placeholder="Postcode"/>
                                            </td>
                                            <td>
                                                <input type="text" name="custEmail" value="<?php echo $selectEmail;?>" placeholder="Email"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="submit" value="Update" name="update" class="btn btn-outline btn-primary"
                                                       <?php if(!isset($_POST["SelectCust"])){echo "disabled";} ?>/>
                                            </td>
                                            <td>
                                                <input type="submit" value="Delete" name="delete" class="btn btn-outline btn-danger"
                                                    <?php if(!isset($_POST["SelectCust"])){echo "disabled";} ?>//>
                                            </td>
                                            <td>
                                                <input type="submit" value="Reset Password" name="reset password" class="btn btn-outline btn-warning"
                                                <?php if(!isset($_POST["SelectCust"])){echo "disabled";} ?>//>
                                            </td>
                                            <td></td>
                                        </tr>
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
        <div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Staff Accounts
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-staff">
                                <thead>
                                <tr>
                                    <th>staff id</th>
                                    <th>level</th>
                                    <th>first name</th>
                                    <th>second name</th>
                                    <th>username</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                //get staff information
                                $sql = "SELECT * FROM `staff`";
                                $result = $conn->query($sql);
                                $rowNum = $result->num_rows;

                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr class=\"odd gradeX\">";
                                    echo "<td>";
                                    echo $row["id"];
                                    echo "</td>";
                                    echo "<td>";
                                    echo $row["level"];
                                    echo "</td>";
                                    echo "<td>";
                                    echo $row["first name"];
                                    echo "</td>";
                                    echo "<td>";
                                    echo $row["second name"];
                                    echo "</td>";
                                    echo "<td>";
                                    echo $row["username"];
                                    echo "</td>";
                                    echo "</tr>";
                                }
                                ?>
                                </tbody>
                            </table>
                            <!-- /.table-responsive -->
                            <input type="text" name="staffAcc" placeholder="Enter ID"/>
                            <input type="submit" name="staffBtn" value="Select Account" class="btn btn-outline btn-primary"/>
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

<!-- jQuery -->
<script src="../vendor/jquery/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="../vendor/metisMenu/metisMenu.min.js"></script>

<!-- DataTables JavaScript -->
<script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
<script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>

<!-- Custom Theme JavaScript -->
<script src="../dist/js/sb-admin-2.js"></script>

<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
    $(document).ready(function() {
        $('#dataTables-customer').DataTable({
            responsive: true
        });
    });
    $(document).ready(function() {
        $('#dataTables-staff').DataTable({
            responsive: true
        });
    });
</script>
</body>

</html>
