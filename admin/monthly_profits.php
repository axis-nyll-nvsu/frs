<?php
/*
 * Monthly Profits
 * Description: Monthly Profits View
 * Author: Charlene B. Dela Cruz
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

    // Get expenses with optional year and month filters
    public function getExpenses($filter_year = null, $filter_month = null) {
        $query = "
        SELECT DATE_FORMAT(a.`date`, '%Y-%m') AS `month`, 
               b.`description` AS `category`,
               SUM(a.`amount`) AS `total_expense`
        FROM `frs_expenses` AS a
        INNER JOIN `frs_categories` AS b 
            ON a.`category_id` = b.`id`
        WHERE a.`deleted` != b'1'";

        if ($filter_year) {
            $query .= " AND YEAR(a.`date`) = :filter_year";
        }
        if ($filter_month) {
            $query .= " AND MONTH(a.`date`) = :filter_month";
        }

        $query .= "
        GROUP BY `month`, `category`
        ORDER BY `month` DESC, `category` ASC";

        $stmt = $this->db->prepare($query);

        if ($filter_year) {
            $stmt->bindParam(':filter_year', $filter_year, PDO::PARAM_INT);
        }
        if ($filter_month) {
            $stmt->bindParam(':filter_month', $filter_month, PDO::PARAM_INT);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get collections with optional year and month filters
    public function getCollections($filter_year = null, $filter_month = null) {
        $query = "
        SELECT DATE_FORMAT(a.`date`, '%Y-%m') AS `month`, 
               c.`plate` AS `plate_number`,
               SUM(a.`amount`) AS `total_collection`
        FROM `frs_collections` AS a
        INNER JOIN `frs_drivers` AS b 
            ON a.`driver_id` = b.`id`
        INNER JOIN `frs_ejeeps` AS c 
            ON a.`ejeep_id` = c.`id`
        INNER JOIN `frs_routes` AS d 
            ON a.`route_id` = d.`id`
        WHERE a.`deleted` != b'1'";

        if ($filter_year) {
            $query .= " AND YEAR(a.`date`) = :filter_year";
        }
        if ($filter_month) {
            $query .= " AND MONTH(a.`date`) = :filter_month";
        }

        $query .= "
        GROUP BY `month`, `plate_number`
        ORDER BY `month` DESC, `plate_number` ASC";

        $stmt = $this->db->prepare($query);

        if ($filter_year) {
            $stmt->bindParam(':filter_year', $filter_year, PDO::PARAM_INT);
        }
        if ($filter_month) {
            $stmt->bindParam(':filter_month', $filter_month, PDO::PARAM_INT);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

$profit = new Report();

// Get year and month filters from the form
$filter_year = isset($_GET['filter_year']) ? $_GET['filter_year'] : null;
$filter_month = isset($_GET['filter_month']) ? $_GET['filter_month'] : null;

$expenses = $profit->getExpenses($filter_year, $filter_month);
$collections = $profit->getCollections($filter_year, $filter_month);

// Initialize total expenses and collections
$total_expenses = 0;
$total_collections = 0;

// Calculate total expenses
foreach ($expenses as $expense) {
    $total_expenses += $expense['total_expense'];
}

// Calculate total collections
foreach ($collections as $collection) {
    $total_collections += $collection['total_collection'];
}

// Calculate profit
$total_profit = $total_collections - $total_expenses;

$period = date('M Y');
?>

<!DOCTYPE html>
<html lang="en" style="background-color: #00693e;">
<head>
    <?php include '../common/head.php'; ?>
    <style>
        .filter-container {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 0px;
        }
        .filter-container select, .filter-container button {
            height: 38px;
        }
    </style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php include '../common/navbar.php'; ?>
        <?php include '../common/sidebar.php'; ?>
        <!-- Content Header -->

        <div class="content-wrapper">
        <section class="content-header">
            <h1>Reports &mdash; Monthly Profits</h1>
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="bi bi-speedometer2"></i> Home</a></li>
                <li>Reports</li>
                <li class="active">Monthly Profits</li>
            </ol>
        </section>
        <!-- Filter Form -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <div style="position: relative;">
                                <form method="GET" action="" class="filter-container" style="display: flex; width:245px; position: absolute; top: 0; left: 0; z-index: 10;">
                                <!-- Year Filter -->
                                    <select id="filter_year" name="filter_year" class="axis-form-control" style="margin-right: 3px; ">
                                        <option value="">Year</option>
                                        <?php
                                            $current_year = date('Y');
                                            for ($i = $current_year; $i >= $current_year - 10; $i--) {
                                                $selected = (isset($_GET['filter_year']) && $_GET['filter_year'] == $i) ? 'selected' : '';
                                                echo "<option value='$i' $selected>$i</option>"; }
                                        ?>
                                    </select>
                                    <!-- Month Filter -->
                                    <select id="filter_month" name="filter_month" class="axis-form-control" style="width: 150px;">
                                        <option value="">Month</option>
                                        <?php
                                            for ($i = 1; $i <= 12; $i++) {
                                                $month_value = str_pad($i, 2, '0', STR_PAD_LEFT);
                                                $month_name = date('F', mktime(0, 0, 0, $i, 1));
                                                $selected = (isset($_GET['filter_month']) && $_GET['filter_month'] == $month_value) ? 'selected' : '';
                                                echo "<option value='$month_value' $selected>$month_name</option>";
                                            }
                                        ?>
                                    </select>
                                    <!-- Filter and Reset Buttons -->
                                    <button type="submit" class="btn btn-sm btn-flat axis-btn-green">Filter</button>
                                    <button type="reset" class="btn btn-sm btn-flat axis-btn-green">Reset</button>

                                </form>
                    
                                    <h3 style="text-align: center; font-weight: bold; margin-top: 30px;">Monthly Profits</h3>
                                    <h4 style="text-align: center; font-size: 1em;">
                                        For the Month of 
                                        <?php 
                                            if (isset($_GET['filter_month']) && isset($_GET['filter_year']) && $_GET['filter_year'] && $_GET['filter_month']) {
                                                echo date('F Y', mktime(0, 0, 0, $_GET['filter_month'], 1, $_GET['filter_year']));
                                            } else {
                                                echo "All Periods";
                                            }
                                        ?>
                                    </h4>
                                        <!-- profit table -->
                                        <table class="table">
                                            <thead>
                                                <tr style="line-height: 1; padding: 5px 0;">
                                                    <th>Total Collection</th>
                                                    <th>Total Expenses</th>
                                                    <th>Total Profit</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr style="line-height: 1; padding: 5px 0;">
                                                    <td style="font-size: 20px;">Php <?= number_format($total_collections, 2); ?></td>
                                                    <td style="font-size: 20px;">Php <?= number_format($total_expenses, 2); ?></td>
                                                        <?php $total_profit = $total_collections - $total_expenses; ?>
                                                    <td style="font-size: 20px; font-weight:bold;">Php <?= number_format($total_profit, 2); ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                            <h4>Monthly Expenses</h4>
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <div class="box">
                                                        <div class="box-body table-responsive">
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Month</th>
                                                                        <th>Category</th>
                                                                        <th>Total Expenses</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php 
                                                                        $id = 1; 
                                                                        $total_expenses = 0; 
                                                                    ?>
                                                                    <?php foreach ($expenses as $row): ?>
                                                                    <tr>
                                                                        <td><?= $id++; ?></td>
                                                                        <td><?= $row['month']; ?></td>
                                                                        <td><?= $row['category']; ?></td>
                                                                        <td style="text-align: right;">Php <?= number_format($row['total_expense'], 2); ?></td>
                                                                    </tr>
                                                                        <?php $total_expenses += $row['total_expense']; ?>
                                                                        <?php endforeach; ?>
                                                                    <tr style="font-weight: bold; background-color: #f2f2f2;">
                                                                        <td colspan="3" style="text-align: right;">Grand Total:</td>
                                                                        <td style="text-align: right;">Php <?= number_format($total_expenses, 2); ?></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>    
                                                        </div>
                                                    </div>
                                                </div>
                                                    <h4>Monthly Collection</h4>
                                                    <div class="row">
                                                        <div class="col-xs-12">
                                                            <div class="box">
                                                                <div class="box-body table-responsive">
                                                                    <table class="table table-bordered">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>#</th>
                                                                                <th>Month</th>
                                                                                <th>Plate Number</th>
                                                                                <th>Total Collection</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php 
                                                                            $id = 1; 
                                                                            $total_collections = 0; 
                                                                            ?>
                                                                            <?php foreach ($collections as $row): ?>
                                                                            <tr>
                                                                                <td><?= $id++; ?></td>
                                                                                <td><?= $row['month']; ?></td>
                                                                                <td><?= $row['plate_number']; ?></td>
                                                                                <td style="text-align: right;">Php <?= number_format($row['total_collection'], 2); ?></td>
                                                                            </tr>
                                                                                <?php $total_collections += $row['total_collection']; ?>
                                                                                <?php endforeach; ?>
                                                                            <tr style="font-weight: bold; background-color: #f2f2f2;">
                                                                                <td colspan="3" style="text-align: right;">Grand Total:</td>
                                                                                <td style="text-align: right;">Php <?= number_format($total_collections, 2); ?></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
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
