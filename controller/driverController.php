<?php
/*
 * Driver Controller
 * Description: Driver Controller
 * Author: Vernyll Jan P. Asis
 */

session_start();
require_once '../config/config.php';

class DriverController {
    private $db;

    public function __construct() {
        $conn = new Connection();
        $this->db = $conn->getConnection();
    }

    public function addDriver() {
        $user = $_SESSION['user_id'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $address = $_POST['address'];
        $contact = $_POST['contact'];

        $sql = "SELECT * FROM `frs_drivers` WHERE `first_name` = ? AND `last_name` = ? AND `deleted` != b'1'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$firstname, $lastname]);

        if ($stmt->rowcount() > 0) {
            $_SESSION['error'] = 'Error: Driver already exists! Use a different name.';
            echo "<script>window.location.href='../admin/drivers.php';</script>";
        }
        else {
            $sqlinsert = "INSERT INTO `frs_drivers`(`first_name`, `last_name`, `address`, `contact`, `created_by`) VALUES (?,?,?,?,?)";
            $statementinsert = $this->db->prepare($sqlinsert);
            $statementinsert->execute([$firstname, $lastname, $address, $contact, $user]);

            $description = "Added a new driver.";
            $sqlinsert = "INSERT INTO `frs_trail` (`user_id`, `description`) VALUES (?,?)";
            $statementinsert = $this->db->prepare($sqlinsert);
            $statementinsert->execute([$user, $description]);

            $_SESSION['success'] = 'Success: Driver added!';
            echo "<script>window.location.href='../admin/drivers.php';</script>";
        }
    }

    public function editDriver() {
        $user = $_SESSION['user_id'];
        $driver = $_POST['driver_id'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $address = $_POST['address'];
        $contact = $_POST['contact'];

        $sql = "SELECT * FROM `frs_drivers` WHERE `first_name` = ? AND `last_name` = ? AND `deleted` != b'1' AND `id` != ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$firstname, $lastname, $driver]);

        if ($stmt->rowcount() > 0) {
            $_SESSION['error'] = "Error: Driver already exists! Use a different name.";
            echo "<script>window.location.href='../admin/drivers.php';</script>";
        }
        else {
            $sqlupdate = "UPDATE `frs_drivers` SET `first_name` = ?, `last_name` = ?, `address` = ?, `contact` = ?, `updated_by` = ? WHERE `id` = ?";
            $statementupdate = $this->db->prepare($sqlupdate);
            $statementupdate->execute([$firstname, $lastname, $address, $contact, $user, $driver]);

            $description = "Updated driver.";
            $sqlinsert = "INSERT INTO `frs_trail` (`user_id`, `description`) VALUES (?,?)";
            $statementinsert = $this->db->prepare($sqlinsert);
            $statementinsert->execute([$user, $description]);

            $_SESSION['updated'] = 'Success: Driver updated!';
            echo "<script>window.location.href='../admin/drivers.php';</script>";
        }
    }

    public function deleteDriver() {
        $user = $_SESSION['user_id'];
        $driver = $_POST['driver_id'];

        $sqlupdate = "UPDATE `frs_drivers` SET `deleted` = b'1', `updated_by` = ? WHERE `id` = ?";
        $statementupdate = $this->db->prepare($sqlupdate);
        $statementupdate->execute([$user, $driver]);

        $description = "Deleted driver.";
        $sqlinsert = "INSERT INTO `frs_trail` (`user_id`, `description`) VALUES (?,?)";
        $statementinsert = $this->db->prepare($sqlinsert);
        $statementinsert->execute([$user, $description]);

        $_SESSION['deleted'] = 'Success: Driver deleted!';
        echo "<script>window.location.href='../admin/drivers.php';</script>";
    }
}

$controller = new DriverController();

if (isset($_POST['add'])) $controller->addDriver();
if (isset($_POST['edit'])) $controller->editDriver();
if (isset($_POST['delete'])) $controller->deleteDriver();