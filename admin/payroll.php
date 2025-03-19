<?php
/*
* Salary View
* Description: Salaries View
* Author: Vernyll Jan P. Asis
*/

session_start();
if (!isset($_SESSION['type'])) {
    header('location: ./');
}

require_once '../config/config.php';

class Salary {
    private $db;

    public function __construct() {
        $conn = new Connection();
        $this->db = $conn->getConnection();
    }

    public function getData() {
        // Query to group by driver and week with date range
        $salary_sql = "
            SELECT
                b.`id` AS driver_id,
                b.`first_name`,
                b.`last_name`,
                MIN(a.`date`) AS start_date,
                MAX(a.`date`) AS end_date,
                SUM(a.`collection`) AS total_collection,
                SUM(
                    CASE
                        WHEN a.`collection` >= c.`quota`
                        THEN c.`base_salary` + (a.`collection` * (c.`addon_rate` / 100))
                        ELSE a.`collection` * (c.`base_rate` / 100)
                    END
                ) AS weekly_salary
            FROM `frs_salaries` AS a
            INNER JOIN `frs_drivers` AS b ON a.`driver_id` = b.`id`
            INNER JOIN `frs_rates` AS c ON a.`rate_id` = c.`id`
            GROUP BY driver_id, YEARWEEK(a.`date`, 1)
            ORDER BY end_date DESC, b.`first_name` ASC";

        $salary_stmt = $this->db->query($salary_sql);
?>
<!DOCTYPE html>
<html style="background-color: #00693e;">
<head>
<?php include '../common/head.php'; ?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

<?php include '../common/navbar.php'; ?>
<?php include '../common/sidebar.php'; ?>

<!-- Content Wrapper -->
<div class="content-wrapper">
    <section class="content-header">
        <h1>Salaries</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="bi bi-speedometer2"></i> Home</a></li>
            <li class="active">Salaries</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <!-- Filter per Driver sana here -->
                    </div>
                    <div class="box-body table-responsive">
                        <table id="example1" class="table table-bordered">
                            <thead>
                                <th>#</th>
                                <th>Driver</th>
                                <th>Date Range</th>
                                <th>Total Collection</th>
                                <th>Weekly Salary</th>
                                <th style="width: 100px;">Action</th>
                            </thead>
                            <tbody>
<?php
$id = 1;
while ($row = $salary_stmt->fetch()) {
    // Format the date range as Month, Day, Year - Month, Day, Year
    $start_date = date('F j, Y', strtotime($row['start_date']));
    $end_date = date('F j, Y', strtotime($row['end_date']));
?>
<tr>
    <td><?php echo $id; ?></td>
    <td><?php echo $row['first_name'] . " " . $row['last_name']; ?></td>
    <td><?php echo "$start_date - $end_date"; ?></td>
    <td style="text-align: right;">Php <?php echo number_format($row['total_collection'], 2); ?></td>
    <td style="text-align: right;">Php <?php echo number_format($row['weekly_salary'], 2); ?></td>
    <td>
        <button class="btn btn-primary btn-sm payout-btn btn-flat"
        data-driver_id="<?php echo $row['driver_id']; ?>"
        data-week="<?php echo "$start_date - $end_date"; ?>"> Payout</button>
    </td>
</tr>
<?php $id++; } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

</div>

<?php include '../common/footer.php'; ?>


</body>
</html>
<?php
    }
}

$salary = new Salary();
$salary->getData();
?>
