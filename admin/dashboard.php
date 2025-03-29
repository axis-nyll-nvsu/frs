<?php
/*
 * Dashboard
 * Description: Dashboard View
 * Author: Vernyll Jan P. Asis
 */

    session_start();
    if(!isset($_SESSION['type'])) {
        header('location: ./');
    }

 require_once '../config/config.php';
    class Dashboard {
        private $db;

        public function __construct() {
                $conn = new Connection();
                $this->db = $conn->getConnection();
        }

        public function getData(){ 
            
            
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

?>
<!DOCTYPE html>
<html style="background-color: #00693e;">
<head>
<style>
        #revenueVSexpenses {
            width: 250px !important; 
            height: 250px !important;
        }
        .chart-container {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .small-box .icon i {
            font-size: 70px !important; 
        }
</style>
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
        <h1>Dashboard</h1>
        <ol class="breadcrumb">
        <li><a href="#"><i class="bi bi-speedometer2"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
        </section>

        <!-- Main Content -->
        <section class="content">
        <div class="row">
            <!-- Revenue Card -->
            <div class="col-lg-4 col-12">
            <div class="small-box" style="color:#00693e; border-top: 3px solid rgba(0, 0, 0, 0.1); background-color: #fff;">
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
            <div class="small-box" style="color:#00693e; border-top: 3px solid rgba(0, 0, 0, 0.1); background-color: #fff;">
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
            <div class="small-box" style="color:#00693e; border-top: 3px solid rgba(0, 0, 0, 0.1); background-color: #fff;">
                <div class="inner">
                <h3>
                    <?php
                        if($current_profit < 0)
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
        <div>
        <table border="1" style="width: 100%; background-color: #fff;">
        <tr style="text-align: center;">
                <td rowspan="2" style ="width: 60%; height: 380px;">
                        <h3 style = "font-weight:bold; color: #00693e;"> Profit Trend</h3>
                        <div class="line-chart">
                        <canvas id="profitTrend" width="400" height="300"></canvas>
                        </div>

                </td>
                <td style="width: 40%; height: 150px; align-items: center;">
                        <h4 style ="display: inline;"> Revenue vs. Expenses: </h4>
                        <h3 style = "font-weight:bold; color: #00693e; display: inline;"> <?php echo date("F"); ?> </h3> 
                        <div class="chart-container">
                        <canvas id="revenueVSexpenses"></canvas>
                        </div>
                </td>
                
            </tr>
            <tr style="text-align: center; height: 80px;">
                    <td style = "vertical-align: middle;">
                        <p>Profit Increase from the previous month:</p>
                            <h3 style = "font-weight:bold; color: #00693e;"> <?php echo number_format($profit_increase, 2) . "%"; ?></h3>
                    </td>
            </tr>
    </table>
    </div>

        </section>
    </div>
</div>
<?php include '../common/footer.php'; ?>
<?php include '../modal/profileModal.php'; ?>
<?php include '../modal/addCollectionModal.php'; ?>
<?php include '../modal/addExpenseModal.php'; ?>
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
var ctx = document.getElementById('revenueVSexpenses').getContext('2d');
var myPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
        labels: [ "<?php echo number_format($revenue_percentage, 2); ?>% Revenue",
            "<?php echo number_format($expenses_percentage, 2); ?>% Expenses"
            ],
        datasets: [{
            data:[<?php echo number_format($revenue_percentage, 2); ?>, <?php echo number_format($expenses_percentage, 2); ?>],
            backgroundColor: ['#00693e', '#eeff36']
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: true
            }
        }
    }
});

var ctx = document.getElementById('profitTrend').getContext('2d');

var myLineChart = new Chart(ctx, {
    type: 'line',    // Chart type
    data: {
        labels: <?php echo json_encode($months); ?>,    // X-axis labels
        datasets: [{
            label: 'Monthly Profits',
            data: <?php echo json_encode($monthlyProfits); ?>,    // Y-axis values
            borderColor: 'green',    // Line color
            backgroundColor: 'rgba(10, 136, 59, 0.2)', // Fill under the line
            borderWidth: 2,    // Line thickness
            pointRadius: 3, // Size of data points
            pointBackgroundColor: '#00693e', // Color of data points
            fill: true,    // Enable fill under the line
            lineTension: 0.4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        bezierCurve: true,
        scales: {
            x: {
                title: {
                    display: true,
                    text: 'Months'
                }
            },
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Profit (in thousands)'
                }
            }
        }
    }
});
</script>
<?php
    }
}
$dashboard = new Dashboard(); $dashboard->getData();
?>
</body>
</html>