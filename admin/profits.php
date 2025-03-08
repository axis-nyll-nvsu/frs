<?php
/*
 * Profits
 * Description: Profits View
 * Author: Charlene B. Dela Cruz
 */

session_start();
if (!isset($_SESSION['type'])) {
    header('location: ./');
}

 require_once '../config/config.php';
  class Profit {
    private $db;

    public function __construct() {
        $conn = new Connection();
        $this->db = $conn->getConnection();
    }

    public function getData() {
      // SQL query to get total amount from frs_fares
      $fares_sql = "
      SELECT
        f.date,
        SUM(f.amount) AS total_amount
      FROM
        frs_fares f
      WHERE
        f.deleted != b'1'
      GROUP BY
        f.date
      ORDER BY
        f.date DESC";

      // SQL query to get total amount from frs_collections
      $collection_sql = "
      SELECT
        c.date,
        SUM(c.amount) AS total_collection
      FROM
        frs_collections c
      WHERE
        c.deleted != b'1'
      GROUP BY
        c.date
      ORDER BY
        c.date DESC";

      // SQL query to get total amount from frs_expenses
      $expenses_sql = "
      SELECT
        e.date,
        SUM(e.amount) AS total_expenses
      FROM
        frs_expenses e
      WHERE
        e.deleted != b'1'
      GROUP BY
        e.date
      ORDER BY
        e.date DESC";

      $fares_stmt = $this->db->query($fares_sql);
      $collection_stmt = $this->db->query($collection_sql);
      $expenses_stmt = $this->db->query($expenses_sql);

      // Collect all unique dates and amounts
      $data = [];
      while ($fares_row = $fares_stmt->fetch()) {
      $date = $fares_row['date'];
      if (!isset($data[$date])) {
        $data[$date] = ['total_amount' => 0, 'total_collection' => 0, 'total_expenses' => 0];
      }
      $data[$date]['total_amount'] += $fares_row['total_amount'];
      }

      while ($collection_row = $collection_stmt->fetch()) {
      $date = $collection_row['date'];
      if (!isset($data[$date])) {
        $data[$date] = ['total_amount' => 0, 'total_collection' => 0, 'total_expenses' => 0];
      }
      $data[$date]['total_collection'] += $collection_row['total_collection'];
      }

      while ($expenses_row = $expenses_stmt->fetch()) {
      $date = $expenses_row['date'];
      if (!isset($data[$date])) {
        $data[$date] = ['total_amount' => 0, 'total_collection' => 0, 'total_expenses' => 0];
      }
      $data[$date]['total_expenses'] += $expenses_row['total_expenses'];
      }

      // Calculate the total amount by adding fares and collections
      foreach ($data as $date => $amounts) {
      $data[$date]['total_amount'] += $amounts['total_collection'];
      }

      return $data;
    }
}

$profit = new Profit();
$fares = $profit->getData();

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
    <h1>Daily Profits</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="bi bi-speedometer2"></i> Home</a></li>
      <li class="active">Daily Profits</li>
    </ol>
    </section>

    <!-- Main Content -->
    <section class="content">
    <div class="row">
      <div class="col-xs-12">
      <div class="box">
        <div class="box-body table-responsive">
        <table id="example1" class="table table-bordered">
          <thead>
          <th style="width: 12px; max-width: 12px !important;">#</th>
          <th>Date</th>
          <th>Revenue</th>
          <th>Expenses</th>
          <th>Profit</th>
          </thead>
          <tbody>
    <?php
    $id = 1;
    foreach ($fares as $date => $data) {
      $total_amount = $data['total_amount'];
      $total_expenses = $data['total_expenses'];
      $profit = $total_amount - $total_expenses;
    ?>
          <tr>
            <td><?php echo $id; ?></td>
            <td><?php echo $date; ?></td>
            <td style="text-align: right;">Php <?php echo number_format($total_amount, 2); ?></td>
            <td style="text-align: right;">Php <?php echo number_format($total_expenses, 2); ?></td>
            <td style="text-align: right;">Php <?php echo number_format($profit, 2); ?></td>
          </tr>
    <?php $id++; } ?>
          </tbody>
        </table>
        </div>
      </div>
      </div>
    </div>
    </section>
  </div>
  </div>

<?php include 'footer.php'; ?>
<?php include 'modal/profileModal.php'; ?>
<?php include 'modal/messageModal.php'; ?>


  <script>
    $(document).ready(function() {
      $("#date").datepicker();
    });
  </script>

  <script>
    <?php if (isset($_SESSION['success'])) { ?>
    $('#success').modal('show');
    <?php unset($_SESSION['success']); } ?>

    <?php if (isset($_SESSION['error'])) { ?>
    $('#error').modal('show')
    <?php unset($_SESSION['error']); } ?>

    <?php if (isset($_SESSION['updated'])) { ?>
    $('#updated').modal('show');
    <?php unset($_SESSION['updated']); } ?>

    <?php if (isset($_SESSION['deleted'])) { ?>
    $('#deleted').modal('show');
    <?php unset($_SESSION['deleted']); } ?>
  </script>

</body>
</html>