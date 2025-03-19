<?php
/*
 * Salary Controller
 * Description: Salary Controller
 * Author: Vernyll Jan P. Asis
 */

session_start();
require_once '../config/config.php';

class SalaryController {
    private $db;

    public function __construct() {
        $conn = new Connection();
        $this->db = $conn->getConnection();
    }

    public function changeComputation() {
        $user = $_SESSION['user_id'];
        $id = $_POST['salary_id'];
        $rate = $_POST['rate_id'];

        $sql = "SELECT * FROM `frs_salaries` WHERE `id` = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $amount = $row['collection'];

        $sql = "SELECT * FROM `frs_rates` WHERE `id` = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$rate]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($amount < $row['quota']) $salary = $amount * $row['base_rate'] / 100;
        else $salary = $row['base_salary'] + ($amount * $row['addon_rate'] / 100);

        $salary_sql = "
        UPDATE `frs_salaries`
        SET `rate_id` = ?, `salary` = ?, `updated_by` = ?
        WHERE `id` = ?";
        $salary_stmt = $this->db->prepare($salary_sql);
        $salary_stmt->execute([$rate, $salary, $user, $id]);

        $description = "Changed salary computation.";
        $sqlinsert = "INSERT INTO `frs_trail` (`user_id`, `description`) VALUES (?,?)";
        $statementinsert = $this->db->prepare($sqlinsert);
        $statementinsert->execute([$user, $description]);

        $_SESSION['success'] = 'Success: Salary computation changed!';
        echo "<script>window.location.href='../admin/salaries.php';</script>";
    }
}

$controller = new SalaryController();
if (isset($_POST['change'])) $controller->changeComputation();