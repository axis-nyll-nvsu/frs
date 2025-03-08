<?php
/*
 * Income Statement Print
 * Description: Income Statement Print
 * Author: Vernyll Jan P. Asis
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
<html style="background-color: #ecf0f5;">
<head>
<?php include './head.php'; ?>
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
    
        .table {
            border-collapse: collapse;
            width: 100%;
        }
    
        .table th, .table td {
            padding: 8px;
        }
    
        .table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    
        .table tr:hover {
            background-color: #ddd;
        }
    
        .table tr.green {
            background-color: #00693e;
            color: #fff;
        }
    
        .table tr:last-child {
            background-color: #fafafa;
            font-weight: bold;
        }
    
        .table tr:last-child td {
            text-align: right;
        }
    }
</style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="width: 100%; margin-left: 0; margin-top: 0;">

      <!-- Main Content -->
      <section class="content">
        <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <div class="box-header">
                <div style="position: relative">
                  <div style="text-align: center; font-weight: bold; margin-top: 0;">
                    <img src="../images/logo.png" alt="" style="display: inline-block; width: 100px; margin: 20px;" />
                    <p style="font-size: 1.2em;">First Novo Vizcayano Travellers Transport Cooperative</p>
                  </div>
                  <h4 style="text-align: center; font-size: 1em;">Solano, Nueva Vizcaya</h4>
                </div>
              </div>
              <div class="box-header with-border">
                <div style="position: relative">
                  <h3 style="text-align: center; font-weight: bold; margin-top: 0;">Income Statement</h3>
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
                    <th colspan="3" style="color: #fff;">Revenues</th>
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
                      <th colspan="3" style="color: #fff;">Expenses</td>
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
    window.print();
    window.onafterprint = window.close; 
  </script>
</body>
</html>