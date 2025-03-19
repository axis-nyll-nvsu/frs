<?php
/*
 * Payroll Controller
 * Description: Payroll Controller
 * Author: Dela Cruz, C
 */

session_start();
require_once '../config/config.php';

class PayrollController {
    private $db;

    public function __construct() {
        $conn = new Connection();
        $this->db = $conn->getConnection();
    }

    public function addPayout() {
        $user = $_SESSION['user_id'];
        $date = date('Y-m-d',strtotime($_POST['date']));
        $category = 5;
        $description = $_POST['description'];
        $amount = $_POST['amount'];

        $sqlinsert = "INSERT INTO `frs_expenses`(`date`, `category_id`, `description`, `amount`, `created_by`) VALUES (?,?,?,?,?)";
        $statementinsert = $this->db->prepare($sqlinsert);
        $statementinsert->execute([$date, $category, $description, $amount, $user]);

        $description = "Added a new expense.";
        $sqlinsert = "INSERT INTO `frs_trail` (`user_id`, `description`) VALUES (?,?)";
        $statementinsert = $this->db->prepare($sqlinsert);
        $statementinsert->execute([$user, $description]);

        $_SESSION['success'] = 'Success: Expense added!';
        echo "<script>window.location.href='../admin/expenses.php';</script>";
    }
}

$controller = new PayrollController();

if (isset($_POST['add'])) $controller->addPayout();
