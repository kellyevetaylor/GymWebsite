<?php
/**
 * Created by IntelliJ IDEA.
 * User: pavindersingh
 * Date: 16/11/2017
 * Time: 23:29
 */ ?>
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
    if (empty($_SESSION['isStaff'])) {
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

    <script>

        function validateUpdateDetails() {
            var firstName = document.forms["updateDetails"]["firstName"];
            var secondName = document.forms["updateDetails"]["secondName"];
            var email = document.forms["updateDetails"]["email"];
            var address = document.forms["updateDetails"]["address"];
            var city = document.forms["updateDetails"]["city"];
            var postcode = document.forms["updateDetails"]["postcode"];


            var errMessage = "";

            if (firstName.value == "" || firstName.value == null||firstName.value.trim().length==0 ) {
                errMessage += " * Please enter your first name\n";

            }

            if (secondName.value == null || secondName.value == ""||secondName.value.trim().length==0 ) {
                errMessage += " * Please enter your surname\n";

            }
            if (email.value == "" || email.value == null||email.value.trim().length==0 ) {
                errMessage += " * Please enter your email\n";

            }
            if (address.value == "" || address.value == null||address.value.trim().length==0 ) {
                errMessage += " * Please enter your address\n";

            }
            if (city.value == "" || city.value == null||city.value.trim().length==0 ) {
                errMessage += " * Please enter a city\n";

            }
            if (postcode.value == "" || postcode.value == null||postcode.value.trim().length==0 ) {
                errMessage += " * Please enter your postcode\n";

            }
            if (errMessage != "") {
                alert("Errors as follow:\n" + errMessage);
            }
        }



        function validateInputForm() {
            var currentPassword = document.forms["updateForm"]["currentPassword"];
            var newPassword1 = document.forms["updateForm"]["newPassword1"];
            var newPassword2 = document.forms["updateForm"]["newPassword2"];

            var message = "";

            //still need to check against help password

            if (currentPassword.value == null || currentPassword.value == ""||currentPassword.value.trim().length==0) {
                message += " * Please enter your old password\n";
            }

            if(newPassword1.value.trim().length==0||newPassword2.value.trim().length==0) {

                message =+ " * Please enter value for new password";
            }else{

                if (newPassword1.value != newPassword2.value) {
                    message += " * New passwords don't match\n";
                } else if (newPassword1.value == "" || newPassword2.value == "") {
                    message += " * New password must be stronger\n";
                }

                if (currentPassword.value == newPassword1.value) {
                    message += "* New password must be different from original."
                }
            }


            if (message != "") {
                alert("Errors as follow:\n" + message);
            }
        }
        </scrip
    </script>


</head>

<body>

<?php
//connects to database
$host = "devweb2017.cis.strath.ac.uk";
$user = "cs312_a";
$password = "Thi0Eiwophe3";
$dbname = "cs312_a";
$conn = new mysqli($host, $user, $password, $dbname);

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

$userID = "";
$userID = $_SESSION['userId'];
$username = "";
$level = "";
$firstName = "";
$secondName = "";
$email = "";
$address = "";
$city = "";
$postcode = "";
$passwordError = "";

//get user information
$sql = "SELECT * FROM `staff` WHERE `id` = $userID";// change to a variable
$result = $conn->query($sql);
$rowNum = $result->num_rows;

while ($row = $result->fetch_assoc()) {
    $username = $row["username"];
    $level = $row["level"];
    $firstName = $row["first name"];
    $secondName = $row["second name"];
    $email = $row["email"];
    $address = $row["address"];
    $city = $row["city"];
    $postcode = $row["postcode"];
    $currentPasswordStored = $row["password"];
}

$newFirstName = isset($_POST["firstName"]) ? cleanInput($_POST["firstName"]) : $firstName;
$newSecondName = isset($_POST["secondName"]) ? cleanInput($_POST["secondName"]) : $secondName;
$newEmail = isset($_POST["email"]) ? cleanInput($_POST["email"]) : $email;
$newAddress = isset($_POST["address"]) ? cleanInput($_POST["address"]) : $address;
$newCity = isset($_POST["city"]) ? cleanInput($_POST["city"]) : $city;
$newPostcode = isset($_POST["postcode"]) ? cleanInput($_POST["postcode"]) : $postcode;

$newFirstName = safePost($conn, "firstName");
$newSecondName = safePost($conn, "secondName");
$newEmail = safePost($conn, "email");
$newAddress = safePost($conn, "address");
$newCity = safePost($conn, "city");
$newPostcode = safePost($conn, "postcode");


if (isset($_POST["updateDetails"])) {

    if ($newFirstName == null || $newFirstName == ""|| trim($newFirstName)=="") {
        $newFirstName = $firstName;
    }

    if ($newSecondName == null || $newSecondName == "") {
        $newSecondName = $secondName;
    }
    if ($newEmail == null || $newEmail == "") {
        $newEmail = $email;
    }
    if ($newAddress == null || $newAddress == "") {
        $newAddress = $address;
    }
    if ($newCity == null || $newCity == "") {
        $newCity = $city;
    }
    if ($newPostcode == null || $newPostcode == "") {
        $newPostcode = $postcode;
    }
    $userId = $_SESSION['userId'];

    $sql = "UPDATE `staff` SET `first name`= '$newFirstName',`second name`= '$newSecondName',`email`= '$newEmail',`address`= '$newAddress',`city`= '$newCity',`postcode`='$newPostcode' WHERE `staff`.`id` = '$userId' ";
    $result = $conn->query($sql);

    if (!$result) {
        die("Query failed" . $conn->error);//get rid of error line
    }
    //  header("location:indexStaff.php");


    $updateSuccess = "Update complete";
    echo "<script>
     type='text/javascript'>alert('$updateSuccess');
     window.location.href='indexStaff.php';
    </script> ";

}

if (isset($_POST["updatePassword"])) {


    $newPassword1 = isset($_POST["newPassword1"]) ? cleanInput($_POST["newPassword1"]) : "";
    $newPassword2 = isset($_POST["newPassword2"]) ? cleanInput($_POST["newPassword2"]) : "";
    $currentPassword = isset($_POST["currentPassword"]) ? cleanInput($_POST["currentPassword"]) : "";

    $newPassword1 = safePost($conn, "newPassword1");
    $newPassword2 = safePost($conn, "newPassword2");
    $currentPassword = safePost($conn, "currentPassword");

    if ($currentPasswordStored != md5($newPassword1)) {
        if (md5($newPassword1) == md5($newPassword2) && (md5($currentPassword) == $currentPasswordStored)) {
            $newPassword1 = md5($newPassword1);
            $userId = $_SESSION['userId'];
            $sql = "UPDATE `staff` SET `password` = '$newPassword1' WHERE id = \"$userId\"";
            $conn->query($sql);
            $updateSuccess = "Update complete";
            echo "<script>
     type='text/javascript'>alert('$updateSuccess');
     window.location.href='indexStaff.php';
    </script> ";
        }
    } elseif($currentPasswordStored != md5($currentPassword)){

        $loginError = "Current password does not match our records";
        echo "<script type='text/javascript'>alert('$loginError');</script>";
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
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Update Account Details</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-body">
                    <div class="col-lg-6">
                        <form name="updateForm" method="post" action="updateStaff.php" onsubmit="validateInputForm()">
                            <p>
                                Username:
                            </p>
                            <input name="username" value="<?php echo $username ?>" class="form-control" disabled>
                            <br/>
                            <p>
                                Current Password:
                            </p>
                            <input name="currentPassword" value="" type = password
                                   placeholder="Current Password" class="form-control">
                            <br/>
                            <p>
                                New Password:
                            </p>
                            <input name="newPassword1" value="" placeholder="New Password" type = password class="form-control">
                            <br/>
                            <p>
                                Confirm New Password:
                            </p>
                            <input name="newPassword2" value="" type = password
                                   placeholder="Confirm New Password"
                                   class="form-control">
                            <br/>
                            <input type="submit" value="Update Password" name="updatePassword"
                                   class="btn btn-outline btn-primary"/>
                    </div>
                    </form>

                    <div class="col-lg-6">
                        <form method="post" name="updateDetails" action="updateStaff.php" onsubmit="validateUpdateDetails()">
                            <p>
                                Level:
                            </p>
                            <input name="level" value="<?php echo $level; ?>" class="form-control" disabled>
                            <br/>
                            <p>
                                First Name:
                            </p>
                            <input name="firstName" value="<?php echo $firstName; ?>" class="form-control">
                            <br/>
                            <p>
                                Second Name:
                            </p>
                            <input name="secondName" value="<?php echo $secondName ?>" class="form-control">
                            <br/>
                            <p>
                                Email Address:
                            </p>
                            <input name="email" type="email" value="<?php echo $email ?>" class="form-control">
                            <br/>
                            <p>
                                Address:
                            </p>
                            <input name="address" value="<?php echo $address ?>" class="form-control">
                            <br/>
                            <p>
                                City:
                            </p>
                            <input name="city" value="<?php echo $city ?>" class="form-control">
                            <br/>
                            <p>
                                PostCode:
                            </p>
                            <input name="postcode" value="<?php echo $postcode ?>" class="form-control">
                            <br/>
                            <input type="submit" name="updateDetails" value="update"
                                   class="btn btn-outline btn-primary"/>
                        </form>
                    </div>
                </div>
            </div>
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

