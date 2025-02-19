<?php
/*
 * dashboard.php
 * Description: Dashboard Page
 * Author: 
 * Modified: 11-23-2024
 */

  session_start();
  if(!isset($_SESSION['type'])) {
    header('location: ./');
  }

  include '../config/config.php';
  class Dashboard extends Connection { 
    public function getData(){ 
      $today = date('Y-m-d');
      
      /* Revenue from Collections */
      $sql = "SELECT SUM(`amount`) AS `daily_revenue` FROM `frs_collections` WHERE date(`date`) = '" . $today . "' AND `deleted` != b'1'";
      $stmt = $this->conn()->query($sql);
      $row = $stmt->fetch();
      $revenue = $row['daily_revenue'];
      
      /* Revenue from Fares */
      $sql = "SELECT SUM(`amount`) AS `daily_revenue` FROM `frs_fares` WHERE date(`date`) = '" . $today . "' AND `deleted` != b'1'";
      $stmt = $this->conn()->query($sql);
      $row = $stmt->fetch();
      $revenue += $row['daily_revenue'];
      
      $sql = "SELECT SUM(`amount`) AS `daily_expenses` FROM `frs_expenses` WHERE date(`date`) = '" . $today . "' AND `deleted` != b'1'";
      $stmt = $this->conn()->query($sql);
      $row = $stmt->fetch();
      $expenses = $row['daily_expenses'];

      $profit = $revenue - $expenses;
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
        padding: -10px;
        
    }
</style>
<?php include './head.php'; ?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">

<?php include './navbar.php'; ?>
<?php include './sidebar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header -->
    <section class="content-header">
    <h1>Dashboard</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
    </section>

    <!-- Main Content -->
    <section class="content">
    <div class="row">
      <!-- Revenue Card -->
      <div class="col-lg-4 col-12">
      <div class="small-box" style="color:#00693e;border-top: 3px solid rgba(0, 0, 0, 0.1);">
        <div class="inner">
        <h3>₱<?php echo number_format($revenue, 2); ?></h3>
        <p>Daily Revenue</p>
        </div>
        <div class="icon"><i class="fa fa-money-check" style="color: #00693e;"></i></div>
        <a href="dashboard.php?dailyexpenses=1" class="small-box-footer" style="background-color: #00693e;"><i class="fa fa-plus-circle" style="margin-right: 5px;"></i>Add Collection</a>
      </div>
      </div>
      <!-- Expenses Card -->
      <div class="col-lg-4 col-12">
      <div class="small-box" style="color:#00693e;border-top: 3px solid rgba(0, 0, 0, 0.1);">
        <div class="inner">
        <h3>₱<?php echo number_format($expenses, 2); ?></h3>
        <p>Daily Expenses</p>
        </div>
        <div class="icon"><i class="fa fa-money-check" style="color: #00693e;"></i></div>
        <a href="dashboard.php?dailyincome=1" class="small-box-footer" style="background-color: #00693e;"><i class="fa fa-plus-circle" style="margin-right: 5px;"></i>Add Expense</a>
      </div>
      </div>
      <!-- Profit Card -->
      <div class="col-lg-4 col-12">
      <div class="small-box" style="color:#00693e;border-top: 3px solid rgba(0, 0, 0, 0.1);">
        <div class="inner">
        <h3><?php echo ($profit < 0) ? "-" : "+"; ?> ₱<?php echo number_format($profit, 2); ?></h3>
        <p>Daily Profit</p>
        </div>
        <div class="icon"><i class="fa fa-money-check" style="color: #00693e;"></i></div>
        <a href="profits.php" class="small-box-footer" style="background-color: #00693e;">More Info<i class="fa fa-arrow-circle-right" style="margin-left: 5px;"></i></a>
      </div>
      </div>
    </div>

    <table border="1">
    <tr style = "text-align: center;">
        <td rowspan="2" style ="width: 600px; height: 380px;">Profit Trends
            <div class="line-chart">
            <canvas id="profitTrend" width="400" height="300"></canvas>
            </div>

        </td>
        <td style="width: 400px; height: 150px; align-items: center;">Revenue vs. Expenses
            <div class="chart-container">
            <canvas id="revenueVSexpenses"></canvas>
            </div>
        </td>
       
    </tr>
    <tr tr style = "text-align: center; height: 80px;">
        <td>Salary Increase from the previous month:
            <h3 style = "font-weight:bold; color: #00693e;"> 10.00% - 10.3%</h3>
        </td>
     
    </tr>
</table>

    </section>
  </div>
</div>


<?php include 'footer.php'; ?>
<?php include 'modal/profileModal.php'; ?>

  <!-- Active Script -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
        var ctx = document.getElementById('revenueVSexpenses').getContext('2d');
        var myPieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Revenue', 'Expenses'],
                datasets: [{
                    data: [80, 20,],
                    backgroundColor: ['#00693e', '#eeff36']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'right' 
                    }
                }
            }
            
        });

        var ctx = document.getElementById('profitTrend').getContext('2d');

    var myLineChart = new Chart(ctx, {
        type: 'line',  // Chart type
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],  // X-axis labels
            datasets: [{
                label: 'Profit Over Time',
                data: [10, 25, 40, 30, 50, 65],  // Y-axis values
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