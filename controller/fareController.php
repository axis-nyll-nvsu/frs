<?php
/*
 * Fare Controller
 * Description: Fare Controller
 * Author: Vernyll Jan P. Asis
 */

session_start();
require_once '../config/config.php';

class FareController {
    private $db;

    public function __construct() {
        $conn = new Connection();
        $this->db = $conn->getConnection();
    }

    public function addFareCollection() {
        $user = $_SESSION['user_id'];
        $date = date('Y-m-d',strtotime($_POST['date']));
        $driver = $_POST['driver_id'];
        $terminal = $_POST['terminal_id'];
        $amount = $_POST['amount'];

        $sql = "SELECT * FROM `frs_fares` WHERE `date` = ? AND `driver_id` = ? AND `deleted` != b'1'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$date, $driver]);

        if ($stmt->rowcount() > 0) {
            $_SESSION['error'] = 'error';
            echo "<script>window.location.href='../admin/fares.php';</script>";
        }
        else {
            $sqlinsert = "INSERT INTO `frs_fares`(`date`, `driver_id`, `terminal_id`, `amount`, `created_by`) VALUES (?,?,?,?,?)";
            $statementinsert = $this->db->prepare($sqlinsert);
            $statementinsert->execute([$date, $driver, $terminal, $amount, $user]);

            $description = "Added a new fare collection.";
            $sqlinsert = "INSERT INTO `frs_audittrail` (`user_id`, `description`) VALUES (?,?)";
            $statementinsert = $this->db->prepare($sqlinsert);
            $statementinsert->execute([$user, $description]);

            $_SESSION['success'] = 'success';
            echo "<script>window.location.href='../admin/fares.php';</script>";
        }
    }

    public function editFareCollection() {
        $user = $_SESSION['user_id'];
        $fare = $_POST['fare_id'];
        $date = date('Y-m-d',strtotime($_POST['date']));
        $amount = $_POST['amount'];

        $sql = "SELECT * FROM `frs_fares` WHERE `date` = ? AND `driver_id` = ? AND `deleted` != b'1' AND `id` != ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$date, $driver, $fare]);

        if ($stmt->rowcount() > 0) {
            $_SESSION['error'] = 'error';
            echo "<script>window.location.href='../admin/fares.php';</script>";
        }
        else {
            $sqlupdate = "UPDATE `frs_fares` SET `date` = ?, `amount` = ?, `updated_by` = ? WHERE `id` = ?";
            $statementupdate = $this->db->prepare($sqlupdate);
            $statementupdate->execute([$date, $amount, $user, $fare]);

            $description = "Updated fare collection.";
            $sqlinsert = "INSERT INTO `frs_audittrail` (`user_id`, `description`) VALUES (?,?)";
            $statementinsert = $this->db->prepare($sqlinsert);
            $statementinsert->execute([$user, $description]);

            $_SESSION['updated'] = 'updated';
            echo "<script>window.location.href='../admin/fares.php';</script>";
        }
    }

    public function deleteFareCollection() {
        $user = $_SESSION['user_id'];
        $fare = $_POST['fare_id'];

        $sqlupdate = "UPDATE `frs_fares` SET `deleted` = b'1', `updated_by` = ? WHERE `id` = ?";
        $statementupdate = $this->db->prepare($sqlupdate);
        $statementupdate->execute([$user, $fare]);

        $description = "Deleted fare collection.";
        $sqlinsert = "INSERT INTO `frs_audittrail` (`user_id`, `description`) VALUES (?,?)";
        $statementinsert = $this->db->prepare($sqlinsert);
        $statementinsert->execute([$user, $description]);

        $_SESSION['deleted'] = 'deleted';
        echo "<script>window.location.href='../admin/fares.php';</script>";
    }
}

$controller = new FareController();

if (isset($_POST['add'])) $controller->addFareCollection();
if (isset($_POST['edit'])) $controller->editFareCollection();
if (isset($_POST['delete'])) $controller->deleteFareCollection();