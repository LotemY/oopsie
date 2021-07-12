<?php
include "config.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Assistant' rel='stylesheet'>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Oops!e</title>
</head>

<body>
    <div id="loginWrapper">
        <header id="loginHeader">
            <img src="./images/logo.png" alt="logo" title="logo">
            <h1>Welcome to Oops!e</h1>
        </header>
        <br><br>
        <form id="login" method="POST">
            <label>Email:<input type="email" name="email" require></label>
            <label>Password:<input type="password" name="password" require></label>
            <input type="submit" value="Login" />
        </form>
    </div>
    <?php
    $email = $_POST["email"] ?? null;
    $password = $_POST["password"] ?? null;
    if (!empty($email && $password)) {
        $query  = "SELECT * FROM tbl_228_users WHERE email='" . $email . "' and password = '" . $password . "'";
        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_array($result);
        if ($row) {
            header('Location: homePage.html');
        }
    }
    ?>
</body>

</html>