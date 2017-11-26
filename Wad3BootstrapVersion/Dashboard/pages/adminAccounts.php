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
    if (empty($_SESSION['userId']) || empty($_SESSION['isStaff'])) {
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


if (isset($_POST["StaffUpdate"])) {

    $selectStaffID = safePost($conn, "staffID");
    $selectStaffFName = safePost($conn, "staffFName");
    $selectStaffSName = safePost($conn, "staffSName");
    $selectStaffEmail = safePost($conn, "staffEmail");
    $selectStaffAddress = safePost($conn, "staffAddress");
    $selectStaffCity = safePost($conn, "staffCity");
    $selectStaffPostcode = safePost($conn, "staffPostcode");

    //set staff information
    $sql = "UPDATE `staff` SET `first name`= '$selectStaffFName',`second name`= '$selectStaffSName',`email`= '$selectStaffEmail',`address`= '$selectStaffAddress',`city`= '$selectStaffCity',`postcode`='$selectStaffPostcode' WHERE `id` = '$selectStaffID' ";
    $result = $conn->query($sql);
    if (!$result) {
        die("Query failed" . $conn->error);//get rid of error line
    }
    $error = "Staff Details Updated.";
    echo "<script type='text/javascript'>alert('$error');</script>";

}

if (isset($_POST["create"])) {

    $lastID = "";
    $selectStaffID = "";
    $selectStaffLevel = $_POST["selectLevel"];
    $selectStaffFName = safePost($conn, "staffFName");
    $selectStaffSName = safePost($conn, "staffSName");
    $selectStaffUsername = "";
    $selectStaffEmail = safePost($conn, "staffEmail");
    $selectStaffAddress = safePost($conn, "staffAddress");
    $selectStaffCity = safePost($conn, "staffCity");
    $selectStaffPostcode = safePost($conn, "staffPostcode");

    //get last staff
    $sql = "SELECT * FROM `staff` ORDER BY id DESC LIMIT 1";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $lastID = $row["id"];
    }

    //new Username
    $lastID = $lastID + 1;
    $selectStaffUsername = "sta".$lastID;
    //default password
    $defaultPassword = md5("default123");

    $sql = "INSERT INTO `staff`(`id`, `level`,`first name`, `second name`, `email`, `address`, `city`, `postcode`, `username`, `password`) VALUES (NULL, '$selectStaffLevel', '$selectStaffFName', '$selectStaffSName', '$selectStaffEmail', '$selectStaffAddress', '$selectStaffCity', '$selectStaffPostcode', '$selectStaffUsername', '$defaultPassword')";
    $result = $conn->multi_query($sql);

    if (!$result === TRUE) {
        die("Error on insert" . $conn->error);
    }
    $error = "Staff Details Updated.Please make them aware of the default Password, and that they must change it immediately by logging in";
    echo "<script type='text/javascript'>alert('$error');</script>";

}

if (isset($_POST["StaffReset"])) {
    $selectStaffID = safePost($conn, "staffID");

    //set staff information
    $defPass = md5("default123");
    $sql = "UPDATE `staff` SET `password`='$defPass' WHERE `id` = '$selectStaffID' ";
    $result = $conn->query($sql);
    if (!$result) {
        die("Query failed" . $conn->error);//get rid of error line
    }
    $errorreset = "Staff Account has been reset Please make them aware of new default poassword and that they must change it immediately.";
    echo "<script type='text/javascript'>alert('$errorreset');</script>";
}

if (isset($_POST["reset"])) {
    $selectID = safePost($conn, "custID");

    //reset customer password
    $newPassword = md5("default123");
    $sql = "UPDATE `Gym Membership` SET `password`='$newPassword' WHERE `id` = '$selectID' ";
    $result = $conn->query($sql);
    if (!$result) {
        die("Query failed" . $conn->error);//get rid of error line
    }
    $errorreset = "Customer Account has been reset Please make them aware of new default poassword and that they must change it immediately.";
    echo "<script type='text/javascript'>alert('$errorreset');</script>";
}

if (isset($_POST["delete"])) {
    $selectID = safePost($conn, "custID");

    //deleting customer accounts
    $sql = "DELETE FROM `Gym Membership` WHERE `id` = '$selectID' ";
    $result = $conn->query($sql);

    $sql = "DELETE FROM `userActivities` WHERE `UserID` = '$selectID' ";
    $result = $conn->query($sql);

    $sql = "DELETE FROM `userClasses` WHERE `UserID` = '$selectID' ";
    $result = $conn->query($sql);

    $errorreset = "Customer Account has been deleted.";
    echo "<script type='text/javascript'>alert('$errorreset');</script>";
}

if (isset($_POST["StaffDelete"])) {
    $selectID = safePost($conn, "staffID");

    //deleting customer accounts
    $sql = "DELETE FROM `staff` WHERE `id` = '$selectID' ";
    $result = $conn->query($sql);
    if (!$result) {
        die("Query failed" . $conn->error);//get rid of error line
    }

    $errorreset = "Staff Account has been deleted.";
    echo "<script type='text/javascript'>alert('$errorreset');</script>";
}

if (isset($_POST["update"])) {

    $selectID = safePost($conn, "custID");
    $selectFName = safePost($conn, "custFName");
    $selectSName = safePost($conn, "custSName");
    $selectEmail = safePost($conn, "custEmail");
    $selectAddress = safePost($conn, "custAddress");
    $selectCity = safePost($conn, "custCity");
    $selectPostcode = safePost($conn, "custPostcode");

    //set staff information
    $sql = "UPDATE `Gym Membership` SET `first name`= '$selectFName',`second name`= '$selectSName',`email address`= '$selectEmail',`address`= '$selectAddress',`city`= '$selectCity',`postcode`='$selectPostcode' WHERE `id` = '$selectID' ";
    $result = $conn->query($sql);
    if (!$result) {
        die("Query failed" . $conn->error);//get rid of error line
    }
    $error = "Customer Details Updated.";
    echo "<script type='text/javascript'>alert('$error');</script>";

}

$selectStaffID = "";
$selectStaffFName = "";
$selectStaffSName = "";
$selectStaffUsername = "";
$selectStaffEmail = "";
$selectStaffAddress = "";
$selectStaffCity = "";
$selectStaffPostcode = "";

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

$selectID = safePost($conn, "SelectCust");
$selectFName = safePost($conn, "first name");
$selectSName = safePost($conn, "second name");
$selectUsername = safePost($conn, "username");
$selectEmail = safePost($conn, "email address");
$selectAddress = safePost($conn, "address");
$selectCity = safePost($conn, "city");
$selectPostcode = safePost($conn, "postcode");

if (isset($_POST["SelectCust"])) {
    //get customer information
    $selectID = $_POST["SelectCust"];
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


if (isset($_POST["SelectStaff"])) {
    //get customer information
    $selectStaffID = $_POST["SelectStaff"];
    $sql = "SELECT * FROM `staff` WHERE `id` = $selectStaffID";// change to a variable
    $result = $conn->query($sql);
    $rowNum = $result->num_rows;
    $selectStaffLevel = "";

    while ($row = $result->fetch_assoc()) {
        $selectStaffID = $row["id"];
        $selectStaffFName = $row["first name"];
        $selectStaffSName = $row["second name"];
        $selectStaffUsername = $row["username"];
        $selectStaffLevel = $row["level"];
        $selectStaffEmail = $row["email"];
        $selectStaffAddress = $row["address"];
        $selectStaffCity = $row["city"];
        $selectStaffPostcode = $row["postcode"];
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
            <a class="navbar-brand" href="indexStaff.php"><?php echo $_SESSION['login'] ?></a>
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
                                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40"
                                         aria-valuemin="0" aria-valuemax="100" style="width: 40%">
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
                                    <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20"
                                         aria-valuemin="0" aria-valuemax="100" style="width: 20%">
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
                                    <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60"
                                         aria-valuemin="0" aria-valuemax="100" style="width: 60%">
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
                                    <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80"
                                         aria-valuemin="0" aria-valuemax="100" style="width: 80%">
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
                            <i class="fa fa-sign-out fa-fw"></i><input type="submit" name="Logout" value="Logout"
                                                                       class="btn btn-outline btn-primary"/>
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
                    if ($level == "admin") {
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
                            <table width="100%" class="table table-striped table-bordered table-hover"
                                   id="dataTables-customer">
                                <thead>
                                <tr>
                                    <th>customer id</th>
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
                                    ?>
                                    <input type="hidden" value="<?php echo $row["id"]; ?>" name="SelectCust"/>
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
                                        <form method="post" action="adminAccounts.php">
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
                                                <input type="text" value="<?php echo $selectID; ?>"
                                                       placeholder="ID" disabled/>
                                                <input type="hidden" name="custID" value="<?php echo $selectID; ?>"
                                                       placeholder="ID" required/>
                                            </td>
                                            <td>
                                                <input type="text" name="custFName" value="<?php echo $selectFName; ?>"
                                                       placeholder="First Name" required/>
                                            </td>
                                            <td>
                                                <input type="text" name="custSName" value="<?php echo $selectSName; ?>"
                                                       placeholder="Second Name" required/>
                                            </td>
                                            <td>
                                                <input type="text" name="custUsername"
                                                       value="<?php echo $selectUsername; ?>" placeholder="Username" disabled/>
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
                                                <input type="text" name="custAddress" required
                                                       value="<?php echo $selectAddress; ?>" placeholder="Address"/>
                                            </td>
                                            <td>
                                                <input type="text" name="custCity" value="<?php echo $selectCity; ?>"
                                                       placeholder="City" required/>
                                            </td>
                                            <td>
                                                <input type="text" name="custPostcode" required
                                                       value="<?php echo $selectPostcode; ?>" placeholder="Postcode"/>
                                            </td>
                                            <td>
                                                <input type="text" name="custEmail" value="<?php echo $selectEmail; ?>"
                                                       placeholder="Email"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="submit" value="Update" name="update"
                                                       class="btn btn-outline btn-primary"
                                                    <?php if (!isset($_POST["SelectCust"])) {
                                                        echo "disabled";
                                                    } ?>/>
                                            </td>
                                            <td>
                                                <input type="submit" value="Delete" name="delete"
                                                       class="btn btn-outline btn-danger"
                                                    <?php if (!isset($_POST["SelectCust"])) {
                                                        echo "disabled";
                                                    } ?>/>
                                            </td>
                                            <td>
                                                <input type="submit" value="Reset Password" name="reset"
                                                       class="btn btn-outline btn-warning"
                                                    <?php if (!isset($_POST["SelectCust"])) {
                                                        echo "disabled";
                                                    } ?>/>
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
            <div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Staff Accounts
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <table width="100%" class="table table-striped table-bordered table-hover"
                                       id="dataTables-staff">
                                    <thead>
                                    <tr>
                                        <th>staff id</th>
                                        <th>level</th>
                                        <th>first name</th>
                                        <th>second name</th>
                                        <th>username</th>
                                        <th></th>
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
                                        echo "<td>";
                                        ?>
                                        <form method="post" action="adminAccounts.php">
                                            <input type="submit" value="Select" name="SelectedStaff"
                                                   class="btn btn-outline btn-primary"/>
                                            <input type="hidden" value="<?php echo $row["id"]; ?>" name="SelectStaff"/>
                                        </form>
                                        <?php
                                        echo "</td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                    </tbody>
                                </table>
                                <!-- /.table-responsive -->
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <h3>Staff Account</h3>
                                        <table class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                            </thead>

                                                <tbody>
                                                <form method="post" action="adminAccounts.php">
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
                                                    <td>Level:</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input type="text"
                                                               value="<?php echo $selectStaffID; ?>" placeholder="ID"
                                                               disabled/>
                                                        <input type="hidden" name="staffID"
                                                               value="<?php echo $selectStaffID; ?>" placeholder="ID"/>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="staffFName"
                                                               value="<?php echo $selectStaffFName; ?>"
                                                               placeholder="First Name" required/>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="staffSName"
                                                               value="<?php echo $selectStaffSName; ?>"
                                                               placeholder="Second Name" required/>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="staffUsername"
                                                               value="<?php echo $selectStaffUsername; ?>"
                                                               placeholder="Username" disabled/>
                                                    </td>
                                                    <td>
                                                        <?php if (!isset($_POST["SelectStaff"])) {
                                                            ?>
                                                            <select name="selectLevel" class="form-control">
                                                                <option>admin</option>
                                                                <option>manager</option>
                                                            </select>
                                                            <?php
                                                        }else{
                                                            ?>
                                                            <input type="text" name="staffLevel"
                                                                   value="<?php echo $selectStaffLevel; ?>"
                                                                   placeholder="Email" disabled/>
                                                            <?php
                                                        }
                                                        ?>
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
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input type="text" name="staffAddress"
                                                               value="<?php echo $selectStaffAddress; ?>"
                                                               placeholder="Address" required/>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="staffCity"
                                                               value="<?php echo $selectStaffCity; ?>"
                                                               placeholder="City" required/>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="staffPostcode"
                                                               value="<?php echo $selectStaffPostcode; ?>"
                                                               placeholder="Postcode" required/>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="staffEmail"
                                                               value="<?php echo $selectStaffEmail; ?>"
                                                               placeholder="Email" required/>
                                                    </td>
                                                    <td>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input type="submit" value="Update" name="StaffUpdate"
                                                               class="btn btn-outline btn-primary"
                                                            <?php if (!isset($_POST["SelectStaff"])) {
                                                                echo "disabled";
                                                            } ?>/>
                                                    </td>
                                                    <td>
                                                        <input type="submit" value="Delete" name="StaffDelete"
                                                               class="btn btn-outline btn-danger"
                                                        <?php if (!isset($_POST["SelectStaff"])) {
                                                            echo "disabled";
                                                        } ?>/>
                                                    </td>
                                                    <td>
                                                        <input type="submit" value="Reset Password" name="StaffReset"
                                                               class="btn btn-outline btn-warning"
                                                        <?php if (!isset($_POST["SelectStaff"])) {
                                                            echo "disabled";
                                                        } ?>/>
                                                    </td>
                                                    <td>
                                                        <input type="submit" value="Create New Account" name="create"
                                                               class="btn btn-outline btn-success"
                                                            <?php if (isset($_POST["SelectStaff"])) {
                                                                echo "disabled";
                                                            } ?>/>
                                                    </td>
                                                    <td>
                                                        <input type="submit" value="Clear" name="clear"
                                                               class="btn btn-outline btn-info"/>
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
        $(document).ready(function () {
            $('#dataTables-customer').DataTable({
                responsive: true
            });
        });
        $(document).ready(function () {
            $('#dataTables-staff').DataTable({
                responsive: true
            });
        });
    </script>
</body>

</html>
