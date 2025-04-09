<?php
/*
* Index
* Description: Index / Login View
* Author: Vernyll Jan P. Asis
*/

session_start();
if(isset($_SESSION['type'])) {
    header('location: ./dashboard.php');
}
date_default_timezone_set('Asia/Manila');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, shrink-to-fit=no, user-scalable=no">

    <link rel="stylesheet" href="../dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="icon" type="image/x-icon" href="../images/logo.png">
    <title>FNVTTC Financial Reporting System v2.0</title>
</head>
<body>
    <div class="container-fluid p-0">
        <div class="row m-0">
            <div class="col-lg-7 m-auto p-0">
                <div class="card bg-transparent p-3 border-0"  style="height: 90vh;display: grid;place-items: center;">
                    <form style="margin: auto;width: 400px;max-width: 100%;border: 1px solid rgba(0, 0, 0, 0.2);padding: 20px;border-radius: 10px;" method="POST" action="../controller/loginController.php">
                        <div style="display: flex; margin-bottom: 10px; place-items: center;">
                            <img src="../images/logo.png" style="height: 80px;">
                            <h3 style="margin: 10px; color: #00693e; font-size: 1em;">First Novo Vizcayano Travellers Transport Cooperative &mdash;<br />Financial Reporting System</div>
                            <div class="form-group">
                                <label>Email</label>
                                <div class="form-control pl-2 pr-2 p-0 d-flex" style="place-items:center;border: 2px solid rgba(0, 0, 0, 0.2);border-radius: 8px;">
                                    <input type="text" name="email" id="email" placeholder="Email" class="rounded w-100 h-100 border-0 bg-transparent" style="outline: none;">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <div class="form-control pl-2 pr-2 p-0 d-flex" style="place-items:center;border: 2px solid rgba(0, 0, 0, 0.2);border-radius: 8px;">
                                    <input id="password-field" type="password" name="password" placeholder="Password" class="rounded w-100 h-100 border-0 bg-transparent" style="outline: none;">
                                </div>
                            </div>
                            <p><a href="forgotpassword.php" class="axis-link">Forgot Password?</a></p>
                            <div class="form-group">
                                <div class="form-control p-0 border-0">
                                    <input type="submit" name="login" class="signin btn-lg text-white w-100 border-0" value="Login" style="outline: none;background-color: #00693e;border-radius: 8px;font-size: 1rem;" onclick="lsRememberMe()">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Scripts -->
    <script src="../dist/js/jquery-3.6.1.min.js"></script>
    <script src="../dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>