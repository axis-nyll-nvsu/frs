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
                            a.driver_id,
                            b.first_name,
                            b.last_name,
                            SUM(a.collection) AS collections,
                            SUM(a.salary) AS salaries " .
                        "FROM frs_salaries AS a " .
                        "INNER JOIN frs_drivers AS b " .
                        "ON a.driver_id = b.id " .
                        "WHERE a.date BETWEEN ? AND ? " .
                        "GROUP BY a.driver_id, b.first_name, b.last_name " .
                        "ORDER BY a.date DESC, b.first_name ASC";
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
    <style>
        button[disabled] {
            background-color: #ccc !important;
            cursor: not-allowed;
        }
    </style>
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
                                    <form method="GET" action="" id="periodForm" style="display: flex; width: 200px; position: absolute; top: 0; left: 0; z-index: 10;">
                                        <input id="period" name="period" value="<?php echo $reports['period']; ?>" hidden>
                                        <input class="form-control axis-form-control" id="date" name="date" value="<?php echo $date->format('m/d/Y'); ?>" style="margin-right: 3px; background-color: #fff; text-align: center;" readonly>
                                        <button type="submit" class="btn btn-sm btn-flat axis-btn-green"> Set Period</button>
                                    </form>
                                    <h3 style="text-align: center; font-weight: bold; margin-top: 0;">Weekly Payroll</h3>
                                    <a href="payroll_print.php?period=<?php echo $reports['period']; ?>" class="btn btn-sm btn-flat axis-btn-green" style="position: absolute; top: 0; right: 0;" target="_blank"><i class="bi bi-printer"></i> Print Weekly Payroll</a>
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
                                            <th style="width: 150px; min-width: 100px !important;">Collections</th>
                                            <th style="width: 150px; min-width: 100px !important;">Salary</th>
                                            <th style="width: 75px; min-width: 75px !important;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php
$id = 1;
$total_collections = 0;
$total_salaries = 0;

// Get the selected date range from report
$dateStart = date('F d, Y', strtotime($reports['start']));
$dateEnd = date('F d, Y', strtotime($reports['end']));
$dateRange = $dateStart . " - " . $dateEnd;

$salary_category_id = 5;

foreach ($reports['salaries'] as $row) {
    $total_collections += $row['collections'];
    $total_salaries += $row['salaries'];

    // Create description used in frs_expenses
    $description = 'Payout for Driver: ' . $row['first_name'] . ' ' . $row['last_name'] . ' (Week: ' . $dateStart . ' - ' . $dateEnd . ')';

    // Check if the salary payout already exists in frs_expenses
    $check_stmt = $payroll->db->prepare("SELECT COUNT(*) FROM frs_expenses WHERE description = ? AND category_id = ? AND deleted = 0");
    $check_stmt->execute([$description, $salary_category_id]);
    $already_disbursed = $check_stmt->fetchColumn() > 0;
?>
<tr>
    <td><?php echo $id; ?></td>
    <td><?php echo $row['first_name'] . " " . $row['last_name']; ?></td>
    <td><?php echo $dateRange; ?></td>
    <td style="text-align: right;">Php <?php echo number_format($row['collections'], 2); ?></td>
    <td style="text-align: right;">Php <?php echo number_format($row['salaries'], 2); ?></td>
    <td>
        <button class="btn btn-success btn-sm disburseSalary btn-flat"
            data-driver_name="<?php echo $row['first_name'] . ' ' . $row['last_name']; ?>"
            data-pay_week="<?php echo $dateRange; ?>"
            data-total_salary="<?php echo number_format($row['salaries'], 2, '.', ''); ?>"
            <?php echo $already_disbursed ? 'disabled' : ''; ?>>
            <?php echo $already_disbursed ? 'Disbursed' : 'Disburse Salary'; ?>
        </button>
    </td>
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
<?php include '../modal/profileModal.php'; ?>
<?php include '../modal/messageModal.php'; ?>
<?php include '../modal/payrollModal.php'; ?>
<script>
$(document).ready(function() {
    $("#date").datepicker();

    $("#periodForm").on("submit", function(e){
        e.preventDefault();
        let inputDate = $('#date').val();
        let [month, day, year] = inputDate.split('/');
        day = parseInt(day) + 1;
        let date = new Date(year, month - 1, day);
        let formattedDate = date.toISOString().split('T')[0];
        $('#period').val(formattedDate);
        $('input[name="date"]').remove();
        this.submit();
    });

});
$(document).ready(function() {
    $(document).ready(function() {
    $(".disburseSalary").click(function() {
        let driverName = $(this).data("driver_name");
        let payWeek = $(this).data("pay_week");
        let totalSalary = $(this).data("total_salary");

        $("#driver_name").val(driverName);
        $("#pay_week").val(payWeek);
        $("#total_salary").val(totalSalary);

        $("#modal_driver_name").text(driverName);
        $("#modal_week").text(payWeek);
        $("#modal_salary").text(totalSalary);

        $("#payout").modal("show");
    });
});

});
</script>
<script>
<?php if (isset($_SESSION['success'])) { ?>
$('#success').modal('show');
<?php unset($_SESSION['success']); } ?>
</script>

</body>
</html>