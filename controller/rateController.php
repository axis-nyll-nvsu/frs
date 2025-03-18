<?php
/*
 * Rate Controller
 * Description: Rate Controller
 * Author: Vernyll Jan P. Asis
 */

session_start();
require_once '../config/config.php';

class RateController {
    private $db;

    public function __construct() {
        $conn = new Connection();
        $this->db = $conn->getConnection();
    }

    public function addRate() {
        $user = $_SESSION['user_id'];
        $quota = $_POST['quota'];
        $base_salary = $_POST['base_salary'];
        $base_rate = $_POST['base_rate'];
        $addon_rate = $_POST['addon_rate'];

        $sql = "SELECT * FROM `frs_rates` WHERE `quota` = ? AND `base_salary` = ? AND `base_rate` = ? AND `addon_rate` = ? AND `deleted` != b'1'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$quota, $base_salary, $base_rate, $addon_rate]);

        if ($stmt->rowcount() > 0) {
            $_SESSION['error'] = 'Error: Rate values already exists!';
            echo "<script>window.location.href='../admin/rates.php';</script>";
        }
        else {
            $sqlinsert = "INSERT INTO `frs_rates`(`quota`, `base_salary`, `base_rate`, `addon_rate`, `created_by`) VALUES (?,?,?,?,?)";
            $statementinsert = $this->db->prepare($sqlinsert);
            $statementinsert->execute([$quota, $base_salary, $base_rate, $addon_rate, $user]);

            $description = "Added a new rate.";
            $sqlinsert = "INSERT INTO `frs_trail` (`user_id`, `description`) VALUES (?,?)";
            $statementinsert = $this->db->prepare($sqlinsert);
            $statementinsert->execute([$user, $description]);

            $_SESSION['success'] = 'Success: Rate values added!';
            echo "<script>window.location.href='../admin/rates.php';</script>";
        }
    }

    public function editRate() {
        $user = $_SESSION['user_id'];
        $rate = $_POST['rate_id'];

        $sqlupdate = "UPDATE `frs_rates` SET `is_default` = b'0'";
        $statementupdate = $this->db->prepare($sqlupdate);
        $statementupdate->execute();

        $sqlupdate = "UPDATE `frs_rates` SET `is_default` = b'1' WHERE `id` = ?";
        $statementupdate = $this->db->prepare($sqlupdate);
        $statementupdate->execute([$rate]);

        $description = "Set default salary rates.";
        $sqlinsert = "INSERT INTO `frs_trail` (`user_id`, `description`) VALUES (?,?)";
        $statementinsert = $this->db->prepare($sqlinsert);
        $statementinsert->execute([$user, $description]);

        $_SESSION['updated'] = 'Success: Default salary rates updated!';
        echo "<script>window.location.href='../admin/rates.php';</script>";
    }

    public function deleteRate() {
        $user = $_SESSION['user_id'];
        $rate = $_POST['rate_id'];

        $sqlupdate = "UPDATE `frs_rates` SET `deleted` = b'1', `updated_by` = ? WHERE `id` = ?";
        $statementupdate = $this->db->prepare($sqlupdate);
        $statementupdate->execute([$user, $rate]);

        $description = "Deleted rate.";
        $sqlinsert = "INSERT INTO `frs_trail` (`user_id`, `description`) VALUES (?,?)";
        $statementinsert = $this->db->prepare($sqlinsert);
        $statementinsert->execute([$user, $description]);

        $_SESSION['deleted'] = 'Success: Rate deleted!';
        echo "<script>window.location.href='../admin/rates.php';</script>";
    }
}

$controller = new RateController();

if (isset($_POST['add'])) $controller->addRate();
if (isset($_POST['edit'])) $controller->editRate();
if (isset($_POST['delete'])) $controller->deleteRate();