<?php
/*
 * E-Jeep Controller
 * Description: E-Jeep Controller
 * Author: Vernyll Jan P. Asis
 */

session_start();
require_once '../config/config.php';

class EjeepController {
    private $db;

    public function __construct() {
        $conn = new Connection();
        $this->db = $conn->getConnection();
    }

    public function addEjeep() {
        $user = $_SESSION['user_id'];
        $plate = $_POST['plate'];

        $sql = "SELECT * FROM `frs_ejeeps` WHERE `plate` = ? AND `deleted` != b'1'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$plate]);

        if ($stmt->rowcount() > 0) {
            $_SESSION['error'] = 'Error: E-Jeep already exists! Use a different name.';
            echo "<script>window.location.href='../admin/ejeeps.php';</script>";
        }
        else {
            $sqlinsert = "INSERT INTO `frs_ejeeps`(`plate`, `created_by`) VALUES (?,?)";
            $statementinsert = $this->db->prepare($sqlinsert);
            $statementinsert->execute([$plate, $user]);

            $description = "Added a new e-jeep.";
            $sqlinsert = "INSERT INTO `frs_trail` (`user_id`, `description`) VALUES (?,?)";
            $statementinsert = $this->db->prepare($sqlinsert);
            $statementinsert->execute([$user, $description]);

            $_SESSION['success'] = 'Success: E-Jeep added!';
            echo "<script>window.location.href='../admin/ejeeps.php';</script>";
        }
    }

    public function editEjeep() {
        $user = $_SESSION['user_id'];
        $ejeep_id = $_POST['plate_id'];
        $plate = $_POST['plate'];
       

        $sql = "SELECT * FROM `frs_ejeeps` WHERE `plate` = ?  AND `deleted` != b'1' AND `id` != ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$plate, $ejeep_id]);

        if ($stmt->rowcount() > 0) {
            $_SESSION['error'] = "Error: Ejeep already exists!";
            echo "<script>window.location.href='../admin/ejeeps.php';</script>";
        }
        else {
            $sqlupdate = "UPDATE `frs_ejeeps` SET `plate` = ?, `updated_by` = ? WHERE `id` = ?";
            $statementupdate = $this->db->prepare($sqlupdate);
            $statementupdate->execute([$plate, $user, $ejeep_id]);

            $description = "Updated Ejeep.";
            $sqlinsert = "INSERT INTO `frs_trail` (`user_id`, `description`) VALUES (?,?)";
            $statementinsert = $this->db->prepare($sqlinsert);
            $statementinsert->execute([$user, $description]);

            $_SESSION['updated'] = 'Success: Category updated!';
            echo "<script>window.location.href='../admin/ejeeps.php';</script>";
        }
    }


    public function deleteEjeep() {
        $user = $_SESSION['user_id'];
        $ejeep = $_POST['ejeep_id'];

        $sqlupdate = "UPDATE `frs_ejeeps` SET `deleted` = b'1', `updated_by` = ? WHERE `id` = ?";
        $statementupdate = $this->db->prepare($sqlupdate);
        $statementupdate->execute([$user, $ejeep]);

        $description = "Deleted e-jeep.";
        $sqlinsert = "INSERT INTO `frs_trail` (`user_id`, `description`) VALUES (?,?)";
        $statementinsert = $this->db->prepare($sqlinsert);
        $statementinsert->execute([$user, $description]);

        $_SESSION['deleted'] = 'Success: E-Jeep deleted!';
        echo "<script>window.location.href='../admin/ejeeps.php';</script>";
    }
}

$controller = new EjeepController();

if (isset($_POST['add'])) $controller->addEjeep();
if (isset($_POST['edit'])) $controller->editEjeep();
if (isset($_POST['delete'])) $controller->deleteEjeep();