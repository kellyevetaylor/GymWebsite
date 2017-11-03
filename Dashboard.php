<!DOCTYPE html>
<html lang="en">
<head>

    <style>
        body {

            background-color: dimgrey;
        }

        h1 {
            text-align: center;
            color: dodgerblue;
            font-family: Courier;
            font-size: 50px;
            padding-top: 10%;
        }

        #GYM {
            padding-top: 10%;
            text-align: center;
            color: dodgerblue;
            text-decoration: underline;
            font-size: 65px;

        }

        input[type=submit] {

            color: dodgerblue;
            cursor: pointer;
            margin: 15px 20px;
            padding: 20px 20px;
            background-color: slategray;
            text-decoration: solid;
            font-size: 20px;
            border: none;
            width: 50%;

        }

        input[type=submit]:hover {
            color: whitesmoke;
        }

        p {
            text-align: center;

        }


    </style>
    <meta charset="UTF-8">
    <title>Dashboard</title>

</head>
<body>

<form>
    <h1 id="GYM">WAD Gym</h1>

    <div>

        <p id="myAccount">
            <input type="submit" value="My Account" formaction="MyAccount.php">
            <input id="diary" type="submit" value="Personal Diary" formaction="PersonalDiary.php">
            <input id=addAc type="submit" value="Add Activity" formaction="AddActivity.php">
            <input id=classes type="submit" value="Classes" formaction="Classes.php">
            <input id=Contact type="submit" value="Contact Information" formaction="Contact.php">
            <input id=Logout type="submit" value="Logout" formaction="index.php">


        </p>
    </div>


</form>


</body>
</html>