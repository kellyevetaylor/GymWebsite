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

$userID = "";
$userID = $_SESSION['userId'];
$username = "";
$firstName = "";
$secondName = "";
$email = "";
$address = "";
$city = "";
$postcode = "";

//get user information
$sql = "SELECT * FROM `Gym Membership` WHERE `id` = $userID";// change to a variable
$result = $conn->query($sql);
$rowNum = $result->num_rows;

while ($row = $result->fetch_assoc()) {
    $username = $row["username"];
    $firstName = $row["first name"];
    $secondName = $row["second name"];
    $email = $row["email address"];
    $address = $row["address"];
    $city = $row["city"];
    $postcode = $row["postcode"];
}

$newFirstName = isset($_POST["firstName"]) ? cleanInput($_POST["firstName"]) : $firstName;
$newSecondName = isset($_POST["secondName"]) ? cleanInput($_POST["secondName"]) : $secondName;
$newEmail = isset($_POST["email"]) ? cleanInput($_POST["email"]) : $email;
$newAddress = isset($_POST["address"]) ? cleanInput($_POST["address"]) : $address;
$newCity = isset($_POST["city"]) ? cleanInput($_POST["city"]) : $city;
$newPostcode = isset($_POST["postcode"]) ? cleanInput($_POST["postcode"]) : $postcode;

$newPassword = isset($_POST["password"]) ? cleanInput($_POST["postcode"]) : $postcode;
$confirmPassword = isset($_POST["postcode"]) ? cleanInput($_POST["postcode"]) : $postcode;

if(isset($_POST["updateDetails"])){
    $userId = $_SESSION['userId'];

    $sql = "UPDATE `Gym Membership` SET `first name`= '$newFirstName',`second name`= '$newSecondName',`email address`= '$newEmail',`address`= '$newAddress',`city`= '$newCity',`postcode`='$newPostcode' WHERE `Gym Membership`.`id` = '$userId' ";
    $result= $conn->query($sql);
    if (!$result) {
        die("Query failed" . $conn->error);//get rid of error line
    }
    header("location:index.php");
}

if(isset($_POST["updatePassword"])){
    $userId = $_SESSION['userId'];


    $sql = "UPDATE `Gym Membership` SET `password`= '$newPassword' WHERE `Gym Membership`.`id` = '$userId' ";
    $result= $conn->query($sql);
    if (!$result) {
        die("Query failed" . $conn->error);//get rid of error line
    }
    header("location:index.php");
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
                <h1 class="page-header">Update Account Details</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-body">
                    <div class="col-lg-6">
                        <p>
                            Username:
                        </p>
                        <input name="username" value="<?php echo $username ?>" class="form-control" disabled>
                        <br/>
                        <p>
                            Current Password:
                        </p>
                        <input name="currentPassword" value="" placeholder="Current Password" class="form-control">
                        <br/>
                        <p>
                            New Password:
                        </p>
                        <input name="newPassword" value="" placeholder="New Password" class="form-control">
                        <br/>
                        <p>
                            Confirm New Password:
                        </p>
                        <input name="confirmNewPassword" value="" placeholder="Confirm New Password" class="form-control">
                        <br/>
                        <input type="submit" value="Update Password" class="btn btn-outline btn-primary"/>
                    </div>

                    <div class="col-lg-6">
                        <form method="post" action="updateAccount.php">
                        <p>
                            First Name:
                        </p>
                        <input name="firstName" value = "<?php echo $firstName; ?>" class="form-control">
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
                            <input type="submit" name="updateDetails" value="update" class="btn btn-outline btn-primary"/>
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

