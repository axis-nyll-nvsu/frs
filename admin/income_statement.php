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

  include '../config/config.php';
  class Report extends Connection{ 
    public function getData(){
      $period = date('Y');
      if(isset($_GET['period'])) {
        $period = $_GET['period'];
      }

      $income_sql = "SELECT * FROM `frs_collections` WHERE `deleted` != b'1'  ORDER BY `date` DESC";
      $income_stmt = $this->conn()->query($income_sql);
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
          <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
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
                  <a href="#addnew" data-toggle="modal" class="btn btn-sm btn-flat axis-btn-green" style="position: absolute; top: 0; right: 0;"><i class="fa fa-print"></i> Print Income Statement</a>
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
                    <td style="text-align: right;"><?php echo number_format(1234.56, 2); ?></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td>Revenue from Other Collections</td>
                    <td style="text-align: right;"><?php echo number_format(423102.88, 2); ?></td>
                  </tr>
                  <tr style="background-color: #fafafa; font-weight: bold;">
                    <td colspan="2">Total Revenues</td>
                    <td style="text-align: right;"><?php echo "Php " . number_format(424337.44, 2); ?></td>
                  </tr>
                  <!-- Expenses -->
                  <tr style="background-color: #00693e;">
                    <td colspan="3" style="color: #fff;">Expenses</td>
                  </tr>
                  <tr>
                    <td></td>
                    <td>Salaries</td>
                    <td style="text-align: right;"><?php echo number_format(123123.12, 2); ?></td>
                  </tr>
                  <tr style="background-color: #fafafa; font-weight: bold;">
                    <td colspan="2">Total Expenses</td>
                    <td style="text-align: right;"><?php echo "Php " . number_format(123123.12, 2); ?></td>
                  </tr>
                  <!-- Profit -->
                  <tr style="background-color: #fafafa; font-weight: bold;">
                    <td colspan="2">Net Income</td>
                    <td style="text-align: right;"><?php echo "Php " . number_format(301214.32, 2); ?></td>
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