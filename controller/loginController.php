<?php
/*
 * loginController.php
 * Description: Login Controller
 * Author: 
 * Modified: 11-28-2024
 */

session_start();
include '../config/config.php';

class LoginController extends Connection {
  public function doLogin() {
    $email = $_POST['email'];
    $password = MD5($_POST['password']);

    $sql = "SELECT * FROM frs_users WHERE email = ? AND password = ?";
    $stmt = $this->conn()->prepare($sql);
    $stmt->execute([$email, $password]);

    if ($stmt->rowcount() > 0) {
      $row = $stmt->fetch();
      if ($password = $row['password']) {
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['type'] = $row['type'];
        header('location:../admin/dashboard.php');
      }
      else {
      echo "<script type='text/javascript'>alert('Invalid Username and Password');</script>";
      echo "<script>window.location.href='../admin/';</script>";
      }
    }
    else {
      echo "<script type='text/javascript'>alert('Invalid Username and Password');</script>";
      echo "<script>window.location.href='../admin/';</script>";
    }
  }
}

$controller = new LoginController();

if (isset($_POST['login'])) $controller->doLogin();