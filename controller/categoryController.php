<?php
/*
 * Category Controller
 * Description: Category Controller
 * Author: Charlene B. Dela Cruz
 */

session_start();
require_once '../config/config.php';

class CategoryController {
    private $db;

    public function __construct() {
        $conn = new Connection();
        $this->db = $conn->getConnection();
    }

    public function addCategory() {
        $user = $_SESSION['user_id'];
        $category = $_POST['category'];

        $sql = "SELECT * FROM `frs_categories` WHERE `description` = ? AND `deleted` != b'1'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$category]);

        if ($stmt->rowcount() > 0) {
            $_SESSION['error'] = 'Error: Category already exists! Use a different description.';
            echo "<script>window.location.href='../admin/expensesCategory.php';</script>";
        }
        else {
            $sqlinsert = "INSERT INTO `frs_categories`(`description`, `created_by`) VALUES (?,?)";
            $statementinsert = $this->db->prepare($sqlinsert);
            $statementinsert->execute([$category, $user]);

            $description = "Added a new category.";
            $sqlinsert = "INSERT INTO `frs_trail` (`user_id`, `description`) VALUES (?,?)";
            $statementinsert = $this->db->prepare($sqlinsert);
            $statementinsert->execute([$user, $description]);

            $_SESSION['success'] = 'Success: Category added!';
            echo "<script>window.location.href='../admin/expensesCategory.php';</script>";
        }
    }

    public function editCategory() {
        $user = $_SESSION['user_id'];
        $category_id = $_POST['category_id'];
        $category = $_POST['category'];
       

        $sql = "SELECT * FROM `frs_categories` WHERE `description` = ?  AND `deleted` != b'1' AND `id` != ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$category, $category_id]);

        if ($stmt->rowcount() > 0) {
            $_SESSION['error'] = "Error: Category already exists! Use a different description.";
            echo "<script>window.location.href='../admin/expensesCategory.php';</script>";
        }
        else {
            $sqlupdate = "UPDATE `frs_categories` SET `description` = ?, `updated_by` = ? WHERE `id` = ?";
            $statementupdate = $this->db->prepare($sqlupdate);
            $statementupdate->execute([$category, $user, $category_id]);

            $description = "Updated Category.";
            $sqlinsert = "INSERT INTO `frs_trail` (`user_id`, `description`) VALUES (?,?)";
            $statementinsert = $this->db->prepare($sqlinsert);
            $statementinsert->execute([$user, $description]);

            $_SESSION['updated'] = 'Success: Category updated!';
            echo "<script>window.location.href='../admin/expensesCategory.php';</script>";
        }
    }

    public function deleteCategory() {
        $user = $_SESSION['user_id'];
        $category_id = $_POST['category_id'];

        $sqlupdate = "UPDATE `frs_categories` SET `deleted` = b'1', `updated_by` = ? WHERE `id` = ?";
        $statementupdate = $this->db->prepare($sqlupdate);
        $statementupdate->execute([$user, $category_id]);

        $description = "Deleted Category.";
        $sqlinsert = "INSERT INTO `frs_trail` (`user_id`, `description`) VALUES (?,?)";
        $statementinsert = $this->db->prepare($sqlinsert);
        $statementinsert->execute([$user, $description]);

        $_SESSION['deleted'] = 'Success: Category deleted!';
        echo "<script>window.location.href='../admin/expensesCategory.php';</script>";
    }
}

$controller = new CategoryController();

if (isset($_POST['add'])) $controller->addCategory();
if (isset($_POST['edit'])) $controller->editCategory();
if (isset($_POST['delete'])) $controller->deleteCategory();