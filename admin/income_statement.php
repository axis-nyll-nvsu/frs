<?php
/*
 * Income Statement
 * Description: Income Statement View
 * Author: Vernyll Jan P. Asis
 */

session_start();
if(!isset($_SESSION['type'])) {
    header('location: ./');
}

require_once '../config/config.php';
date_default_timezone_set('Asia/Manila');
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
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

<?php include '../common/navbar.php'; ?>
<?php include '../common/sidebar.php'; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header -->
        <section class="content-header">
            <h1>Reports &mdash; Income Statement</h1>
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="bi bi-speedometer2"></i> Home</a></li>
                <li>Reports</li>
                <li class="active">Income Statement</li>
            </ol>
        </section>

        <!-- Main Content -->
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
                                                if($year == $period) echo 'selected';
                                                echo '>Fiscal Year: ' . $year . '</option>';
                                                $year--;
                                            }
                                        ?>
                                    </select>
                                    <button type="submit" class="btn btn-sm btn-flat axis-btn-green"> Set Period</button>
                                </form>
                                <h3 style="text-align: center; font-weight: bold; margin-top: 0;">Income Statement</h3>
                                <a href="income_statement_print.php?period=<?php echo $period; ?>" class="btn btn-sm btn-flat axis-btn-green" style="position: absolute; top: 0; right: 0;" target="_blank"><i class="bi bi-printer"></i> Print Income Statement</a>
                                <h4 style="text-align: center; font-size: 1em;">For the Year Ending <?php echo "Dec 31, " . $period; ?></h4>
                            </div>
                        </div>
                        <div class="box-body table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th style="width: 30px; max-width: 30px !important;"></th>
                                    <th></th>
                                    <th style="width: 200px; max-width: 200px !important;"></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr style="background-color: #00693e;">
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
                                <tr style="background-color: #00693e;">
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
                                Report generated on <?php echo date('F d, Y h:iA', strtotime(date('Y-m-d h:iA') . ' +7 hours')); ?>.<br>
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
<?php include '../modal/profileModal.php'; ?>
<?php
}
}
$report = new Report(); $report->getData();
?>
</body>
</html>