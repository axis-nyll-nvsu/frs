<?php
/*
 * Cashflow Statement
 * Description: Cashflow Statement View
 * Author: Vernyll Jan P. Asis
 */

session_start();
if(!isset($_SESSION['type'])) {
    header('location: ./');
}

require_once '../config/config.php';
class Report {
    private $db;

    public function __construct() {
        $conn = new Connection();
        $this->db = $conn->getConnection();
    }

    public function getData(){
        $period = date('Y');
        if (isset($_GET['period'])) {
            $period = $_GET['period'];
        }

        $previous_year = $period - 1; // Get the previous year

        // Collections Last Year
        $revenuesLastYear_sql = "SELECT COALESCE(SUM(amount), 0) AS total_collections
        FROM frs_collections
        WHERE YEAR(date) = ? AND deleted != b'1'";
        $revenuesLastYear_stmt = $this->db->prepare($revenuesLastYear_sql);
        $revenuesLastYear_stmt->execute([$previous_year]);
        $revenuesLastYear = $revenuesLastYear_stmt->fetch(PDO::FETCH_ASSOC)['total_collections'];

        // Expenses Last Year
        $expensesLastYear_sql = "SELECT COALESCE(SUM(amount), 0) AS total_expenses
        FROM frs_expenses
        WHERE YEAR(date) = ? AND deleted != b'1'";
        $expensesLastYear_stmt = $this->db->prepare($expensesLastYear_sql);
        $expensesLastYear_stmt->execute([$previous_year]);
        $expensesLastYear = $expensesLastYear_stmt->fetch(PDO::FETCH_ASSOC)['total_expenses'];

        // Calculate Profits Last Year
        $profitsLastYear = $revenuesLastYear - $expensesLastYear;

        // Line Item Entries
        $operating_collections = 0;
        $q_sql = "SELECT COALESCE(SUM(amount), 0) AS total
        FROM frs_collections
        WHERE YEAR(date) = ? AND deleted != b'1'";
        $q_stmt = $this->db->prepare($q_sql);
        $q_stmt->execute([$period]);
        $operating_collections = $q_stmt->fetch(PDO::FETCH_ASSOC)['total'];

        $operating_salaries = 0; // frs_expenses 5
        $q_sql = "SELECT COALESCE(SUM(amount), 0) AS total
        FROM frs_expenses
        WHERE YEAR(date) = ? AND (category_id = 5) AND deleted != b'1'";
        $q_stmt = $this->db->prepare($q_sql);
        $q_stmt->execute([$period]);
        $operating_salaries = $q_stmt->fetch(PDO::FETCH_ASSOC)['total'];

        $operating_utilities = 0; // frs_expenses 6&7
        $q_sql = "SELECT COALESCE(SUM(amount), 0) AS total
        FROM frs_expenses
        WHERE YEAR(date) = ? AND (category_id = 6 OR category_id = 7) AND deleted != b'1'";
        $q_stmt = $this->db->prepare($q_sql);
        $q_stmt->execute([$period]);
        $operating_utilities = $q_stmt->fetch(PDO::FETCH_ASSOC)['total'];

        $operating_supplies = 0; // frs_expenses 8
        $q_sql = "SELECT COALESCE(SUM(amount), 0) AS total
        FROM frs_expenses
        WHERE YEAR(date) = ? AND (category_id = 8) AND deleted != b'1'";
        $q_stmt = $this->db->prepare($q_sql);
        $q_stmt->execute([$period]);
        $operating_supplies = $q_stmt->fetch(PDO::FETCH_ASSOC)['total'];

        $operating_maintenance = 0; // frs_expenses 3
        $q_sql = "SELECT COALESCE(SUM(amount), 0) AS total
        FROM frs_expenses
        WHERE YEAR(date) = ? AND (category_id = 3) AND deleted != b'1'";
        $q_stmt = $this->db->prepare($q_sql);
        $q_stmt->execute([$period]);
        $operating_maintenance = $q_stmt->fetch(PDO::FETCH_ASSOC)['total'];

        $net_operating = 0;
        $net_operating += $operating_collections;
        $net_operating -= $operating_salaries + $operating_utilities;
        $net_operating -= $operating_supplies + $operating_maintenance;

        $net_investing = 0;
        $net_investing += 0;
        $net_investing -= 0;

        $net_financing = 0;
        $net_financing += 0;
        $net_financing -= 0;

        $net_change = 0;
        $net_change += $net_operating + $net_investing + $net_financing;

        $profitsThisYear = $profitsLastYear + $net_change;

        $data = [
            'period' => $period,
            'profitsLastYear' => $profitsLastYear,
            'operating_collections' => $operating_collections,
            'operating_salaries' => $operating_salaries,
            'operating_utilities' => $operating_utilities,
            'operating_supplies' => $operating_supplies,
            'operating_maintenance' => $operating_maintenance,
            'net_operating' => $net_operating,
            'net_investing' => $net_investing,
            'net_financing' => $net_financing,
            'net_change' => $net_change,
            'profitsThisYear' => $profitsThisYear
        ];

        return $data;
    }
}

$report = new Report();
$reports = $report->getData();
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
                <h1>Reports &mdash; Statement of Cash Flows</h1>
                <ol class="breadcrumb">
                    <li><a href="dashboard.php"><i class="bi bi-speedometer2"></i> Home</a></li>
                    <li>Reports</li>
                    <li class="active">Statement of Cash Flows</li>
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
                                    <h3 style="text-align: center; font-weight: bold; margin-top: 0;">Statement of Cash Flow</h3>
                                    <!--<a href="cashflow_statement_print.php?period=<?php echo $period; ?>" class="btn btn-sm btn-flat axis-btn-green" style="position: absolute; top: 0; right: 0;" target="_blank"><i class="bi bi-printer"></i> Print Statement of Cash Flows</a>-->
                                    <h4 style="text-align: center; font-size: 1em;">For the Year Ending <?php echo "Dec 31, " . $reports['period']; ?></h4>
                                </div>
                            </div>
                            <div class="box-body table-responsive">
                                <table class="table">
                                    <thead>
                                        <th style="width: 30px; max-width: 30px !important;"></th>
                                        <th style="text-align: right;">Cash at Beginning of Year</th>
                                        <th style="text-align: right; width: 150px; max-width: 150px !important;"><?php echo "Php " . number_format($reports['profitsLastYear'], 2); ?></th>
                                    </thead>
                                    <tbody>
                                        <!-- Operating Activities -->
                                        <tr style="background-color: #00693e; font-weight: bold;">
                                            <td colspan="3" style="color: #fff;">Operating Activities</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">Cash receipts from</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>Collections</td>
                                            <td style="text-align: right;"><?php echo number_format($reports['operating_collections'], 2); ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">Cash paid for</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>Salaries</td>
                                            <td style="text-align: right;"><?php echo "( " . number_format($reports['operating_salaries'], 2) . " )"; ?></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>Utilities</td>
                                            <td style="text-align: right;"><?php echo "( " . number_format($reports['operating_utilities'], 2) . " )"; ?></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>Office Supplies</td>
                                            <td style="text-align: right;"><?php echo "( " . number_format($reports['operating_supplies'], 2) . " )"; ?></td>
                                        </tr>
                                        <td></td>
                                            <td>Maintenance Fees</td>
                                            <td style="text-align: right;"><?php echo "( " . number_format($reports['operating_maintenance'], 2) . " )"; ?></td>
                                        </tr>
                                        <tr style="background-color: #fafafa; font-weight: bold;">
                                            <td colspan="2">Net Cash Flow from Operating Activities</td>
                                            <td style="text-align: right;">
<?php
if($reports['net_operating'] < 0)
    echo "( Php " . number_format(abs($reports['net_operating']), 2) . " )";
else
    echo "Php " . number_format($reports['net_operating'], 2);
?>
                                            </td>
                                        </tr>
                                        <!-- Investing Activities -->
                                        <tr style="background-color: #00693e; font-weight: bold;">
                                            <td colspan="3" style="color: #fff;">Investing Activities</td>
                                        </tr>
                                        <tr style="background-color: #fafafa; font-weight: bold;">
                                            <td colspan="2">Net Cash Flow from Investing Activities</td>
                                            <td style="text-align: right;">
<?php
if($reports['net_investing'] < 0)
    echo "( Php " . number_format(abs($reports['net_investing']), 2) . " )";
else
    echo "Php " . number_format($reports['net_investing'], 2);
?>
                                            </td>
                                        </tr>
                                        <!-- Financing Activities -->
                                        <tr style="background-color: #00693e; font-weight: bold;">
                                            <td colspan="3" style="color: #fff;">Financing Activities</td>
                                        </tr>
                                        <tr style="background-color: #fafafa; font-weight: bold;">
                                            <td colspan="2">Net Cash Flow from Financing Activities</td>
                                            <td style="text-align: right;">
<?php
if($reports['net_financing'] < 0)
    echo "( Php " . number_format(abs($reports['net_financing']), 2) . " )";
else
    echo "Php " . number_format($reports['net_financing'], 2);
?>
                                            </td>
                                        </tr>
                                        <!-- Net Change in Cash -->
                                        <tr style="background-color: #fafafa; font-weight: bold;">
                                            <td colspan="2">Net <?php echo $reports['net_change'] < 0 ? 'Decrease' : 'Increase'; ?> in Cash</td>
                                            <td style="text-align: right;">
<?php
if($reports['net_change'] < 0)
    echo "( Php " . number_format(abs($reports['net_change']), 2) . " )";
else
    echo "Php " . number_format($reports['net_change'], 2);
?>
                                            </td>
                                        </tr>
                                        <tr style="text-align: right; font-weight: bold;">
                                            <td colspan="2">Cash at End of Year</td>
                                            <td style="text-align: right;">
<?php
if($reports['profitsThisYear'] < 0)
    echo "( Php " . number_format(abs($reports['profitsThisYear']), 2) . " )";
else
    echo "Php " . number_format($reports['profitsThisYear'], 2);
?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <p>
                                    <small>
                                    Report generated on <?php echo date('M d, Y h:iA', strtotime(date('Y-m-d h:iA') . ' +7 hours')); ?>.<br>
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