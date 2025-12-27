<?php
/*
 * Login Controller
 * Description: Login Controller
 * Author: Vernyll Jan P. Asis
 */

session_start();
require_once '../config/config.php';

class LoginController {
    private $db;

    public function __construct() {
        $conn = new Connection();
        $this->db = $conn->getConnection();
    }

    public function doLogin() {
        $email = $_POST['email'];
        $password = MD5($_POST['password']);

        $sql = "SELECT * FROM frs_users WHERE email = ? AND password = ?";
        $stmt = $this->db->prepare($sql);
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