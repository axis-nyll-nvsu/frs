<?php
/*
 * Dashboard
 * Description: Dashboard View
 * Author: Vernyll Jan P. Asis, hindi na ito vernyll kasi ako na ang nagcode. :P
 */

session_start();
if (!isset($_SESSION['type'])) {
    header('location: ./');
}

require_once '../config/config.php';
date_default_timezone_set('Asia/Manila');

class Dashboard
{
    private $db;

    public function __construct()
    {
        $conn = new Connection();
        $this->db = $conn->getConnection();
    }

    public function getData()
    {
        $current_month = date('Y-m');

        // Get the Total Revenue for the Current Month
        $sql = "SELECT SUM(amount) AS monthly_revenue FROM frs_collections WHERE DATE_FORMAT(date, '%Y-%m') = ? AND deleted != b'1'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$current_month]);
        $row = $stmt->fetch();
        $current_revenue = $row['monthly_revenue'] ?? 0;

        // Get the Total Expenses for the Current Month
        $sql = "SELECT SUM(amount) AS monthly_expenses FROM frs_expenses WHERE DATE_FORMAT(date, '%Y-%m') = ? AND deleted != b'1'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$current_month]);
        $row = $stmt->fetch();
        $current_expenses = $row['monthly_expenses'] ?? 0;

        // Calculate Monthly Profit
        $current_profit = $current_revenue - $current_expenses;

        // Year from the filter
        $filter_year = isset($_GET['filter_year']) ? $_GET['filter_year'] : date('Y');

        $months = [
            "January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];

        $monthlyRevenues = [];
        $monthlyExpenses = [];

        for ($i = 1; $i <= 12; $i++) {
            $month = str_pad($i, 2, "0", STR_PAD_LEFT);
            $current_month = "$filter_year-$month";

            // Get revenue
            $sql = "SELECT SUM(amount) AS monthly_revenue 
                FROM frs_collections 
                WHERE DATE_FORMAT(date, '%Y-%m') = ? AND deleted != b'1'";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$current_month]);
            $revenue = $stmt->fetch()['monthly_revenue'] ?? 0;

            // Get expenses
            $sql = "SELECT SUM(amount) AS monthly_expenses 
                FROM frs_expenses 
                WHERE DATE_FORMAT(date, '%Y-%m') = ? AND deleted != b'1'";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$current_month]);
            $expenses = $stmt->fetch()['monthly_expenses'] ?? 0;

             // Calculate profit
            $profit = $revenue - $expenses;

            $monthlyProfits[] = $profit;
            $monthlyRevenues[] = $revenue;
            $monthlyExpenses[] = $expenses;
        }
        $profitData = json_encode($monthlyProfits);
        $revenueData = json_encode($monthlyRevenues);
        $expenseData = json_encode($monthlyExpenses);
        $monthsData = json_encode($months);

        $current_month = date('Y-m');
        $period = isset($_GET['filter_year']) && !empty($_GET['filter_year']) ? $_GET['filter_year'] : date('Y');

        // Get the Top 3 Performing Drivers for the Current Month
       
        $sql = "SELECT d.id, CONCAT(d.first_name, ' ', d.last_name) AS driver_name, 
               SUM(c.amount) AS total_amount 
        FROM frs_collections c 
        JOIN frs_drivers d ON c.driver_id = d.id
        WHERE DATE_FORMAT(c.date, '%Y-%m') = ? 
          AND c.deleted != 1 
          AND d.deleted != 1 
        GROUP BY d.id 
        ORDER BY total_amount DESC 
        LIMIT 3";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$current_month]);
        $top_drivers = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $last_month = date('Y-m', strtotime('-1 month'));
        // Get the Total Revenue for the Last Month
        $sql = "SELECT SUM(amount) AS monthly_revenue FROM frs_collections WHERE DATE_FORMAT(date, '%Y-%m') = ? AND deleted != b'1'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$last_month]);
        $row = $stmt->fetch();
        $last_month_revenue = $row['monthly_revenue'] ?? 0;

        // Get the Total Expenses for the Last Month
        $sql = "SELECT SUM(amount) AS monthly_expenses FROM frs_expenses WHERE DATE_FORMAT(date, '%Y-%m') = ? AND deleted != b'1'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$last_month]);
        $row = $stmt->fetch();
        $last_month_expenses = $row['monthly_expenses'] ?? 0;

        // Calculate Last Month's Profit
        $last_month_profit = ($last_month_revenue - $last_month_expenses);
        try {
            $percentage = ($current_profit - $last_month_profit) / abs($last_month_profit) * 100;
        } catch (DivisionByZeroError $e) {
            $percentage = 100;
        }
        $percentage = number_format($percentage, 2);


?>
    
<!DOCTYPE html>
<html style="background-color: #00693e;">

<head>
    <style>
        .chart-container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 90vh;
            margin: 0;
            padding: 0;
        }

        .small-box .icon i {
            font-size: 70px !important;
        }
    canvas {
        width: 100% !important;
        height: 100% !important;
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
                <h1>Dashboard</h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="bi bi-speedometer2"></i> Home</a></li>
                    <li class="active">Dashboard</li>
                </ol>
            </section>

            <section class="content">
                <div class="row">
                    <!-- Revenue Card -->
                    <div class="col-lg-4 col-12">
                        <div class="small-box" style="color:#00693e; background-color: #fff;">
                            <div class="inner">
                                <h3>₱ <?php echo number_format($current_revenue, 2); ?></h3>
                                <p>Monthly Revenue</p>
                            </div>
                            <div class="icon"><i class="bi bi-cash-stack" style="color: #00693e;"></i></div>
                            <a href="#addCollection" data-toggle="modal" class="small-box-footer" style="background-color: #00693e;"><i class="bi bi-plus-circle" style="margin-right: 5px;"></i>Add Collection</a>
                        </div>
                    </div>

                    <!-- Expenses Card -->
                    <div class="col-lg-4 col-12">
                        <div class="small-box" style="color:#00693e; background-color: #fff;">
                            <div class="inner">
                                <h3>₱ <?php echo number_format($current_expenses, 2); ?></h3>
                                <p>Monthly Expenses</p>
                            </div>
                            <div class="icon"><i class="bi bi-credit-card" style="color: #00693e;"></i></div>
                            <a href="#addExpense" data-toggle="modal" class="small-box-footer" style="background-color: #00693e;"><i class="bi bi-plus-circle" style="margin-right: 5px;"></i>Add Expense</a>
                        </div>
                    </div>

                    <!-- Profit Card -->
                    <div class="col-lg-4 col-12">
                        <div class="small-box" style="color:#00693e; background-color: #fff;">
                            <div class="inner">
                                <h3>
                                    <?php
                                    if ($current_profit < 0)
                                        echo "( ₱ " . number_format(abs($current_profit), 2) . " )";
                                    else
                                        echo "₱ " . number_format($current_profit, 2);
                                    ?>
                                </h3>
                                <p>Monthly Profit</p>
                            </div>
                            <div class="icon"><i class="bi bi-cash-coin" style="color: #00693e;"></i></div>
                            <a href="report.php" class="small-box-footer" style="background-color: #00693e;">More Info<i class="bi bi-arrow-right-circle" style="margin-left: 5px;"></i></a>
                        </div>
                    </div>
                </div>
                <div class="row">
                <!-- Chart Section -->
                    <div class="col-lg-8 col-12">
                        <div class="box-header with-border" style="color:#00693e; background-color: #fff;">
                            <div style="position: relative">
                                <form method="GET" action="" id="periodForm" style="display: flex; width: 200px; position: absolute; top: 0; left: 0; z-index: 10;">
                                    <select id="filter_year" name="filter_year" class="axis-form-control" style="margin-right: 3px; background-color: #fff; text-align: center;">
                                        <option value="">Year</option>
                                        <?php
                                            $current_year = date('Y');
                                            for ($i = $current_year; $i >= $current_year - 10; $i--) {
                                                $selected = ($filter_year == $i) ? 'selected' : '';
                                                echo "<option value='$i' $selected>$i</option>";
                                            }
                                        ?>
                                    </select>
                                    <button type="submit" class="btn btn-sm btn-flat axis-btn-green"> Set Period</button>
                                </form>
                                <h3 style="text-align: center; font-weight: bold; margin-top: 0;">Cashflow Trend</h3>
                                <h4 style="text-align: center; font-size: 1em;">For <?= $period ?></h4>
                            </div>
            
                            <div class="chart-container">
                                <canvas id="profitTrend" width="200" height="100"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Top Performing Driver Section -->
                    <div class="col-lg-4 col-12">
                        <div class="small-box" style="color:#00693e; background-color: #fff; height: 100%; display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center; padding: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); border-radius: 8px; border: 1px solid #e0e0e0;">
                            <div class="inner" style="display: flex; align-items: center; justify-content: center; gap: 10px;">
                                <div>
                                    <h4 style="font-weight: bold; color: #00693e; margin: 0;">Top 3 Performing Driver</h4>
                                    <p style="color: #666;">For the month of April</p>
                                </div>
                            </div>
                            <div style="width: 100%; display: flex; justify-content: space-between; align-items: center;">
                                <div style="border-left: 1px solid #00693e; padding-left: 10px; text-align: left; flex: 1;">
                                    <p style="font-size: 18px; color: #00693e; margin: 5px 0;">Driver Name</p>
                                    <?php foreach ($top_drivers as $index => $driver): ?>
                                        <p style="font-size: 15px; font-weight: bold; color: #00693e; margin: 5px 0;">
                                            <?= ($index + 1) . '. ' . htmlspecialchars($driver['driver_name']); ?>
                                        </p>
                                    <?php endforeach; ?>
                                </div>
                                <div style="text-align: right; flex: 1;">
                                    <p style="font-size: 18px; color: #00693e; margin: 5px 0;">Total Collection</p>
                                    <?php foreach ($top_drivers as $driver): ?>
                                        <p style="font-size: 15px; color: #00693e; margin: 5px 0;">
                                            P <?= number_format($driver['total_amount'], 2); ?>
                                        </p>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <!-- Profit Increase na lang ditu -->

                             <!--  singit mo dito -->
                             <h4 style="font-weight: bold; color: #00693e; text-align: center; margin: 0 0 10px 0;">Profit Tracker</h4>
                             <div style="width: 100%; display: flex; justify-content: space-between; align-items: center;">
                                <div style="border-left: 1px solid #00693e; padding-left: 10px; text-align: left; flex: 1;">
                                    <p style="color: #00693e; margin: 5px 0;">This month's profit:</p>
                                    <p style="font-weight: bold; font-size: 24px; color: #00693e; margin: 0;">
                                        <?php
                                            if ($current_profit < 0)
                                                echo "( ₱ " . number_format(abs($current_profit), 2) . " )";
                                            else
                                                echo "₱ " . number_format($current_profit, 2);
                                        ?>
                                    </p>
                                    <p style="color: #00693e; margin: 5px 0;">Last month's profit:</p>
                                    <p style="font-size: 15px; color: #00693e; margin: 0; padding-bottom: 20px;">
                                            <?php
                                                if ($last_month_profit < 0)
                                                    echo "( ₱ " . number_format(abs($last_month_profit), 2) . " )";
                                                else
                                                    echo "₱ " . number_format($last_month_profit, 2);
                                            ?>
                                        </p>
                                </div>
                                <div style="text-align: right; flex: 1;">
                                    <p style="font-size: 28px; font-weight: bold; padding-bottom: 32px;
                                        <?php echo ($percentage < 0) ? 'color: red;' : 'color: green;'; ?>">
                                        <?php echo ($percentage > 0) ? "+" . $percentage . "%" : $percentage . "%"; ?>
                                    </p>
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
    <?php include '../modal/addCollectionModal.php' ?>
    <?php include '../modal/addDriverModal.php' ?>
    <?php include '../modal/addEjeepModal.php' ?>
    <?php include '../modal/addRouteModal.php' ?>
    <?php include '../modal/addExpenseModal.php' ?>
    <?php include '../modal/addCategoryModal.php' ?>
    <script>
    $(document).ready(function() {
        $("#date").datepicker();
        $("#driver_id").select2();
        $("#ejeep_id").select2();
        $("#route_id").select2();
        $("#rate_id").select2();
        $("#category_id").select2();
    });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
        var ctx = document.getElementById('profitTrend').getContext('2d');

        var profitData = <?php echo $profitData; ?>;
        var revenueData = <?php echo $revenueData; ?>;
        var expenseData = <?php echo $expenseData; ?>;
        var months = <?php echo $monthsData; ?>;

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: months,
                datasets: [
                    {
                        label: 'Revenue',
                        data: revenueData,
                        borderColor: 'blue',
                        backgroundColor: 'rgba(0, 0, 255, 0.2)',
                        borderWidth: 2,
                        fill: true
                    },
                    {
                        label: 'Expenses',
                        data: expenseData,
                        borderColor: 'red',
                        backgroundColor: 'rgba(255, 0, 0, 0.2)',
                        borderWidth: 2,
                        fill: true
                    },
                    {
                        label: 'Profit',
                        data: profitData,
                        borderColor: 'green',
                        backgroundColor: 'rgba(0, 128, 0, 0.2)',
                        borderWidth: 2,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
    </script>
<?php
    }
}
$dashboard = new Dashboard();
$dashboard->getData();
?>
</body>
</html>
