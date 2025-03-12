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

    public function computeSalaries() {
        $user = $_SESSION['user_id'];
        $start_date = $_POST['start_date'];
        $end_date = date('Y-m-d', strtotime($start_date . ' +6 days'));
        
        $driver_sql = "SELECT * FROM `frs_drivers` WHERE `deleted` != b'1'";
        $driver_stmt = $this->db->query($driver_sql);
        
        while($driver = $driver_stmt->fetch()) {
            $driver_id = $driver['id'];
            $fare_sql = "SELECT * FROM `frs_fares` WHERE `driver_id` = ? AND `deleted` != b'1' AND `date` BETWEEN ? AND ?";
            $fare_stmt = $this->db->prepare($fare_sql);
            $fare_stmt->execute([$driver_id, $start_date, $end_date]);

            $total = 0;
            while($fare = $fare_stmt->fetch()) {
                $total += $fare['amount'];
            }

            $salary_sql = "
            INSERT INTO `frs_salaries`(`driver_id`, `start_date`, `end_date`, `collection`, `amount`, `created_by`)
            SELECT ?,?,?,?,?,?
            WHERE NOT EXISTS (
            SELECT 1 FROM `frs_salaries` WHERE `driver_id` = ? AND `start_date` = ? AND `end_date` = ?
            )";
            $salary_stmt = $this->db->prepare($salary_sql);
            $salary_stmt->execute([$driver_id, $start_date, $end_date, $total, $total * 18 / 100, $user, $driver_id, $start_date, $end_date]);
        }

        $description = "Computed salaries.";
        $sqlinsert = "INSERT INTO `frs_audittrail` (`user_id`, `description`) VALUES (?,?)";
        $statementinsert = $this->db->prepare($sqlinsert);
        $statementinsert->execute([$user, $description]);

        $_SESSION['computed'] = 'computed';
        echo "<script>window.location.href='../admin/salaries.php';</script>";
    }

    public function recomputeSalary() {
        $user = $_SESSION['user_id'];
        $id = $_POST['salary_id'];

        $salary_sql = "SELECT * FROM `frs_salaries` WHERE `id` = ?";
        $salary_stmt = $this->db->prepare($salary_sql);
        $salary_stmt->execute([$id]);

        $salary = $salary_stmt->fetch();
        $driver_id = $salary['driver_id'];
        $start_date = $salary['start_date'];
        $end_date = date('Y-m-d', strtotime($start_date . ' +6 days'));

        $fare_sql = "SELECT * FROM `frs_fares` WHERE `driver_id` = ? AND `deleted` != b'1' AND `date` BETWEEN ? AND ?";
        $fare_stmt = $this->db->prepare($fare_sql);
        $fare_stmt->execute([$driver_id, $start_date, $end_date]);

        $total = 0;
        while($fare = $fare_stmt->fetch()) {
            $total += $fare['amount'];
        }

        $salary_sql = "
        UPDATE `frs_salaries`
        SET `collection` = ?, `amount` = ?, `updated_by` = ?
        WHERE `id` = ?";
        $salary_stmt = $this->db->prepare($salary_sql);
        $salary_stmt->execute([$total, $total * 18 / 100, $user, $id]);

        $description = "Recomputed salary.";
        $sqlinsert = "INSERT INTO `frs_audittrail` (`user_id`, `description`) VALUES (?,?)";
        $statementinsert = $this->db->prepare($sqlinsert);
        $statementinsert->execute([$user, $description]);

        $_SESSION['recomputed'] = 'recomputed';
        echo "<script>window.location.href='../admin/salaries.php';</script>";
    }

    public function paySalary() {
        $user = $_SESSION['user_id'];
        $id = $_POST['salary_id'];

        $salary_sql = "SELECT * FROM `frs_salaries` AS a INNER JOIN `frs_drivers` AS b ON a.`driver_id` = b.`id` WHERE a.`id` = ?";
        $salary_stmt = $this->db->prepare($salary_sql);
        $salary_stmt->execute([$id]);

        $salary = $salary_stmt->fetch();
        $driver =   $salary['first_name'] . " ";
        $driver .=  ($salary['middle_name'] != "") ? $salary['middle_name'] . " " : "";
        $driver .=  $salary['last_name'];
        $start_date = $salary['start_date'];
        $end_date = date('Y-m-d', strtotime($start_date . ' +6 days'));
        $coverage = date('M d, Y', strtotime($start_date)) . " - " . date('M d, Y', strtotime($end_date));

        $salary_sql = "
        UPDATE `frs_salaries`
        SET `paid` = b'1', `updated_by` = ?
        WHERE `id` = ?";
        $salary_stmt = $this->db->prepare($salary_sql);
        $salary_stmt->execute([$user, $id]);

        $description = "Salary of " . $driver . " for " . $coverage . ".";
        $expense_sql = "
        INSERT INTO `frs_expenses`(`category_id`, `description`, `amount`,  `date`, `created_by`)
        VALUES(1,?,?,?,?)";
        $expense_stmt = $this->db->prepare($expense_sql);
        $expense_stmt->execute([$description, $salary['amount'], date('Y-m-d'), $user]);

        $description = "Paid salary.";
        $sqlinsert = "INSERT INTO `frs_audittrail` (`user_id`, `description`) VALUES (?,?)";
        $statementinsert = $this->db->prepare($sqlinsert);
        $statementinsert->execute([$user, $description]);

        $_SESSION['paid'] = 'paid';
        echo "<script>window.location.href='../admin/salaries.php';</script>";
    }
}

$controller = new SalaryController();

if (isset($_POST['compute'])) $controller->computeSalaries();
if (isset($_POST['recomp'])) $controller->recomputeSalary();
if (isset($_POST['pay'])) $controller->paySalary();