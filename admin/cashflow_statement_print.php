<?php
/*
 * Cash Flow Statement
 * Description: Cash Flow Statement Print
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
        $operating_revenues = 0;
        $q_sql = "SELECT COALESCE(SUM(amount), 0) AS total
        FROM frs_collections
        WHERE YEAR(date) = ? AND deleted != b'1'";
        $q_stmt = $this->db->prepare($q_sql);
        $q_stmt->execute([$period]);
        $operating_revenues = $q_stmt->fetch(PDO::FETCH_ASSOC)['total'];

        $operating_expenses = [];
        $q_sql =    "SELECT a.`description`, b.`total`
                    FROM `frs_categories` AS a
                    LEFT JOIN (
                        SELECT `category_id`, SUM(`amount`) AS total
                        FROM `frs_expenses` WHERE `deleted` != b'1' AND YEAR(`date`) = ? GROUP BY `category_id`
                    ) AS b
                    ON a.`id` = b.`category_id`
                    WHERE a.`type` = 'O'
                    GROUP BY a.`type`, a.`description`";
        $q_stmt = $this->db->prepare($q_sql);
        $q_stmt->execute([$period]);
        $operating_expenses = $q_stmt->fetchAll(PDO::FETCH_ASSOC);

        $net_operating = 0;
        $net_operating += $operating_revenues;
        foreach($operating_expenses as $expense) {
            $net_operating -= $expense['total'];
        }

        $investing_expenses = [];
        $q_sql =    "SELECT a.`description`, b.`total`
                    FROM `frs_categories` AS a
                    LEFT JOIN (
                        SELECT `category_id`, SUM(`amount`) AS total
                        FROM `frs_expenses` WHERE `deleted` != b'1' AND YEAR(`date`) = ? GROUP BY `category_id`
                    ) AS b
                    ON a.`id` = b.`category_id`
                    WHERE a.`type` = 'I'
                    GROUP BY a.`type`, a.`description`";
        $q_stmt = $this->db->prepare($q_sql);
        $q_stmt->execute([$period]);
        $investing_expenses = $q_stmt->fetchAll(PDO::FETCH_ASSOC);

        $net_investing = 0;
        foreach($investing_expenses as $expense) {
            $net_investing -= $expense['total'];
        }

        $financing_expenses = [];
        $net_financing = 0;
        foreach($financing_expenses as $expense) {
            $net_financing -= $expense['total'];
        }

        $net_change = 0;
        $net_change += $net_operating + $net_investing + $net_financing;

        $profitsThisYear = $profitsLastYear + $net_change;

        $data = [
            'period' => $period,
            'profitsLastYear' => $profitsLastYear,
            'operating_revenues' => $operating_revenues,
            'operating_expenses' => $operating_expenses,
            'net_operating' => $net_operating,
            'investing_expenses' => $investing_expenses,
            'net_investing' => $net_investing,
            'financing_expenses' => $financing_expenses,
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
                                <h3 style="text-align: center; font-weight: bold; margin-top: 0;">Statement of Cash Flows</h3>
                                <h4 style="text-align: center; font-size: 1em;">For the Year Ending <?php echo "Dec 31, " . $reports['period']; ?></h4>
                            </div>
                        </div>
                        <div class="box-body table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th style="width: 30px; max-width: 30px !important;"></th>
                                        <th></th>
                                        <th style="width: 150px; max-width: 150px !important;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr style="text-align: right; font-weight: bold;">
                                        <td></td>
                                        <td>Cash at Beginning of Year</td>
                                        <td>
<?php
if($reports['profitsLastYear'] < 0)
    echo "( Php " . number_format(abs($reports['profitsLastYear']), 2) . " )";
else
    echo "Php " . number_format($reports['profitsLastYear'], 2);
?>
                                        </td>
                                    </tr>
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
                                        <td style="text-align: right;"><?php echo number_format($reports['operating_revenues'], 2); ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">Cash paid for</td>
                                    </tr>
<?php foreach($reports['operating_expenses'] as $expense) { ?>
<tr>
    <td></td>
    <td><?php echo $expense['description']; ?></td>
    <td style="text-align: right;">
<?php
if($expense['total'] > 0)
    echo "( " . number_format(abs($expense['total']), 2) . " )";
else
    echo number_format($expense['total'], 2);
?>
    </td>
</tr>
<?php } ?>
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
                                    <tr>
                                        <td colspan="3">Cash paid for</td>
                                    </tr>
<?php if(!$reports['investing_expenses']): ?>
<tr>
    <td></td>
    <td><em>None.</em></td>
    <td style="text-align: right;">0.00</td>
</tr>
<?php endif; ?>
<?php foreach($reports['investing_expenses'] as $expense) { ?>
<tr>
    <td></td>
    <td><?php echo $expense['description']; ?></td>
    <td style="text-align: right;">
<?php
if($expense['total'] > 0)
    echo "( " . number_format(abs($expense['total']), 2) . " )";
else
    echo number_format($expense['total'], 2);
?>
    </td>
</tr>
<?php } ?>
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
                                    <tr>
                                        <td colspan="3">Cash paid for</td>
                                    </tr>
<?php if(!$reports['financing_expenses']): ?>
<tr>
    <td></td>
    <td><em>None.</em></td>
    <td style="text-align: right;">0.00</td>
    </tr>
<?php endif; ?>
<?php foreach($reports['financing_expenses'] as $expense) { ?>
<tr>
    <td></td>
    <td><?php echo $expense['description']; ?></td>
    <td style="text-align: right;">
<?php
if($expense['total'] > 0)
    echo "( " . number_format(abs($expense['total']), 2) . " )";
else
    echo number_format($expense['total'], 2);
?>
    </td>
</tr>
<?php } ?>
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
    window.print();
    window.onafterprint = window.close;
</script>
</body>
</html>