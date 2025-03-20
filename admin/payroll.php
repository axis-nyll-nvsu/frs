<?php
/*
* Payroll
* Description: Payroll View
*/

session_start();
if (!isset($_SESSION['type'])) {
    header('location: ./');
}

require_once '../config/config.php';

class Payroll {
    private $db;

    public function __construct() {
        $conn = new Connection();
        $this->db = $conn->getConnection();
    }

    public function getData() {
        $period = date('Y');
        if (isset($_GET['period'])) {
            $period = $_GET['period'];
        }

        // Query to group by driver and week with date range
        $payroll_sql = "
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
        $payroll_stmt = $this->db->query($payroll_sql);
        $salaries = $payroll_stmt->fetchAll(PDO::FETCH_ASSOC);

        $data = [
            'period' => $period,
            'salaries' => $salaries
        ];

        return $data;
    }
}

$payroll = new Payroll();
$reports = $payroll->getData();
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
        <div class="content-wrapper">
            <section class="content-header">
                <h1>Reports &mdash; Weekly Payroll</h1>
                <ol class="breadcrumb">
                    <li><a href="dashboard.php"><i class="bi bi-speedometer2"></i> Home</a></li>
                    <li>Reports</li>
                    <li class="active">Weekly Payroll</li>
                </ol>
            </section>
            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-header with-border">
                                <div style="position: relative">
                                    <form method="GET" action="" style="display: flex; width: 245px; position: absolute; top: 0; left: 0; z-index: 10;">
                                        <select name="period" class="form-control axis-form-control" style="margin-right: 3px">
<?php
$year = date('Y');
for($i = 1; $i <= 5; $i++) {
    echo '<option value="' . $year . '" ';
    if($year == $reports['period']) echo 'selected';
    echo '>Fiscal Year: ' . $year . '</option>';
    $year--;
}
?>
                                        </select>
                                        <button type="submit" class="btn btn-sm btn-flat axis-btn-green"> Set Period</button>
                                    </form>
                                    <h3 style="text-align: center; font-weight: bold; margin-top: 0;">Weekly Payroll</h3>
                                    <a href="cashflow_statement_print.php?period=<?php echo $reports['period']; ?>" class="btn btn-sm btn-flat axis-btn-green" style="position: absolute; top: 0; right: 0;" target="_blank"><i class="bi bi-printer"></i> Print Weekly Payroll</a>
                                    <h4 style="text-align: center; font-size: 1em;">For the Week of <?php echo "Dec 31, " . $reports['period']; ?></h4>
                                </div>
                            </div>
                            <div class="box-body table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr style="background-color: #00693e; color: #fff;">
                                            <th>#</th>
                                            <th>Driver</th>
                                            <th>Week</th>
                                            <th>Collections</th>
                                            <th>Salary</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php
$id = 1;
foreach($reports['salaries'] as $row) {
    $dateStart = date('F d, Y', strtotime($row['start_date']));
    $dateEnd = date('F d, Y', strtotime($row['start_date'] . ' +6 days'));
    $dateRange = $dateStart . " - " . $dateEnd;
?>
<tr>
    <td><?php echo $id; ?></td>
    <td><?php echo $row['first_name'] . " " . $row['last_name']; ?></td>
    <td><?php echo $dateRange; ?></td>
    <td style="text-align: right;">Php <?php echo number_format($row['total_collection'], 2); ?></td>
    <td style="text-align: right;">Php <?php echo number_format($row['weekly_salary'], 2); ?></td>
</tr>
<?php $id++; } ?>
                                    </tbody>
                                </table>
                                <p>
                                    <small>
                                    Report generated on <?php echo date('F d, Y h:iA', strtotime(date('Y-m-d h:iA') . ' +7 hours')); ?>.<br>
                                    Disclaimer: The data presented is based on the information available in the system at the time of generation and may be subject to change.
                                    </small>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
<?php include '../common/footer.php'; ?>
<?php include '../modal/profileModal.php'; ?>
</body>
</html>