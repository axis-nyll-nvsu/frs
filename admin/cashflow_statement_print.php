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
        if (isset($_GET['period'])) {
            $period = $_GET['period'];
        }

        $previous_year = $period - 1; // Get the previous year

        // Fetch total revenue from frs_collections for the previous year
        $collectionLastYear_sql = "SELECT COALESCE(SUM(amount), 0) AS total_collections 
                                   FROM frs_collections 
                                   WHERE YEAR(date) = ? AND deleted != b'1'";
        $collectionLastYear_stmt = $this->conn()->prepare($collectionLastYear_sql);
        $collectionLastYear_stmt->execute([$previous_year]);
        $collectionLastYear = $collectionLastYear_stmt->fetch(PDO::FETCH_ASSOC)['total_collections'];

        // Fetch total revenue from frs_fares for the previous year
        $fares_sql = "SELECT COALESCE(SUM(amount), 0) AS total_fares 
                      FROM frs_fares 
                      WHERE YEAR(date) = ? AND deleted != b'1'";  // Ensure deleted records are not counted
        $fares_stmt = $this->conn()->prepare($fares_sql);
        $fares_stmt->execute([$previous_year]);
        $fares = $fares_stmt->fetch(PDO::FETCH_ASSOC)['total_fares'];

        // Compute total revenue
        $total_revenueLastYear = $collectionLastYear + $fares;

        // Fetch total expenses for last year
        $expensesLastYear_sql = "SELECT COALESCE(SUM(amount), 0) AS total_expenses 
                                 FROM frs_expenses 
                                 WHERE YEAR(date) = ? AND deleted != b'1'";
        $expensesLastYear_stmt = $this->conn()->prepare($expensesLastYear_sql);
        $expensesLastYear_stmt->execute([$previous_year]);
        $expensesLastYear = $expensesLastYear_stmt->fetch(PDO::FETCH_ASSOC)['total_expenses'];

        // Calculate Profit
        $profitLastYear = $total_revenueLastYear - $expensesLastYear;

        // Line Item Entries
        $operating_fares = 0; // frs_collections 1-6 + frs_fares
        $q_sql = "SELECT COALESCE(SUM(amount), 0) AS total 
                  FROM frs_fares 
                  WHERE YEAR(date) = ? AND deleted != b'1'";
        $q_stmt = $this->conn()->prepare($q_sql);
        $q_stmt->execute([$period]);
        $operating_fares = $q_stmt->fetch(PDO::FETCH_ASSOC)['total'];

        $operating_fees = 0; // frs_collections 7-18
        $q_sql = "SELECT COALESCE(SUM(amount), 0) AS total 
                  FROM frs_collections 
                  WHERE YEAR(date) = ? AND (category_id BETWEEN 7 AND 18) AND deleted != b'1'";
        $q_stmt = $this->conn()->prepare($q_sql);
        $q_stmt->execute([$period]);
        $operating_fees = $q_stmt->fetch(PDO::FETCH_ASSOC)['total'];

        $operating_otherCollections = 0; // frs_collections 20
        $q_sql = "SELECT COALESCE(SUM(amount), 0) AS total 
                  FROM frs_collections 
                  WHERE YEAR(date) = ? AND (category_id = 20) AND deleted != b'1'";
        $q_stmt = $this->conn()->prepare($q_sql);
        $q_stmt->execute([$period]);
        $operating_otherCollections = $q_stmt->fetch(PDO::FETCH_ASSOC)['total'];

        $operating_salaries = 0; // frs_expenses 1
        $q_sql = "SELECT COALESCE(SUM(amount), 0) AS total 
                  FROM frs_expenses
                  WHERE YEAR(date) = ? AND (category_id = 1) AND deleted != b'1'";
        $q_stmt = $this->conn()->prepare($q_sql);
        $q_stmt->execute([$period]);
        $operating_salaries = $q_stmt->fetch(PDO::FETCH_ASSOC)['total'];

        $operating_incentives = 0; // frs_expenses 2
        $q_sql = "SELECT COALESCE(SUM(amount), 0) AS total 
                  FROM frs_expenses
                  WHERE YEAR(date) = ? AND (category_id = 2) AND deleted != b'1'";
        $q_stmt = $this->conn()->prepare($q_sql);
        $q_stmt->execute([$period]);
        $operating_incentives = $q_stmt->fetch(PDO::FETCH_ASSOC)['total'];

        $operating_benefits = 0; // frs_expenses 3
        $q_sql = "SELECT COALESCE(SUM(amount), 0) AS total 
                  FROM frs_expenses
                  WHERE YEAR(date) = ? AND (category_id = 3) AND deleted != b'1'";
        $q_stmt = $this->conn()->prepare($q_sql);
        $q_stmt->execute([$period]);
        $operating_benefits = $q_stmt->fetch(PDO::FETCH_ASSOC)['total'];

        $operating_utilities = 0; // frs_expenses 4
        $q_sql = "SELECT COALESCE(SUM(amount), 0) AS total 
                  FROM frs_expenses
                  WHERE YEAR(date) = ? AND (category_id = 4) AND deleted != b'1'";
        $q_stmt = $this->conn()->prepare($q_sql);
        $q_stmt->execute([$period]);
        $operating_utilities = $q_stmt->fetch(PDO::FETCH_ASSOC)['total'];

        $operating_supplies = 0; // frs_expenses 5
        $q_sql = "SELECT COALESCE(SUM(amount), 0) AS total 
                  FROM frs_expenses
                  WHERE YEAR(date) = ? AND (category_id = 5) AND deleted != b'1'";
        $q_stmt = $this->conn()->prepare($q_sql);
        $q_stmt->execute([$period]);
        $operating_supplies = $q_stmt->fetch(PDO::FETCH_ASSOC)['total'];

        $operating_meals = 0; // frs_expenses 7
        $q_sql = "SELECT COALESCE(SUM(amount), 0) AS total 
                  FROM frs_expenses
                  WHERE YEAR(date) = ? AND (category_id = 7) AND deleted != b'1'";
        $q_stmt = $this->conn()->prepare($q_sql);
        $q_stmt->execute([$period]);
        $operating_meals = $q_stmt->fetch(PDO::FETCH_ASSOC)['total'];

        $operating_maintenance = 0; // frs_expenses 8
        $q_sql = "SELECT COALESCE(SUM(amount), 0) AS total 
                  FROM frs_expenses
                  WHERE YEAR(date) = ? AND (category_id = 8) AND deleted != b'1'";
        $q_stmt = $this->conn()->prepare($q_sql);
        $q_stmt->execute([$period]);
        $operating_maintenance = $q_stmt->fetch(PDO::FETCH_ASSOC)['total'];

        $operating_legal = 0; // frs_expenses 9
        $q_sql = "SELECT COALESCE(SUM(amount), 0) AS total 
                  FROM frs_expenses
                  WHERE YEAR(date) = ? AND (category_id = 9) AND deleted != b'1'";
        $q_stmt = $this->conn()->prepare($q_sql);
        $q_stmt->execute([$period]);
        $operating_legal = $q_stmt->fetch(PDO::FETCH_ASSOC)['total'];

        $operating_otherExpenses = 0; // frs_expenses 10
        $q_sql = "SELECT COALESCE(SUM(amount), 0) AS total 
                  FROM frs_expenses
                  WHERE YEAR(date) = ? AND (category_id = 10) AND deleted != b'1'";
        $q_stmt = $this->conn()->prepare($q_sql);
        $q_stmt->execute([$period]);
        $operating_otherExpenses = $q_stmt->fetch(PDO::FETCH_ASSOC)['total'];

        $net_operating = 0;
        $net_operating += $operating_fares + $operating_fees + $operating_otherCollections;
        $net_operating -= $operating_salaries + $operating_incentives + $operating_benefits + $operating_utilities;
        $net_operating -= $operating_supplies + $operating_meals + $operating_maintenance + $operating_legal + $operating_otherExpenses;

        $investing_shareCapital = 0; // frs_collections 19
        $q_sql = "SELECT COALESCE(SUM(amount), 0) AS total 
                  FROM frs_collections
                  WHERE YEAR(date) = ? AND (category_id = 19) AND deleted != b'1'";
        $q_stmt = $this->conn()->prepare($q_sql);
        $q_stmt->execute([$period]);
        $investing_shareCapital = $q_stmt->fetch(PDO::FETCH_ASSOC)['total'];

        $investing_equipment = 0; // frs_expenses 6
        $q_sql = "SELECT COALESCE(SUM(amount), 0) AS total 
                  FROM frs_expenses
                  WHERE YEAR(date) = ? AND (category_id = 6) AND deleted != b'1'";
        $q_stmt = $this->conn()->prepare($q_sql);
        $q_stmt->execute([$period]);
        $investing_equipment = $q_stmt->fetch(PDO::FETCH_ASSOC)['total'];

        $net_investing = 0;
        $net_investing += $investing_shareCapital;
        $net_investing -= $investing_equipment;

        $financing_borrowing = 0; // N/A
        $financing_dividends = 0; // N/A

        $net_financing = 0;
        $net_financing += $financing_borrowing;
        $net_financing -= $financing_dividends;

        $net_increase = 0;
        $net_increase += $net_operating + $net_investing + $net_financing;

        $profitThisYear = $profitLastYear + $net_increase;
?>

<!DOCTYPE html>
<html>
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
                  <h3 style="text-align: center; font-weight: bold; margin-top: 0;">Statement of Cash Flow</h3>
                  <h4 style="text-align: center; font-size: 1em;">For the Year Ending <?php echo "Dec 31, " . $period; ?></h4>
                </div>
              </div>
              <div class="box-body table-responsive">
                <table class="table">
                  <thead>
                  <th style="width: 30px; max-width: 30px !important;"></th>
                  <th style="text-align: right;">Cash at Beginning of Year</th>
                  <th style="text-align: right; width: 150px; max-width: 150px !important;"><?php echo "Php " . number_format($profitLastYear, 2); ?></th>
                  </thead>
                  <tbody>
                  <!-- Operating Activities -->
                  <tr style="background-color: #00693e;" class="green">
                    <td colspan="3" style="color: #fff;">Operating Activities</td>
                  </tr>
                  <tr>
                    <td colspan="3">Cash receipts from</td>
                  </tr>
                  <tr>
                    <td></td>
                    <td>Driver Collections</td>
                    <td style="text-align: right;"><?php echo number_format($operating_fares, 2); ?></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td>Miscellaneous Fees</td>
                    <td style="text-align: right;"><?php echo number_format($operating_fees, 2); ?></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td>Other Collections</td>
                    <td style="text-align: right;"><?php echo number_format($operating_otherCollections, 2); ?></td>
                  </tr>
                  <tr>
                    <td colspan="3">Cash paid for</td>
                  </tr>
                  <tr>
                    <td></td>
                    <td>Driver Salaries</td>
                    <td style="text-align: right;"><?php echo "( " . number_format($operating_salaries, 2) . " )"; ?></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td>Driver Incentives</td>
                    <td style="text-align: right;"><?php echo "( " . number_format($operating_incentives, 2) . " )"; ?></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td>Driver Benefits</td>
                    <td style="text-align: right;"><?php echo "( " . number_format($operating_benefits, 2) . " )"; ?></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td>Utilities</td>
                    <td style="text-align: right;"><?php echo "( " . number_format($operating_utilities, 2) . " )"; ?></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td>Office Supplies</td>
                    <td style="text-align: right;"><?php echo "( " . number_format($operating_supplies, 2) . " )"; ?></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td>Meals & Snacks</td>
                    <td style="text-align: right;"><?php echo "( " . number_format($operating_meals, 2) . " )"; ?></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td>Maintenance Fees</td>
                    <td style="text-align: right;"><?php echo "( " . number_format($operating_maintenance, 2) . " )"; ?></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td>Legal Fees</td>
                    <td style="text-align: right;"><?php echo "( " . number_format($operating_legal, 2) . " )"; ?></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td>Other Expenses</td>
                    <td style="text-align: right;"><?php echo "( " . number_format($operating_otherExpenses, 2) . " )"; ?></td>
                  </tr>
                  <tr style="background-color: #fafafa; font-weight: bold;">
                    <td colspan="2">Net Cash Flow from Operating Activities</td>
                    <td style="text-align: right;">
                      <?php
                        if($net_operating < 0)
                          echo "( Php " . number_format(abs($net_operating), 2) . " )";
                        else
                          echo "Php " . number_format($net_operating, 2);
                        ?>
                    </td>
                  </tr>
                  <!-- Investing Activities -->
                  <tr style="background-color: #00693e;" class="green">
                    <td colspan="3" style="color: #fff;">Investing Activities</td>
                  </tr>
                  <tr>
                    <td colspan="3">Cash receipts from</td>
                  </tr>
                  <tr>
                    <td></td>
                    <td>Share Capital</td>
                    <td style="text-align: right;"><?php echo number_format($investing_shareCapital, 2); ?></td>
                  </tr>
                  <tr>
                    <td colspan="3">Cash paid for</td>
                  </tr>
                  <tr>
                    <td></td>
                    <td>Equipment</td>
                    <td style="text-align: right;"><?php echo "( " . number_format($investing_equipment, 2) . " )"; ?></td>
                  </tr>
                  <tr style="background-color: #fafafa; font-weight: bold;">
                    <td colspan="2">Net Cash Flow from Investing Activities</td>
                    <td style="text-align: right;">
                      <?php
                        if($net_investing < 0)
                          echo "( Php " . number_format(abs($net_investing), 2) . " )";
                        else
                          echo "Php " . number_format($net_investing, 2);
                        ?>
                    </td>
                  </tr>
                  <!-- Financing Activities -->
                  <tr style="background-color: #00693e;" class="green">
                    <td colspan="3" style="color: #fff;">Financing Activities</td>
                  </tr>
                  <tr>
                    <td colspan="3">Cash receipts from</td>
                  </tr>
                  <tr>
                    <td></td>
                    <td>Borrowing</td>
                    <td style="text-align: right;"><?php echo number_format($financing_borrowing, 2); ?></td>
                  </tr>
                  <tr>
                    <td colspan="3">Cash paid for</td>
                  </tr>
                  <tr>
                    <td></td>
                    <td>Dividends</td>
                    <td style="text-align: right;"><?php echo "( " . number_format($financing_dividends, 2) . " )"; ?></td>
                  </tr>
                  <tr style="background-color: #fafafa; font-weight: bold;">
                    <td colspan="2">Net Cash Flow from Financing Activities</td>
                    <td style="text-align: right;">
                      <?php
                        if($net_financing < 0)
                          echo "( Php " . number_format(abs($net_financing), 2) . " )";
                        else
                          echo "Php " . number_format($net_financing, 2);
                        ?>
                    </td>
                  </tr>
                  <!-- Net Increase in Cash -->
                  <tr style="background-color: #fafafa; font-weight: bold;">
                    <td colspan="2">Net Increase in Cash</td>
                    <td style="text-align: right;">
                      <?php
                        if($net_increase < 0)
                          echo "( Php " . number_format(abs($net_increase), 2) . " )";
                        else
                          echo "Php " . number_format($net_increase, 2);
                        ?>
                    </td>
                  </tr>
                  <tr style="text-align: right; font-weight: bold;">
                    <td colspan="2">Cash at End of Year</td>
                    <td style="text-align: right;">
                      <?php
                        if($profitThisYear < 0)
                          echo "( Php " . number_format(abs($profitThisYear), 2) . " )";
                        else
                          echo "Php " . number_format($profitThisYear, 2);
                        ?>
                    </td>
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