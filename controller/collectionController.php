<?php
/*
 * Collection Controller
 * Description: Collection Controller
 * Author: Vernyll Jan P. Asis
 */

session_start();
require_once '../config/config.php';

class CollectionController {
    private $db;

    public function __construct() {
        $conn = new Connection();
        $this->db = $conn->getConnection();
    }

    public function addOtherCollection() {
        $user = $_SESSION['user_id'];
        $date = date('Y-m-d',strtotime($_POST['date']));
        $receipt = $_POST['receipt'];
        $category = $_POST['category_id'];
        $amount = $_POST['amount'];

        $sql = "SELECT * FROM `frs_collections` WHERE `date` = ? AND `category_id` = ? AND `deleted` != b'1'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$date, $category]);

        if ($stmt->rowcount() > 0) {
            $_SESSION['error'] = 'error';
            echo "<script>window.location.href='../admin/collections.php';</script>";
        }
        else {
            $sqlinsert = "INSERT INTO `frs_collections`(`date`, `receipt`, `category_id`, `amount`, `created_by`) VALUES (?,?,?,?,?)";
            $statementinsert = $this->db->prepare($sqlinsert);
            $statementinsert->execute([$date, $receipt, $category, $amount, $user]);

            $description = "Added a new other collection.";
            $sqlinsert = "INSERT INTO `frs_audittrail` (`user_id`, `description`) VALUES (?,?)";
            $statementinsert = $this->db->prepare($sqlinsert);
            $statementinsert->execute([$user, $description]);

            $_SESSION['success'] = 'success';
            echo "<script>window.location.href='../admin/collections.php';</script>";
        }
    }

    public function editOtherCollection() {
        $user = $_SESSION['user_id'];
        $collection = $_POST['collection_id'];
        $date = date('Y-m-d',strtotime($_POST['date']));
        $receipt = $_POST['receipt'];
        $category = $_POST['category_id'];
        $amount = $_POST['amount'];

        $sql = "SELECT * FROM `frs_collections` WHERE `date` = ? AND `category_id` = ? AND `deleted` != b'1' AND `id` != ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$date, $category, $collection]);

        if ($stmt->rowcount() > 0) {
            $_SESSION['error'] = 'error';
            echo "<script>window.location.href='../admin/collections.php';</script>";
        }
        else {
            $sqlupdate = "UPDATE `frs_collections` SET `date` = ?, `receipt` = ?, `category_id` = ?, `amount` = ?, `updated_by` = ? WHERE `id` = ?";
            $statementupdate = $this->db->prepare($sqlupdate);
            $statementupdate->execute([$date, $receipt, $category, $amount, $user, $collection]);

            $description = "Updated other collection.";
            $sqlinsert = "INSERT INTO `frs_audittrail` (`user_id`, `description`) VALUES (?,?)";
            $statementinsert = $this->db->prepare($sqlinsert);
            $statementinsert->execute([$user, $description]);

            $_SESSION['updated'] = 'updated';
            echo "<script>window.location.href='../admin/collections.php';</script>";
        }
    }

    public function deleteOtherCollection() {
        $user = $_SESSION['user_id'];
        $collection = $_POST['collection_id'];

        $sqlupdate = "UPDATE `frs_collections` SET `deleted` = b'1', `updated_by` = ? WHERE `id` = ?";
        $statementupdate = $this->db->prepare($sqlupdate);
        $statementupdate->execute([$user, $collection]);

        $description = "Deleted other collection.";
        $sqlinsert = "INSERT INTO `frs_audittrail` (`user_id`, `description`) VALUES (?,?)";
        $statementinsert = $this->db->prepare($sqlinsert);
        $statementinsert->execute([$user, $description]);

        $_SESSION['deleted'] = 'deleted';
        echo "<script>window.location.href='../admin/collections.php';</script>";
    }
}

$controller = new CollectionController();

if (isset($_POST['add'])) $controller->addOtherCollection();
if (isset($_POST['edit'])) $controller->editOtherCollection();
if (isset($_POST['delete'])) $controller->deleteOtherCollection();