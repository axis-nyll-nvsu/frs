<?php
/*
 * Monthly Profit
 * Description: Monthly Profit View
 * Author: Vernyll Jan P. Asis
 */

session_start();
if (!isset($_SESSION['type'])) {
    header('location: ./');
}

require_once '../config/config.php';

class Profit {
    private $db;

    public function __construct() {
        $conn = new Connection();
        $this->db = $conn->getConnection();
    }

    public function getData($filter_year = null, $filter_month = null) {
        // Expenses Query
        $expenses_sql = "
        SELECT DATE_FORMAT(a.`date`, '%Y-%m') AS `month`, 
               b.`description` AS `category`,
               SUM(a.`amount`) AS `total_expense`
        FROM `frs_expenses` AS a
        INNER JOIN `frs_categories` AS b ON a.`category_id` = b.`id`
        WHERE a.`deleted` != b'1'";

        if ($filter_year) {
            $expenses_sql .= " AND YEAR(a.`date`) = :filter_year";
        }
        if ($filter_month) {
            $expenses_sql .= " AND MONTH(a.`date`) = :filter_month";
        }

        $expenses_sql .= " GROUP BY `month`, `category` ORDER BY `month` DESC, `category` ASC";
        
        $stmt_expenses = $this->db->prepare($expenses_sql);

        if ($filter_year) {
            $stmt_expenses->bindParam(':filter_year', $filter_year, PDO::PARAM_INT);
        }
        if ($filter_month) {
            $stmt_expenses->bindParam(':filter_month', $filter_month, PDO::PARAM_INT);
        }

        $stmt_expenses->execute();
        $expenses = $stmt_expenses->fetchAll(PDO::FETCH_ASSOC);

        // Collections Query
        $collections_sql = "
        SELECT DATE_FORMAT(a.`date`, '%Y-%m') AS `month`, 
               c.`plate` AS `plate_number`,
               SUM(a.`amount`) AS `total_collection`
        FROM `frs_collections` AS a
        INNER JOIN `frs_drivers` AS b ON a.`driver_id` = b.`id`
        INNER JOIN `frs_ejeeps` AS c ON a.`ejeep_id` = c.`id`
        INNER JOIN `frs_routes` AS d ON a.`route_id` = d.`id`
        WHERE a.`deleted` != b'1'";

        if ($filter_year) {
            $collections_sql .= " AND YEAR(a.`date`) = :filter_year";
        }
        if ($filter_month) {
            $collections_sql .= " AND MONTH(a.`date`) = :filter_month";
        }

        $collections_sql .= " GROUP BY `month`, `plate_number` ORDER BY `month` DESC, `plate_number` ASC";

        $stmt_collections = $this->db->prepare($collections_sql);

        if ($filter_year) {
            $stmt_collections->bindParam(':filter_year', $filter_year, PDO::PARAM_INT);
        }
        if ($filter_month) {
            $stmt_collections->bindParam(':filter_month', $filter_month, PDO::PARAM_INT);
        }

        $stmt_collections->execute();
        $collections = $stmt_collections->fetchAll(PDO::FETCH_ASSOC);

        // Calculate Totals
        $total_expenses = array_sum(array_column($expenses, 'total_expense'));
        $total_collections = array_sum(array_column($collections, 'total_collection'));
        $total_profit = $total_collections - $total_expenses;

        // Format the period for display
        $month_name = $filter_month ? date('F', mktime(0, 0, 0, $filter_month, 1)) : '';
        $period = ($filter_year ? $month_name . ' ' . $filter_year : 'All Time');

        return [
            'period' => $period,
            'expenses' => $expenses,
            'collections' => $collections,
            'total_expenses' => $total_expenses,
            'total_collections' => $total_collections,
            'total_profit' => $total_profit
        ];
    }
}

$profit = new Profit();

// Get year and month filters
$filter_year = $_GET['filter_year'] ?? null;
$filter_month = $_GET['filter_month'] ?? null;

$data = $profit->getData($filter_year, $filter_month);
?>

<!DOCTYPE html>
<html lang="en" style="background-color: #00693e;">
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

    <div class="content-wrapper" style="width: 100%; margin-left: 0; margin-top: 0;">

        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <div style="text-align: center; font-weight: bold; margin-top: 0;">
                                <img src="../images/logo.png" alt="" style="width: 100px; margin: 20px;" />
                                <p style="font-size: 1.2em;">First Novo Vizcayano Travellers Transport Cooperative</p>
                                <h4 style="font-size: 1em;">Solano, Nueva Vizcaya</h4>
                            </div>
                            <h3 style="text-align: center; font-weight: bold;">Monthly Profit Statement</h3>
                            <h4 style="text-align: center;"><?= $data['period'] ?></h4>
                        </div>

                        <div class="box-body table-responsive">
                            <!-- Collection Table -->
                            <h4>Monthly Collection</h4>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>E-jeep</th>
                                        <th>Total Collection</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data['collections'] as $index => $row): ?>
                                    <tr>
                                        <td><?= $index + 1 ?></td>
                                        <td><?= $row['plate_number'] ?></td>
                                        <td style="text-align: right;">Php <?= number_format($row['total_collection'], 2) ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <tr>
                                    <td colspan="2" style="text-align: right;">Total:</td>
                                    <td style="text-align: right;">Php <?= number_format($data['total_collections'], 2) ?></td>
                                    </tr>
                                </tbody>
                            </table>

                            <!-- Expense Table -->
                            <h4>Monthly Expenses</h4>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Category</th>
                                        <th>Total Expense</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data['expenses'] as $index => $row): ?>
                                    <tr>
                                        <td><?= $index + 1 ?></td>
                                        <td><?= $row['category'] ?></td>
                                        <td style="text-align: right;">Php <?= number_format($row['total_expense'], 2) ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <tr>
                                    <td colspan="2" style="text-align: right;">Total:</td>
                                    <td style="text-align: right;">Php <?= number_format($data['total_expenses'], 2) ?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <!-- summary table -->
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th  style="text-align: right;">Summary</th>
                                        <th  style="text-align: right;">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td style="text-align: right;">Total Collection</td>
                                        <td style="text-align: right;">Php <?= number_format($data['total_collections'], 2) ?></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td style="text-align: right;">Total Expenses</td>
                                        <td style="text-align: right;">Php <?= number_format($data['total_expenses'], 2) ?></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td style="text-align: right;">Balance</td>
                                        <td style="text-align: right;">Php <?= number_format($data['total_profit'], 2) ?></td>
                                    </tr>
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
<script>
    window.print();
    window.onafterprint = window.close;
</script>
</body>
</html>
