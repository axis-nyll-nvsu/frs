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
        $date = date('Y-m-d');
        $driver_id = $_POST['driver_id'];
        $driver_name = $_POST['driver_name'];
        $total_salary = floatval($_POST['total_salary']);
        $pay_week = $_POST['pay_week'];

        try {
            // Begin transaction
            $this->db->beginTransaction();
    
            // Insert into frs_expenses
            $category = 5;
            $description = "Payout for Driver: $driver_name (Week: $pay_week)";
            $sqlInsertExpense = "INSERT INTO `frs_expenses`(`date`, `category_id`, `description`, `amount`, `created_by`) VALUES (?,?,?,?,?)";
            $stmtExpense = $this->db->prepare($sqlInsertExpense);
            $stmtExpense->execute([$date, $category, $description, $total_salary, $user]);
    
            // Insert into frs_trail
            $trailDesc = "Processed payout for Driver: $driver_name (Week: $pay_week) - Amount: Php $total_salary";
            $sqlInsertTrail = "INSERT INTO `frs_trail` (`user_id`, `description`) VALUES (?,?)";
            $stmtTrail = $this->db->prepare($sqlInsertTrail);
            $stmtTrail->execute([$user, $trailDesc]);
    
            // Commit transaction
            $this->db->commit();
    
            $_SESSION['success'] = "Payout processed successfully!";
            $_SESSION['paid_driver_id'] = $driver_id;
            echo "<script>window.location.href='../admin/payroll.php';</script>";
    
        } catch (Exception $e) {
            $this->db->rollBack();
            $_SESSION['error'] = "Error: " . $e->getMessage();
            echo "<script>window.location.href='../admin/payroll.php';</script>";
        }
    }
    
}

$controller = new PayrollController();

if (isset($_POST['add'])) $controller->addPayout();
?>
