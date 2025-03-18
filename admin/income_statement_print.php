<?php
/*
 * Income Statement Print
 * Description: Income Statement Print
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
        if(isset($_GET['period'])) {
            $period = $_GET['period'];
        }

        $revenue_sql =  "SELECT SUM(`amount`) AS revenues
                        FROM `frs_collections` WHERE YEAR(`date`) = ? AND `deleted` != b'1'";

        $revenue_stmt = $this->db->prepare($revenue_sql);
        $revenue_stmt->execute([$period]);
        $row = $revenue_stmt->fetch(PDO::FETCH_ASSOC);
        $total_revenues = $row['revenues'] ?? 0;

        $expense_sql =  "SELECT a.`description`, b.`expenses`
                        FROM `frs_categories` AS a
                        LEFT JOIN (
                            SELECT `category_id`, SUM(`amount`) AS expenses
                            FROM `frs_expenses` WHERE `deleted` != b'1' AND YEAR(`date`) = ? GROUP BY `category_id`
                        ) AS b
                        ON a.`id` = b.`category_id`
                        GROUP BY a.`description`";

        $expense_stmt = $this->db->prepare($expense_sql);
        $expense_stmt->execute([$period]);
        $expenses = $expense_stmt->fetchAll(PDO::FETCH_ASSOC);

        $total_expenses = array_sum(array_column($expenses, 'expenses'));
        $total_profits = $total_revenues - $total_expenses;
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
                                <h3 style="text-align: center; font-weight: bold; margin-top: 0;">Income Statement</h3>
                                <h4 style="text-align: center; font-size: 1em;">For the Year Ending <?php echo "Dec 31, " . $period; ?></h4>
                            </div>
                        </div>
                        <div class="box-body table-responsive">
                            <table class="table">
                                <thead>
                                <th style="width: 30px; max-width: 30px !important;"></th>
                                <th></th>
                                <th style="width: 200px; max-width: 200px !important;"></th>
                                </thead>
                                <tbody>
                                <tr style="background-color: #00693e; font-weight: bold;">
                                    <td colspan="3" style="color: #fff;">Revenues</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>Collections</td>
                                    <td style="text-align: right;"><?php echo number_format($total_revenues, 2); ?></td>
                                </tr>
                                <tr style="background-color: #fafafa; font-weight: bold;">
                                    <td colspan="2">Total Revenues</td>
                                    <td style="text-align: right;"><?php echo "Php " . number_format($total_revenues, 2); ?></td>
                                </tr>
                                <tr style="background-color: #00693e; font-weight: bold;">
                                    <td colspan="3" style="color: #fff;">Expenses</td>
                                </tr>
<?php foreach ($expenses as $expense): ?>
<tr>
    <td></td>
    <td><?php echo htmlspecialchars($expense['description']); ?></td>
    <td style="text-align: right;"><?php echo number_format($expense['expenses'], 2); ?></td>
</tr>
<?php endforeach; ?>
                                <tr style="background-color: #fafafa; font-weight: bold;">
                                    <td colspan="2">Total Expenses</td>
                                    <td style="text-align: right;"><?php echo "Php " . number_format($total_expenses, 2); ?></td>
                                </tr>
                                <tr style="background-color: #fafafa; font-weight: bold;">
                                    <td colspan="2">Net <?php echo $total_profits < 0 ? 'Loss' : 'Income'; ?></td>
                                    <td style="text-align: right;">
<?php
if($total_profits < 0)
    echo "( Php " . number_format(abs($total_profits), 2) . " )";
else
    echo "Php " . number_format($total_profits, 2);
?>
                                    </td>
                                </tr>
                                </tbody>
                            </table><br>
                            <p>
                                <small>
                                Report generated on <?php echo date('M d, Y h:iA', strtotime(date('Y-m-d h:iA') . ' +7 hours')); ?>.<br>
                                    Disclaimer: The data presented is based on the information available in the system at the time of generation and may be subject to change.
                                </small><br>
                            </p>
                        </div>
                    </div> <!-- /.box -->
                </div>
            </div>
        </section>
    </div>
</div>

<?php include '../common/footer.php'; ?>
<?php
}
}
$report = new Report(); $report->getData();
?>

<script>
    window.print();
    window.onafterprint = window.close;
</script>
</body>
</html>