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
      $today = date('Y-m-d');
      
      /* Revenue from Collections */
      $sql = "SELECT SUM(`amount`) AS `daily_revenue` FROM `frs_collections` WHERE date(`date`) = '" . $today . "' AND `deleted` != b'1'";
      $stmt = $this->db->query($sql);
      $row = $stmt->fetch();
      $revenue = $row['daily_revenue'];
      
      /* Revenue from Fares */
      $sql = "SELECT SUM(`amount`) AS `daily_revenue` FROM `frs_fares` WHERE date(`date`) = '" . $today . "' AND `deleted` != b'1'";
      $stmt = $this->db->query($sql);
      $row = $stmt->fetch();
      $revenue += $row['daily_revenue'];
      
      $sql = "SELECT SUM(`amount`) AS `daily_expenses` FROM `frs_expenses` WHERE date(`date`) = '" . $today . "' AND `deleted` != b'1'";
      $stmt = $this->db->query($sql);
      $row = $stmt->fetch();
      $expenses = $row['daily_expenses'];

      $dailyprofit = $revenue - $expenses;

      //data para sa profitTrend 
      $monthly_sql = "
      SELECT 
        DATE_FORMAT(date, '%Y-%m') AS month, 
        SUM(amount) AS total_amount
      FROM frs_fares 
      WHERE deleted != b'1' 
      GROUP BY month";
      
      $collection_sql = "
      SELECT 
        DATE_FORMAT(date, '%Y-%m') AS month, 
        SUM(amount) AS total_collection
      FROM frs_collections 
      WHERE deleted != b'1' 
      GROUP BY month";

      $expenses_sql = "
      SELECT 
        DATE_FORMAT(date, '%Y-%m') AS month, 
        SUM(amount) AS total_expenses
      FROM frs_expenses 
      WHERE deleted != b'1' 
      GROUP BY month";

      $fares_stmt = $this->db->query($monthly_sql);
      $collection_stmt = $this->db->query($collection_sql);
      $expenses_stmt = $this->db->query($expenses_sql);

      // Collect all unique months and amounts
      $monthly_data = [];
      while ($fares_row = $fares_stmt->fetch()) {
        $month = $fares_row['month'];
        if (!isset($monthly_data[$month])) {
          $monthly_data[$month] = ['total_amount' => 0, 'total_collection' => 0, 'total_expenses' => 0];
        }
        $monthly_data[$month]['total_amount'] += $fares_row['total_amount'];
      }

      while ($collection_row = $collection_stmt->fetch()) {
        $month = $collection_row['month'];
        if (!isset($monthly_data[$month])) {
          $monthly_data[$month] = ['total_amount' => 0, 'total_collection' => 0, 'total_expenses' => 0];
        }
        $monthly_data[$month]['total_collection'] += $collection_row['total_collection'];
      }

      while ($expenses_row = $expenses_stmt->fetch()) {
        $month = $expenses_row['month'];
        if (!isset($monthly_data[$month])) {
          $monthly_data[$month] = ['total_amount' => 0, 'total_collection' => 0, 'total_expenses' => 0];
        }
        $monthly_data[$month]['total_expenses'] += $expenses_row['total_expenses'];
      }

      // Calculate the total amount by adding fares and collections
      foreach ($monthly_data as $month => $amounts) {
        $monthly_data[$month]['total_amount'] += $amounts['total_collection'];
      }
      ksort($monthly_data);

      $months = [];
      $monthlyProfits = [];
      
      foreach ($monthly_data as $month => $amounts) {
        $profit = $amounts['total_amount'] - $amounts['total_expenses'];
        $months[] = $month;
        $monthlyProfits[] = $profit;     
      }

      //para naman sa revenue vs expenses
      $current_month = date('Y-m');

      /* Revenue from Collections */
      $sql = "SELECT SUM(`amount`) AS `monthly_revenue` FROM `frs_collections` WHERE DATE_FORMAT(`date`, '%Y-%m') = '" . $current_month . "' AND `deleted` != b'1'";
      $stmt = $this->db->query($sql);
      $row = $stmt->fetch();
      $monthly_revenue = $row['monthly_revenue'];
  
      /* Revenue from Fares */
      $sql = "SELECT SUM(`amount`) AS `monthly_revenue` FROM `frs_fares` WHERE DATE_FORMAT(`date`, '%Y-%m') = '" . $current_month . "' AND `deleted` != b'1'";
      $stmt = $this->db->query($sql);
      $row = $stmt->fetch();
      $monthly_revenue += $row['monthly_revenue'];
  
      /* Monthly Expenses */
      $sql = "SELECT SUM(`amount`) AS `monthly_expenses` FROM `frs_expenses` WHERE DATE_FORMAT(`date`, '%Y-%m') = '" . $current_month . "' AND `deleted` != b'1'";
      $stmt = $this->db->query($sql);
      $row = $stmt->fetch();
      $monthly_expenses = $row['monthly_expenses'];
  
      /* Compute the percentages */
      $total = $monthly_revenue + $monthly_expenses;
      $revenue_percentage = ($total > 0) ? ($monthly_revenue / $total) * 100 : 0;
      $expenses_percentage = ($total > 0) ? ($monthly_expenses / $total) * 100 : 0;

      //Computation ng profit increase
      $current_month = date('Y-m');
      $previous_month = date('Y-m', strtotime('-1 month'));

/* Get Current Month Revenue */
$sql = "SELECT SUM(amount) AS monthly_revenue FROM frs_collections WHERE DATE_FORMAT(date, '%Y-%m') = '$current_month' AND deleted != b'1'";
$stmt = $this->db->query($sql);
$row = $stmt->fetch();
$current_revenue = $row['monthly_revenue'];

$sql = "SELECT SUM(amount) AS monthly_revenue FROM frs_fares WHERE DATE_FORMAT(date, '%Y-%m') = '$current_month' AND deleted != b'1'";
$stmt = $this->db->query($sql);
$row = $stmt->fetch();
$current_revenue += $row['monthly_revenue'];

/* Get Current Month Expenses */
$sql = "SELECT SUM(amount) AS monthly_expenses FROM frs_expenses WHERE DATE_FORMAT(date, '%Y-%m') = '$current_month' AND deleted != b'1'";
$stmt = $this->db->query($sql);
$row = $stmt->fetch();
$current_expenses = $row['monthly_expenses'];

/* Get Previous Month Revenue */
$sql = "SELECT SUM(amount) AS monthly_revenue FROM frs_collections WHERE DATE_FORMAT(date, '%Y-%m') = '$previous_month' AND deleted != b'1'";
$stmt = $this->db->query($sql);
$row = $stmt->fetch();
$previous_revenue = $row['monthly_revenue'];

$sql = "SELECT SUM(amount) AS monthly_revenue FROM frs_fares WHERE DATE_FORMAT(date, '%Y-%m') = '$previous_month' AND deleted != b'1'";
$stmt = $this->db->query($sql);
$row = $stmt->fetch();
$previous_revenue += $row['monthly_revenue'];

/* Get Previous Month Expenses */
$sql = "SELECT SUM(amount) AS monthly_expenses FROM frs_expenses WHERE DATE_FORMAT(date, '%Y-%m') = '$previous_month' AND deleted != b'1'";
$stmt = $this->db->query($sql);
$row = $stmt->fetch();
$previous_expenses = $row['monthly_expenses'];

/* Calculate Profit */
$current_profit = $current_revenue - $current_expenses;
$previous_profit = $previous_revenue - $previous_expenses;

/* Compute Profit Increase Percentage */
if ($previous_profit != 0) {
    $profit_increase = (($current_profit - $previous_profit) / abs($previous_profit)) * 100;
} else {
    $profit_increase = ($current_profit > 0) ? 100 : 0; // If previous profit is 0, assume full increase
}

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
        <h3>₱ <?php echo number_format($revenue, 2); ?></h3>
        <p>Daily Revenue</p>
        </div>
        <div class="icon"><i class="bi bi-cash-stack" style="color: #00693e;"></i></div>
        <a href="#addCollection" data-toggle="modal" class="small-box-footer" style="background-color: #00693e;"><i class="bi bi-plus-circle" style="margin-right: 5px;"></i>Add Collection</a>
      </div>
      </div>
      <!-- Expenses Card -->
      <div class="col-lg-4 col-12">
      <div class="small-box" style="color:#00693e; border-top: 3px solid rgba(0, 0, 0, 0.1); background-color: #fff;">
        <div class="inner">
        <h3>₱ <?php echo number_format($expenses, 2); ?></h3>
        <p>Daily Expenses</p>
        </div>
        <div class="icon"><i class="bi bi-credit-card" style="color: #00693e;"></i></div>
        <a href="expenses.php" class="small-box-footer" style="background-color: #00693e;"><i class="bi bi-plus-circle" style="margin-right: 5px;"></i>Add Expense</a>
      </div>
      </div>
      <!-- Profit Card -->
      <div class="col-lg-4 col-12">
      <div class="small-box" style="color:#00693e; border-top: 3px solid rgba(0, 0, 0, 0.1); background-color: #fff;">
        <div class="inner">
        <h3>
          <?php
            if($dailyprofit < 0)
              echo "( ₱ " . number_format(abs($dailyprofit), 2) . " )";
            else
              echo "₱ " . number_format($dailyprofit, 2); 
          ?>
        </h3>
        <p>Daily Profit</p>
        </div>
        <div class="icon"><i class="bi bi-cash-coin" style="color: #00693e;"></i></div>
        <a href="profits.php" class="small-box-footer" style="background-color: #00693e;">More Info<i class="bi bi-arrow-right-circle" style="margin-left: 5px;"></i></a>
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
<?php include '../modal/dashboardModal.php'; ?>

  <!-- Active Script -->
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
        type: 'line',  // Chart type
        data: {
            labels: <?php echo json_encode($months); ?>,  // X-axis labels
            datasets: [{
                label: 'Profit Over Time',
                data: <?php echo json_encode($monthlyProfits); ?>,  // Y-axis values
                borderColor: 'green',  // Line color
                backgroundColor: 'rgba(10, 136, 59, 0.2)', // Fill under the line
                borderWidth: 2,  // Line thickness
                pointRadius: 5, // Size of data points
                pointBackgroundColor: '#00693e', // Color of data points
                fill: true  // Enable fill under the line
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
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