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


<script>
    //not working//
    function validateUpdateDetails() {
        var firstName = document.forms["updateCustDetails"]["custFName"];
        var secondName = document.forms["updateCustDetails"]["custSName"];
        var email = document.forms["updateCustDetails"]["custEmail"];
        var address = document.forms["updateCustDetails"]["custAddress"];
        var city = document.forms["updateCustDetails"]["custCity"];
        var postcode = document.forms["updateCustDetails"]["custPostcode"];


        var errMessage = "";

        if (firstName.value == "" || firstName.value == null) {
            errMessage += " * Please enter your first name\n";

        }

        if (secondName.value == null || secondName.value == "") {
            errMessage += " * Please enter your surname\n";

        }
        if (email.value == "" || email.value == null) {
            errMessage += " * Please enter your email\n";

        }
        if (address.value == "" || address.value == null) {
            errMessage += " * Please enter your address\n";

        }
        if (city.value == "" || city.value == null) {
            errMessage += " * Please enter a city\n";

        }
        if (postcode.value == "" || postcode.value == null) {
            errMessage += " * Please enter your postcode\n";

        }
        if (errMessage != "") {
            alert("Errors as follow:\n" + errMessage + "\n New changes will not be applied\n");
        }
    }

</script>

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

$selectStaffID = "";
$selectStaffFName = "";
$selectStaffSName = "";
$selectStaffUsername = "";
$selectStaffEmail = "";
$selectStaffAddress = "";
$selectStaffCity = "";
$selectStaffPostcode = "";


$isSelected = false;

if (isset($_POST["StaffUpdate"])) {


    $selectStaffID = isset($_POST["staffID"]) ? cleanInput($_POST["staffID"]) : "";
    $selectStaffFName = isset($_POST["staffFName"]) ? cleanInput($_POST["staffFName"]) : "";
    $selectStaffSName = isset($_POST["staffSName"]) ? cleanInput($_POST["staffSName"]) : "";
    $selectStaffEmail = isset($_POST["staffEmail"]) ? cleanInput($_POST["staffEmail"]) : "";
    $selectStaffAddress = isset($_POST["staffAddress"]) ? cleanInput($_POST["staffAddress"]) : "";
    $selectStaffCity = isset($_POST["staffCity"]) ? cleanInput($_POST["staffCity"]) : "";
    $selectStaffPostcode = isset($_POST["staffPostcode"]) ? cleanInput($_POST["staffPostcode"]) : "";
    $selectStaffLevel = isset($_POST["staffLevel"]) ? cleanInput($_POST["staffLevel"]) : "";


    $selectStaffID = safePost($conn, "staffID");
    $selectStaffFName = safePost($conn, "staffFName");
    $selectStaffSName = safePost($conn, "staffSName");
    $selectStaffEmail = safePost($conn, "staffEmail");
    $selectStaffAddress = safePost($conn, "staffAddress");
    $selectStaffCity = safePost($conn, "staffCity");
    $selectStaffPostcode = safePost($conn, "staffPostcode");


    $errorMessage = "";
    $selectStaffUsername = $_POST["staffUsernameStored"];
    if (trim($selectStaffFName) == "") {
        $errorMessage = $errorMessage . " * Invalid Input for First Name\\n";


    }
    if (trim($selectStaffSName) == "") {
        $errorMessage = $errorMessage . " * Invalid Input for Surname\\n";


    }
    if (trim($selectStaffEmail) == "") {
        $errorMessage = $errorMessage . " * Invalid Input for Email\\n";


    }
    if (trim($selectStaffAddress) == "") {
        $errorMessage = $errorMessage . " * Invalid Input for Address\\n";


    }
    if (trim($selectStaffCity) == "") {
        $errorMessage = $errorMessage . " * Invalid Input for City\\n";


    }
    if (trim($selectStaffPostcode) == "") {
        $errorMessage = $errorMessage . " * Invalid Input for Postcode\\n";
    }


    if ($errorMessage == "") {
        //set staff information
        $sql = "UPDATE `staff` SET `first name`= '$selectStaffFName',`second name`= '$selectStaffSName',`email`= '$selectStaffEmail',`address`= '$selectStaffAddress',`city`= '$selectStaffCity',`postcode`='$selectStaffPostcode' WHERE `id` = '$selectStaffID' ";
        $result = $conn->query($sql);
        if (!$result) {
            die("Query failed" . $conn->error);//get rid of error line
        }

        $selectStaffID = "";
        $selectStaffFName = "";
        $selectStaffSName = "";
        $selectStaffUsername = "";
        $selectStaffEmail = "";
        $selectStaffAddress = "";
        $selectStaffCity = "";
        $selectStaffPostcode = "";


        $error = "Staff Details Updated.";
        echo "<script type='text/javascript'>alert('$error');</script>";

    } else {

        $errorMessage = $errorMessage . "\\n New changes will not be applied\\n";

        $selectStaffID = $_POST["staffID"];
        $selectStaffFName = $_POST["staffFNameStored"];
        $selectStaffSName = $_POST["staffSNameStored"];
        $selectStaffCity = $_POST["staffCityStored"];
        $selectStaffAddress = $_POST["staffAddressStored"];
        $selectStaffPostcode = $_POST["staffPostcodeStored"];
        $selectStaffEmail = $_POST["staffEmailStored"];
        $selectStaffUsername = $_POST["staffUsernameStored"];
        $selectStaffLevel = $_POST["staffLevelStored"];


        echo "<script type='text/javascript'>alert('$errorMessage');</script>";
        $isSelected = true;
    }


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

    $errorMsg = "";
    $errorCheck = false;
    if ($selectStaffFName == null || $selectStaffFName == "" || trim($selectStaffFName) == "") {
        $selectStaffFName = $firstName;
        $errorMsg = $errorMsg . "* Invalid Input for First Name\\n";
        $errorCheck = true;
    }

    if ($selectStaffSName == null || $selectStaffSName == "" || trim($selectStaffSName) == "") {
        $selectStaffSName = $secondName;
        $errorMsg = $errorMsg . "* Invalid Input for Second Name\\n";

        $errorCheck = true;
    }
    if ($selectStaffEmail == null || $selectStaffEmail == "" || trim($selectStaffEmail) == "") {
        $selectStaffEmail = $email;
        $errorMsg = $errorMsg . "* Invalid Input for Email\\n";

        $errorCheck = true;
    }
    if ($selectStaffAddress == null || $selectStaffAddress == "" || trim($selectStaffAddress) == "") {
        $selectStaffAddress = $address;
        $errorMsg = $errorMsg . "* Invalid Input for Address\\n";

        $errorCheck = true;
    }
    if ($selectStaffCity == null || $selectStaffCity == "" || trim($selectStaffCity) == "") {
        $selectStaffCity = $city;
        $errorMsg = $errorMsg . "* Invalid Input for City\\n";

        $errorCheck = true;
    }
    if ($selectStaffPostcode == null || $selectStaffPostcode == "" || trim($selectStaffPostcode) == "") {
        $selectStaffPostcode = $postcode;
        $errorMsg = $errorMsg . "* Invalid Input for Postcode\\n";

        $errorCheck = true;
    }

    if ($errorCheck == false) {

        //get last staff
        $sql = "SELECT * FROM `staff` ORDER BY id DESC LIMIT 1";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            $lastID = $row["id"];
        }

        //new Username
        $lastID = $lastID + 1;
        $selectStaffUsername = "sta" . $lastID;
        //default password
        $defaultPassword = md5("default123");


        $sql = "INSERT INTO `staff`(`id`, `level`,`first name`, `second name`, `email`, `address`, `city`, `postcode`, `username`, `password`) VALUES ($lastID, '$selectStaffLevel', '$selectStaffFName', '$selectStaffSName', '$selectStaffEmail', '$selectStaffAddress', '$selectStaffCity', '$selectStaffPostcode', '$selectStaffUsername', '$defaultPassword')";
        $result = $conn->multi_query($sql);

        if (!$result === TRUE) {
            die("Error on insert" . $conn->error);
        }
        $error = "Staff Details Updated.Please make them aware of the default Password, and that they must change it immediately by logging in";
        echo "<script type='text/javascript'>alert('$error');</script>";

        $selectStaffID = "";
        $selectStaffFName = "";
        $selectStaffSName = "";
        $selectStaffUsername = "";
        $selectStaffEmail = "";
        $selectStaffAddress = "";
        $selectStaffCity = "";
        $selectStaffPostcode = "";
    } else {
        $error = "Please enter valid data\\n" . $errorMsg . "\\n Current Account will not be created.";
        echo "<script type='text/javascript'>alert('$error');</script>";

        $selectStaffID = "";
        $selectStaffFName = "";
        $selectStaffSName = "";
        $selectStaffUsername = "";
        $selectStaffEmail = "";
        $selectStaffAddress = "";
        $selectStaffCity = "";
        $selectStaffPostcode = "";
    }


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
    $errorreset = "Password reset to: default123\\nPlease advise staff to change the password immediately ";
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
                            <a href="EditStaffAccounts.php"><i class="fa fa-users fa-fw"></i> Staff Accounts</a>
                        </li>


                        <?php
                    }


                    ?>

                    <li>
                        <a href="EditCustomerAccounts.php"><i class="fa fa-users fa-fw"></i> Customer Accounts</a>
                    </li>
                    <li>
                        <a href="staffClasses.php"><i class="fa fa-tasks   fa-fw"></i> Classes</a>
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
                                    <form method="post" action="EditStaffAccounts.php">
                                        <input type="submit" value="Select" name="SelectedStaff"
                                               class="btn btn-outline btn-primary"
                                            <?php if ($userID == $row["id"]) {
                                                echo "disabled";
                                            } ?>/>
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
                                        <form method="post" action="EditStaffAccounts.php">
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
                                                    <input type="hidden" name="staffFNameStored"
                                                           value="<?php echo $selectStaffFName; ?>" placeholder="ID"/>
                                                </td>
                                                <td>
                                                    <input type="text" name="staffSName"
                                                           value="<?php echo $selectStaffSName; ?>"
                                                           placeholder="Second Name" required/>
                                                    <input type="hidden" name="staffSNameStored"
                                                           value="<?php echo $selectStaffSName; ?>" placeholder="ID"/>
                                                </td>
                                                <td>
                                                    <input type="text" name="staffUsername"
                                                           value="<?php echo $selectStaffUsername; ?>"
                                                           placeholder="Username" disabled/>
                                                    <input type="hidden" name="staffUsernameStored"
                                                           value="<?php echo $selectStaffUsername; ?>"
                                                           placeholder="ID"/>
                                                </td>
                                                <td>
                                                    <?php if (!isset($_POST["SelectStaff"]) && $isSelected == false) {
                                                        ?>
                                                        <select name="selectLevel" class="form-control">
                                                            <option>Admin</option>
                                                            <option>Employee</option>
                                                        </select>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <input type="text" name="staffLevel"
                                                               value="<?php echo $selectStaffLevel; ?>"
                                                               placeholder="Level" disabled/>
                                                        <input type="hidden" name="staffLevelStored"
                                                               value="<?php echo $selectStaffLevel; ?>"
                                                               placeholder="ID"/>

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
                                                    <input type="hidden" name="staffAddressStored"
                                                           value="<?php echo $selectStaffAddress; ?>" placeholder="ID"/>
                                                </td>
                                                <td>
                                                    <input type="text" name="staffCity"
                                                           value="<?php echo $selectStaffCity; ?>"
                                                           placeholder="City" required/>
                                                    <input type="hidden" name="staffCityStored"
                                                           value="<?php echo $selectStaffCity; ?>" placeholder="ID"/>
                                                </td>
                                                <td>
                                                    <input type="text" name="staffPostcode"
                                                           value="<?php echo $selectStaffPostcode; ?>"
                                                           placeholder="Postcode" required/>
                                                    <input type="hidden" name="staffPostcodeStored"
                                                           value="<?php echo $selectStaffPostcode; ?>"
                                                           placeholder="ID"/>
                                                </td>
                                                <td>
                                                    <input type="email" name="staffEmail"
                                                           value="<?php echo $selectStaffEmail; ?>"
                                                           placeholder="Email" required/>
                                                    <input type="hidden" name="staffEmailStored"
                                                           value="<?php echo $selectStaffEmail; ?>" placeholder="ID"/>
                                                </td>
                                                <td>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="submit" value="Update" name="StaffUpdate"
                                                           class="btn btn-outline btn-primary"
                                                        <?php if (!isset($_POST["SelectStaff"]) && $isSelected == false) {
                                                            echo "disabled";
                                                        } ?>/>
                                                </td>
                                                <td>
                                                    <input type="submit" value="Delete" name="StaffDelete"
                                                           class="btn btn-outline btn-danger"
                                                        <?php if (!isset($_POST["SelectStaff"]) && $isSelected == false) {
                                                            echo "disabled";
                                                        } ?>/>
                                                </td>
                                                <td>
                                                    <input type="submit" value="Reset Password" name="StaffReset"
                                                           class="btn btn-outline btn-warning"
                                                        <?php if (!isset($_POST["SelectStaff"]) && $isSelected == false) {
                                                            echo "disabled";
                                                        } ?>/>
                                                </td>
                                                <td>
                                                    <input type="submit" value="Create New Account" name="create"
                                                           class="btn btn-outline btn-success"
                                                        <?php if (isset($_POST["SelectStaff"]) || $isSelected == true) {
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
