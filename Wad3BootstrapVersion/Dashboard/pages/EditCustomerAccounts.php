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

        if (firstName.value == "" || firstName.value == null||firstName.trim().length==0) {
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
            alert("Errors as follow:\n" + errMessage);
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
$isSelected = false;

//get user information
$sql = "SELECT * FROM `staff` WHERE `id` = $userID";// change to a variable
$result = $conn->query($sql);
$rowNum = $result->num_rows;

while ($row = $result->fetch_assoc()) {
    $level = $row["level"];
}

$selectID = ""; //Check
$selectFName =  "";
$selectSName =  "";
$selectUsername = "";
$selectEmail = "";
$selectAddress ="";
$selectCity = "";
$selectPostcode ="";








if (isset($_POST["createUser"])) {

    $lastID = "";


    $selectID = safePost($conn, "custID");
    $selectUsername = safePost($conn, "custUsername");
    $selectFName = safePost($conn, "custFName");
    $selectSName = safePost($conn, "custSName");
    $selectEmail = safePost($conn, "custEmail");
    $selectAddress = safePost($conn, "custAddress");
    $selectCity = safePost($conn, "custCity");
    $selectPostcode = safePost($conn, "custPostcode");
    $defaultPassword = md5("default123");

    $sql = "SELECT * FROM `Gym Membership` ORDER BY id DESC LIMIT 1";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $lastID = $row["id"];
    }

    //new Username
    $lastID = $lastID + 1;

    if ($selectFName == null || $selectFName == "" ||
        $selectSName == null || $selectSName == "" ||
        $selectEmail == null || $selectEmail == "" ||
        $selectAddress == null || $selectAddress == "" ||
        $selectCity == null || $selectCity == "" ||
        $selectPostcode == null || $selectPostcode == ""
        || strlen($selectFName) == 0|| strlen($selectSName) == 0|| strlen($selectEmail) == 0
        || strlen($selectAddress) == 0|| strlen($selectCity) == 0||strlen($selectPostcode) == 0) {

        $error = "Please enter valid data";
        echo "<script type='text/javascript'>alert('$error');</script>";
        $selectID = "";
        $selectFName =  "";
        $selectSName =  "";
        $selectUsername = "";
        $selectEmail = "";
        $selectAddress ="";
        $selectCity = "";
        $selectPostcode ="";

    } else {


        //creating the account
        $sql = "INSERT INTO `userClasses` (`UserID`, `class1`, `class2`, `class3`, `class4`, `class5`) VALUES ($lastID, 0 , 0 ,0 ,0 ,0 );";
        $conn->multi_query($sql);

        $password = md5($password);
        $sql = "INSERT INTO `Gym Membership`(`id`, `first name`, `second name`, `email address`, `address`, `city`, `postcode`, `username`, `password`) VALUES ($lastID, '$selectFName', '$selectSName', '$selectEmail', '$selectAddress', '$selectCity', '$selectPostcode', '$selectUsername', '$defaultPassword')";
        $result = $conn->multi_query($sql);

        if (!$result === TRUE) {
            die("Error on insert" . $conn->error);
        }
        $error = "Customer Account Created:\nPlease make them aware of the default Password(default123)\n This must be changed immediately by logging in";
        echo "<script type='text/javascript'>alert('$error');</script>";

        $selectID = "";
        $selectFName =  "";
        $selectSName =  "";
        $selectUsername = "";
        $selectEmail = "";
        $selectAddress ="";
        $selectCity = "";
        $selectPostcode ="";

    }


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


if (isset($_POST["update"])) {


    $selectID = isset($_POST["custID"]) ? cleanInput($_POST["custID"]) : "";
    $selectFName = isset($_POST["custFName"]) ? cleanInput($_POST["custFName"]) : "";
    $selectSName = isset($_POST["custSName"]) ? cleanInput($_POST["custSName"]) : "";
    $selectEmail = isset($_POST["custEmail"]) ? cleanInput($_POST["custEmail"]) : "";
    $selectAddress = isset($_POST["custAddress"]) ? cleanInput($_POST["custAddress"]) : "";
    $selectCity = isset($_POST["custCity"]) ? cleanInput($_POST["custCity"]) : "";
    $selectPostcode = isset($_POST["custPostcode"]) ? cleanInput($_POST["custPostcode"]) : "";


    $selectID       = safePost($conn, "custID");
    $selectFName    = safePost($conn, "custFName");
    $selectSName    = safePost($conn, "custSName");
    $selectEmail    = safePost($conn, "custEmail");
    $selectAddress  = safePost($conn, "custAddress");
    $selectCity     = safePost($conn, "custCity");
    $selectPostcode = safePost($conn, "custPostcode");

    $errorMessage = "";
   // $selectUsername= $_POST["custUsername"];

    if ($selectFName==null||$selectFName==""||trim($selectFName) == "") {
        $errorMessage = $errorMessage . " * Invalid Input for First Name\\n";

    }
    if (trim($selectSName) == "") {
        $errorMessage = $errorMessage . " * Invalid Input for Surname\\n";


    }
    if (trim($selectEmail) == "") {
        $errorMessage = $errorMessage . " * Invalid Input for Email\\n";


    }
    if (trim($selectAddress) == "") {
        $errorMessage = $errorMessage . " * Invalid Input for Address\\n";


    }
    if (trim($selectCity) == "") {
        $errorMessage = $errorMessage . " * Invalid Input for City\\n";


    }
    if (trim($selectPostcode) == "") {
        $errorMessage = $errorMessage . " * Invalid Input for Postcode\\n";
    }



    if ($errorMessage == "") {

        //set staff information
        $sql = "UPDATE `Gym Membership` SET `first name`= '$selectFName',`second name`= '$selectSName',`email address`= '$selectEmail',`address`= '$selectAddress',`city`= '$selectCity',`postcode`='$selectPostcode' WHERE `id` = '$selectID' ";
        $result = $conn->query($sql);
        if (!$result) {
            die("Query failed" . $conn->error);//get rid of error line
        }
        $error = "Customer Details Updated.";
        echo "<script type='text/javascript'>alert('$error');</script>";


        $selectID = ""; //Check
        $selectFName =  "";
        $selectSName =  "";
        $selectUsername = "";
        $selectEmail = "";
        $selectAddress ="";
        $selectCity = "";
        $selectPostcode ="";


        $isSelected = false;

    } else {
        $errorMessage = $errorMessage."\\n New changes will not be applied\\n";


        $selectID = $_POST["custID"];
        $selectFName = $_POST["FNameStored"];
        $selectSName = $_POST["SNameStored"];
        $selectCity = $_POST["CityStored"];
        $selectAddress = $_POST["AddressStored"];
        $selectPostcode = $_POST["PostcodeStored"];
        $selectEmail = $_POST["EmailStored"];


        echo "<script type='text/javascript'>alert('$errorMessage');</script>";
        $isSelected = true;

    }


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
        $selectUsername = $row["username"];
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
                        <a href="staffClasses.php"><i class="fa fa-tasks fa-fw"></i> Classes</a>
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
                                $sql = "SELECT * FROM `Gym Membership`";
                                $result = $conn->query($sql);
                                $rowNum = $result->num_rows;

                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr class=\"odd gradeX\">";
                                    echo "<form method=\"post\" action=\"EditCustomerAccounts.php\">";
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
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <form method="post" action="EditCustomerAccounts.php" name=updateCustDetails
                                              onsubmit="validateUpdateDetails()">
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
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="text" value="<?php echo $selectID; ?>"
                                                           placeholder="ID" disabled/>
                                                    <input type="hidden" name="custID" value="<?php echo $selectID; ?>"
                                                           placeholder="ID" required/>
                                                </td>
                                                <td>
                                                    <input type="text" name="custFName"
                                                           value="<?php echo $selectFName; ?>"
                                                           placeholder="First Name" required/>
                                                    <input type="hidden" name="FNameStored" value="<?php echo $selectFName; ?>"
                                                           placeholder="ID" required/>
                                                </td>
                                                <td>
                                                    <input type="text" name="custSName"
                                                           value="<?php echo $selectSName; ?>"
                                                           placeholder="Second Name" required/>
                                                    <input type="hidden" name="SNameStored" value="<?php echo $selectSName; ?>"
                                                           placeholder="ID" required/>
                                                </td>
                                                <td>
                                                    <input type="text" name="custUsername"
                                                           value="<?php echo $selectUsername; ?>"
                                                           placeholder="Username"
                                                        <?php if (isset($_POST["SelectCust"]) || $isSelected == true) {
                                                            echo "disabled";
                                                        } ?>/>
                                                </td>
                                                <td></td>
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
                                                    <input type="text" name="custAddress" required
                                                           value="<?php echo $selectAddress; ?>" placeholder="Address"/>
                                                    <input type="hidden" name="AddressStored" value="<?php echo $selectAddress; ?>"
                                                           placeholder="ID" required/>
                                                </td>
                                                <td>
                                                    <input type="text" name="custCity"
                                                           value="<?php echo $selectCity; ?>"
                                                           placeholder="City" required/>
                                                    <input type="hidden" name="CityStored" value="<?php echo $selectCity; ?>"
                                                           placeholder="ID" required/>
                                                </td>
                                                <td>
                                                    <input type="text" name="custPostcode" required
                                                           value="<?php echo $selectPostcode; ?>" placeholder="Postcode"/>
                                                    <input type="hidden" name="PostcodeStored" value="<?php echo $selectPostcode; ?>"
                                                           required/>
                                                </td>
                                                <td>
                                                    <input type="email" name="custEmail"
                                                           value="<?php echo $selectEmail; ?>"
                                                           placeholder="Email"/>
                                                    <input type="hidden" name="EmailStored" value="<?php echo $selectEmail; ?>"
                                                           placeholder="ID" required/>
                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="submit" value="Update" name="update"
                                                           class="btn btn-outline btn-primary"
                                                        <?php if (!isset($_POST["SelectCust"]) && $isSelected == false) {
                                                            echo "disabled";
                                                        } ?>/>
                                                </td>
                                                <td>
                                                    <input type="submit" value="Delete" name="delete"
                                                           class="btn btn-outline btn-danger"
                                                        <?php if (!isset($_POST["SelectCust"]) && $isSelected == false) {
                                                            echo "disabled";
                                                        } ?>/>
                                                </td>
                                                <td>
                                                    <input type="submit" value="Reset Password" name="reset"
                                                           class="btn btn-outline btn-warning"
                                                        <?php if (!isset($_POST["SelectCust"])&& $isSelected == false) {
                                                            echo "disabled";
                                                        } ?>/>
                                                </td>
                                                <td>

                                                    <input type="submit" value="Create New Account" name="createUser"
                                                           class="btn btn-outline btn-success"
                                                        <?php if (isset($_POST["SelectCust"])|| $isSelected == true) {
                                                            echo "disabled";
                                                        } ?> />
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
                        <!-- /.panel -->
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
