<?php
/*
 * accountController.php
 * Description: Driver Controller
 * Author: 
 * Modified: 12-27-2024
 */

session_start();
include '../config/config.php';

class AccountController extends Connection {
  public function addAccount() {
    $user = $_SESSION['user_id'];
    $type = $_POST['type'];
    $email = $_POST['email'];
    $password = MD5($_POST['password']);
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];

    $img = 'default.png';
    if($_FILES['img']['name'] != "") {
        $img = $_FILES['img']['name'];
        move_uploaded_file($_FILES['img']['tmp_name'], "../images/".$img);
    }

    $sql = "SELECT * FROM `frs_users` WHERE (`first_name` = ? AND `middle_name` = ? AND `last_name` = ? AND `deleted` != b'1') OR `email` = ?";
    $stmt = $this->conn()->prepare($sql);
    $stmt->execute([$firstname, $middlename, $lastname, $email]);

    if ($stmt->rowcount() > 0) {
      $_SESSION['error'] = 'error';
      echo "<script>window.location.href='../admin/accounts.php';</script>";
    }
    else {
      $sqlinsert = "INSERT INTO `frs_users`(`first_name`, `middle_name`, `last_name`, `email`, `password`, `type`, `image`, `address`, `contact`) VALUES (?,?,?,?,?,?,?,?,?)";
      $statementinsert = $this->conn()->prepare($sqlinsert);
      $statementinsert->execute([$firstname, $middlename, $lastname, $email, $password, $type, $img, $address, $contact]);

      $description = "Added a new account.";
      $sqlinsert = "INSERT INTO `frs_audittrail` (`user_id`, `description`) VALUES (?,?)";
      $statementinsert = $this->conn()->prepare($sqlinsert);
      $statementinsert->execute([$user, $description]);

      $_SESSION['success'] = 'success';
      echo "<script>window.location.href='../admin/accounts.php';</script>";
    }
  }
  
  public function editAccount() {
    $user = $_SESSION['user_id'];
    $account = $_POST['account_id'];

    $sql = "SELECT * FROM `frs_users` WHERE `id` = ?";
    $stmt = $this->conn()->prepare($sql);
    $stmt->execute([$account]);
    $row = $stmt->fetch();

    $type = $_POST['type'];
    $email = $_POST['email'];
    $password = ($_POST['password'] != "") ? MD5($_POST['password']) : $row['password'];
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];

    $img = $row['image'];
    if($_FILES['img']['name'] != "") {
        $img = $_FILES['img']['name'];
        move_uploaded_file($_FILES['img']['tmp_name'], "../images/".$img);
    }

    $sql = "SELECT * FROM `frs_users` WHERE ((`first_name` = ? AND `middle_name` = ? AND `last_name` = ? AND `deleted` != b'1') OR `email` = ?) AND `id` != ?";
    $stmt = $this->conn()->prepare($sql);
    $stmt->execute([$firstname, $middlename, $lastname, $email, $account]);

    if ($stmt->rowcount() > 0) {
      $_SESSION['error'] = 'error';
      echo "<script>window.location.href='../admin/accounts.php';</script>";
    }
    else {
      $sqlupdate = "UPDATE `frs_users` SET `first_name` = ?, `middle_name` = ?, `last_name` = ?, `email` = ?, `password` = ?, `type` = ?, `image` = ?, `address` = ?, `contact` = ? WHERE `id` = ?";
      $statementupdate = $this->conn()->prepare($sqlupdate);
      $statementupdate->execute([$firstname, $middlename, $lastname, $email, $password, $type, $img, $address, $contact, $account]);

      $description = "Updated account.";
      $sqlinsert = "INSERT INTO `frs_audittrail` (`user_id`, `description`) VALUES (?,?)";
      $statementinsert = $this->conn()->prepare($sqlinsert);
      $statementinsert->execute([$user, $description]);

      $_SESSION['updated'] = 'updated';
      echo "<script>window.location.href='../admin/accounts.php';</script>";
    }
  }
  
  public function deleteAccount() {
    $user = $_SESSION['user_id'];
    $account = $_POST['account_id'];

    $sqlupdate = "UPDATE `frs_users` SET `deleted` = b'1' WHERE `id` = ?";
    $statementupdate = $this->conn()->prepare($sqlupdate);
    $statementupdate->execute([$account]);

    $description = "Deleted account.";
    $sqlinsert = "INSERT INTO `frs_audittrail` (`user_id`, `description`) VALUES (?,?)";
    $statementinsert = $this->conn()->prepare($sqlinsert);
    $statementinsert->execute([$user, $description]);

    $_SESSION['deleted'] = 'deleted';
    echo "<script>window.location.href='../admin/accounts.php';</script>";
  }
}

$controller = new AccountController();

if (isset($_POST['add'])) $controller->addAccount();
if (isset($_POST['edit'])) $controller->editAccount();
if (isset($_POST['delete'])) $controller->deleteAccount();