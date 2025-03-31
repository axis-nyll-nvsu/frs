<?php
/*
 * Dashboard
 * Description: Dashboard View
 * Author: Vernyll Jan P. Asis
 */

session_start();
if (!isset($_SESSION['type'])) {
    header('location: ./');
}

require_once '../config/config.php';

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

        $monthlyProfits = [];

        // Loop through each month to calculate the profit
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
        }
        $current_month = date('F');
        $period = isset($_GET['filter_year']) && !empty($_GET['filter_year']) ? $_GET['filter_year'] : date('Y');
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
                                <h3 style="text-align: center; font-weight: bold; margin-top: 0;">Profit Trend</h3>
                                <h4 style="text-align: center; font-size: 1em;">For <?= $period ?></h4>
                            </div>
            
                            <div class="chart-container">
                                <canvas id="profitTrend" width="200" height="100"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Top Performing Driver Section -->
                    <div class="col-lg-4 col-12">
                    <div class="small-box" style="color:#00693e; background-color: #fff; height: 100%; display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center; padding: 20px;">
                        <div class="inner" style="display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-person-arms-up" style="font-size: 50px; color: #00693e;"></i>
                            <h4 style="font-size: 18px; font-weight: bold; color: #00693e; margin: 0;">Top 3 Performing Driver</h4>
                        </div>
                        <p>For the month of <?= $current_month ?></p>
                        <div style="display: flex; align-items: center; justify-content: center;">
                            <p style="font-size: 18px; font-weight: bold; color: #00693e; margin: 0;">Juan Santos</p>
                            <p style="font-size: 18px; font-weight: bold; color: #00693e; margin: 0;">Jose Dela Cruz</p>
                            <p style="font-size: 18px; font-weight: bold; color: #00693e; margin: 0;">Pedro Reyes</p>
                        </div>
                    </div>
                </div>
            </div>
            </section>
        </div>
    </div>

    <?php include '../common/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('profitTrend').getContext('2d');
        var myLineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($months); ?>,
                datasets: [{
                    label: 'Monthly Profit',
                    data: <?php echo json_encode($monthlyProfits); ?>,
                    borderColor: 'green',
                    backgroundColor: 'rgba(10, 136, 59, 0.2)',
                    borderWidth: 2,
                    pointRadius: 4,
                    pointBackgroundColor: '#00693e',
                    fill: true
                }]
            }
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
