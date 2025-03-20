<?php
/*
* Payroll
* Description: Payroll Print
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
        $period = date('Y-m-d');
        if (isset($_GET['period'])) {
            $period = $_GET['period'];
        }

        $i = $period;
        $d = new DateTime($i);
        $dow = $d->format('w');
        if ($dow == 6) {
          $d->modify("-6 days");
        }
        else {
          $dfs = ((6 - $dow) % 7) - 6;
          $d->modify("{$dfs} days");
        }
        $ns = $d->format('Y-m-d');
        $ds = new DateTime($ns);
        $de = new DateTime($ns);
        $de->modify("+6 days");
        $start = $ds->format('Y-m-d');
        $end = $de->format('Y-m-d');

        // Query to group by driver and week with date range
        $payroll_sql = "SELECT
                            a.`driver_id`,
                            b.`first_name`,
                            b.`last_name`,
                            SUM(a.`collection`) AS collections,
                            SUM(a.`salary`) AS salaries " .
                        "FROM `frs_salaries` AS a " .
                        "INNER JOIN `frs_drivers` AS b " .
                        "ON a.`driver_id` = b.`id` " .
                        "WHERE a.`date` BETWEEN ? AND ? " .
                        "GROUP BY a.`driver_id`, b.`first_name`, b.`last_name` " .
                        "ORDER BY a.`date` DESC, b.`first_name` ASC";
        $payroll_stmt = $this->db->prepare($payroll_sql);
        $payroll_stmt->execute([$start, $end]);
        $salaries = $payroll_stmt->fetchAll(PDO::FETCH_ASSOC);

        $data = [
            'start' => $start,
            'end' => $end,
            'period' => $period,
            'salaries' => $salaries
        ];

        return $data;
    }
}

$payroll = new Payroll();
$reports = $payroll->getData();

$givenDate = $reports['period'];
$date = new DateTime($givenDate);
$dayOfWeek = $date->format('w');
if ($dayOfWeek == 6) {
  $date->modify("-6 days");
}
else {
  $daysFromSaturday = ((6 - $dayOfWeek) % 7) - 6;
  $date->modify("{$daysFromSaturday} days");
}
$nearestSaturday = $date->format('Y-m-d');

$dateStart = new DateTime($nearestSaturday);
$dateEnd = new DateTime($nearestSaturday);
$dateEnd->modify("+6 days");
$reportCoverage = $dateStart->format('F d, Y') . " - " . $dateEnd->format('F d, Y');
?>
<!DOCTYPE html>
<html style="background-color: #00693e;">
<head>
<?php include '../common/head.php'; ?>
<style>
    @media print {
        .content-wrapper {
            width: 100%;
            margin-left: 0;
            margin-top: 0;
        }

        .box {
            border: 0.5px solid #000;
            margin: 0;
            width: 100%;
            box-shadow: none;
        }
    }
</style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="width: 100%; margin-left: 0; margin-top: 0;">

        <!-- Main Content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <div style="position: relative">
                                <div style="text-align: center; font-weight: bold; margin-top: 0;">
                                    <img src="../images/logo.png" alt="" style="display: inline-block; width: 100px; margin: 20px;" />
                                    <p style="font-size: 1.2em;">First Novo Vizcayano Travellers Transport Cooperative</p>
                                </div>
                                <h4 style="text-align: center; font-size: 1em;">Solano, Nueva Vizcaya</h4>
                            </div>
                        </div>
                        <div class="box-header">
                            <div style="position: relative">
                                <h3 style="text-align: center; font-weight: bold; margin-top: 0;">Weekly Payroll</h3>
                                <h4 style="text-align: center; font-size: 1em;">For <?php echo $reportCoverage; ?></h4>
                            </div>
                        </div>
                        <div class="box-body table-responsive">
                            <table class="table">
                                <thead>
                                    <tr style="background-color: #00693e; color: #fff;">
                                        <th>#</th>
                                        <th>Driver</th>
                                        <th>Week</th>
                                        <th style="min-width: 100px !important;">Collections</th>
                                        <th style="min-width: 100px !important;">Salary</th>
                                        <th style="min-width: 100px !important;">Signature</th>
                                    </tr>
                                </thead>
                                <tbody>
<?php
$id = 1;
$total_collections = 0;
$total_salaries = 0;
foreach($reports['salaries'] as $row) {
    $dateStart = date('F d, Y', strtotime($reports['start']));
    $dateEnd = date('F d, Y', strtotime($reports['end']));
    $dateRange = $dateStart . " - " . $dateEnd;
    $total_collections += $row['collections'];
    $total_salaries += $row['salaries'];
?>
<tr>
    <td><?php echo $id; ?></td>
    <td><?php echo $row['first_name'] . " " . $row['last_name']; ?></td>
    <td><?php echo $dateRange; ?></td>
    <td style="text-align: right;">Php <?php echo number_format($row['collections'], 2); ?></td>
    <td style="text-align: right;">Php <?php echo number_format($row['salaries'], 2); ?></td>
    <td></td>
</tr>
<?php $id++; } ?>
                                <tr style="background-color: #fafafa; font-weight: bold;">
                                    <td colspan="3" style="text-align: right;">Total</td>
                                    <td style="text-align: right;">Php <?php echo number_format($total_collections, 2); ?></td>
                                    <td style="text-align: right;">Php <?php echo number_format($total_salaries, 2); ?></td>
                                    <td></td>
                                </tr>
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
<script>
    //window.print();
    //window.onafterprint = window.close;
</script>
</body>
</html>