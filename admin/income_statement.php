<?php
/*
 * reports.php
 * Description: Reports Page
 * Author: 
 * Modified: 12-27-2024
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
  
      // Fetch Fare Revenue Data for the selected year
      $fare_sql = "SELECT SUM(amount) AS fare_revenue
                     FROM `frs_fares`
                     WHERE YEAR(date) = ? AND `deleted` != b'1'";
      
      $stmt = $this->db->prepare($fare_sql);
      $stmt->execute([$period]);
      $resultForFare = $stmt->fetch(PDO::FETCH_ASSOC);

      //Fetch Other Collection Revenue for the selected year
      $other_sql = "SELECT SUM(amount) AS other_revenue
                     FROM `frs_collections`
                     WHERE YEAR(date) = ? AND `deleted` != b'1'";
      
      $stmt = $this->db->prepare($other_sql);
      $stmt->execute([$period]);
      $result = $stmt->fetch(PDO::FETCH_ASSOC);

      
      $fare_revenue = $resultForFare['fare_revenue'] ?? 0;
      $other_revenue = $result['other_revenue'] ?? 0;
      $total_revenue = $fare_revenue + $other_revenue;

      //Fetch na ang expenses bui
      $expense_sql = "SELECT e.description, SUM(exp.amount) AS total_expense 
      FROM frs_expenses exp 
      JOIN frs_ecategories e ON exp.category_id = e.id 
      WHERE YEAR(exp.date) = ? AND exp.deleted != b'1'
      GROUP BY e.description";

$expense_stmt = $this->db->prepare($expense_sql);
$expense_stmt->execute([$period]);
$expenses = $expense_stmt->fetchAll(PDO::FETCH_ASSOC);

$total_expense = array_sum(array_column($expenses, 'total_expense'));
$net_income = $total_revenue - $total_expense;

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
        <h1>Financial Reports &mdash; Income Statement</h1>
        <ol class="breadcrumb">
          <li><a href="dashboard.php"><i class="bi bi-speedometer2"></i> Home</a></li>
          <li>Financial Reports</li>
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
                  <th style="width: 30px; max-width: 30px !important;"></th>
                  <th></th>
                  <th style="width: 200px; max-width: 200px !important;"></th>
                  </thead>
                  <tbody>
                  <!-- Revenues -->
                  <tr style="background-color: #00693e;">
                    <td colspan="3" style="color: #fff;">Revenues</td>
                  </tr>
                  <tr>
                    <td></td>
                    <td>Revenue from Fares</td>
                    <td style="text-align: right;"><?php echo number_format($fare_revenue, 2); ?></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td>Revenue from Other Collections</td>
                    <td style="text-align: right;"><?php echo number_format($other_revenue, 2); ?></td>
                  </tr>
                  <tr style="background-color: #fafafa; font-weight: bold;">
                    <td colspan="2">Total Revenues</td>
                    <td style="text-align: right;"><?php echo "Php " . number_format($total_revenue, 2); ?></td>
                  </tr>
                  <!-- Expenses Section -->
<tr style="background-color: #00693e;">
    <td colspan="3" style="color: #fff;">Expenses</td>
</tr>

<?php foreach ($expenses as $expense): ?>
<tr>
    <td></td>
    <td><?php echo htmlspecialchars($expense['description']); ?></td>
    <td style="text-align: right;"><?php echo number_format($expense['total_expense'], 2); ?></td>
</tr>
<?php endforeach; ?>

<tr style="background-color: #fafafa; font-weight: bold;">
    <td colspan="2">Total Expenses</td>
    <td style="text-align: right;"><?php echo "Php " . number_format($total_expense, 2); ?></td>
</tr>
                  
                  <!-- Net Income -->
<tr style="background-color: #fafafa; font-weight: bold;">
    <td colspan="2">Net Income</td>
    <td style="text-align: right;"><?php echo "Php " . number_format($net_income, 2); ?></td>
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

<?php include 'footer.php'; ?>
<?php include 'modal/profileModal.php'; ?>
<?php
  }
}
$report = new Report(); $report->getData();
?>

  <script>
    $(document).ready(function() {
      $('#tabs').tabs();
    });
  </script>
</body>
</html>