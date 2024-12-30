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
      
      $sql = "SELECT SUM(`amount`) AS `daily_revenue` FROM `frs_collections` WHERE date(`date`) = '" . $today . "' AND `deleted` != b'1'";
      $stmt = $this->conn()->query($sql);
      $row = $stmt->fetch();
      $revenue = $row['daily_revenue'];
      
      $sql = "SELECT SUM(`amount`) AS `daily_expenses` FROM `frs_expenses` WHERE date(`date`) = '" . $today . "' AND `deleted` != b'1'";
      $stmt = $this->conn()->query($sql);
      $row = $stmt->fetch();
      $expenses = $row['daily_expenses'];

      $profit = $revenue - $expenses;
?>

<!DOCTYPE html>
<html style="background-color: #00693e;">
<head>
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
              <a href="report.php" class="small-box-footer" style="background-color: #00693e;">More Info<i class="fa fa-arrow-circle-right" style="margin-left: 5px;"></i></a>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12 col-12">
            <div class="small-box" style="background-color: #fff;">
              <div class="inner">
                <h4 style="padding: 10px;color: #000;">Revenue Trend</h4>
                <canvas id="revenue_trend" width="600" height="80"></canvas>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12 col-12">
            <div class="small-box" style="background-color: #fff;">
              <div class="inner">
                <h4 style="padding: 10px;color: #000;">Expenses Trend</h4>
                <canvas id="expenses_trend" width="600" height="80"></canvas>
              </div>
            </div>
          </div>
        </div>
      </section>
  </div>
</div>

<?php include 'footer.php'; ?>
<?php include 'modal/profileModal.php'; ?>

  <!-- Active Script -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<?php
$currentMonth = date('m');
$currentYear = date('Y');

/* Revenue Data */
$sql = "
    SELECT 
      SUM(`amount`) AS `revenue_amount`, 
      DATE_FORMAT(`date`, '%Y-%m-%d') AS `revenue_date`
    FROM frs_collections
    WHERE MONTH(`date`) = :currentMonth AND YEAR(`date`) = :currentYear
    GROUP BY `revenue_date`
";

$stmt = $this->conn()->prepare($sql);
$stmt->execute(['currentMonth' => $currentMonth, 'currentYear' => $currentYear]);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

$revenue_dates = [];
$revenue_amounts = [];

foreach ($results as $row) {
    $dates[] = $row['revenue_date'];
    $totalAmounts[] = (float) $row['revenue_amount']; // Float is required by Chart.js
}

$rdates_json = json_encode($revenue_dates);
$revenue_json = json_encode($revenue_amounts);

/* Expenses Data */
$sql = "
    SELECT 
      SUM(`amount`) AS `expenses_amount`, 
      DATE_FORMAT(`date`, '%Y-%m-%d') AS `expenses_date`
    FROM `frs_expenses`
    WHERE MONTH(`date`) = :currentMonth AND YEAR(`date`) = :currentYear
    GROUP BY `expenses_date`
";

$stmt = $this->conn()->prepare($sql);
$stmt->execute(['currentMonth' => $currentMonth, 'currentYear' => $currentYear]);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

$expenses_dates = [];
$expenses_amounts = [];

foreach ($results as $row) {
    $expenses_dates[] = $row['expenses_date'];
    $expenses_amounts[] = (float) $row['expenses_amount']; // Float is required by Chart.js
}

$edates_json = json_encode($expenses_dates);
$expenses_json = json_encode($expenses_amounts);
?>

  <script>
  let ctx1 = document.getElementById('revenue_trend').getContext('2d');

  var myChart = new Chart(ctx1, {
      type: 'bar',
      data: {
          labels: <?php echo $rdates_json; ?>, // Dates of the records
          datasets: [
              {
                  label: 'Daily Revenue',
                  data: <?php echo $revenue_json; ?>, // Total amounts
                  backgroundColor: "#00693e",
                  barThickness: 30,
              },
          ]
      },
      options: {
          plugins: {
              legend: {
                  display: true,
              }
          },
          scales: {
              xAxes: [{
                  gridLines: {
                      display: true
                  }
              }],
              yAxes: [{
                  gridLines: {
                      display: true
                  }   
              }],
          }
      }
  });

  let ctx2 = document.getElementById('expenses_trend').getContext('2d');

  var myChart = new Chart(ctx2, {
      type: 'bar',
      data: {
          labels: <?php echo $edates_json; ?>, // Dates of the records
          datasets: [
              {
                  label: 'Daily Expenses',
                  data: <?php echo $expenses_json; ?>, // Total amounts
                  backgroundColor: "#00693e",
                  barThickness: 30,
              },
          ]
      },
      options: {
          plugins: {
              legend: {
                  display: true,
              }
          },
          scales: {
              xAxes: [{
                  gridLines: {
                      display: true
                  }
              }],
              yAxes: [{
                  gridLines: {
                      display: true
                  }   
              }],
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