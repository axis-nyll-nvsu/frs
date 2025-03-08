<?php
/*
 * Salary View
 * Description: Salaries View
 * Author: Vernyll Jan P. Asis
 */

  session_start();
  if(!isset($_SESSION['type'])) {
    header('location: ./');
  }

 require_once '../config/config.php';
  class Salary {
    private $db;

    public function __construct() {
        $conn = new Connection();
        $this->db = $conn->getConnection();
    }

    public function getData(){ 
      $remu_sql = "SELECT a.`id`, b.`first_name`, b.`middle_name`, b.`last_name`, a.`start_date`, a.`end_date`, a.`collection`, a.`amount`, a.`paid`, a.`driver_id` " . 
                    "FROM `frs_salaries` AS a " .
                    "INNER JOIN `frs_drivers` AS b " .
                    "ON a.`driver_id` = b.`id` " .
                    "ORDER BY a.`start_date` DESC, b.`first_name` ASC";
      $remu_stmt = $this->db->query($remu_sql);
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
        <h1>Salaries</h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="bi bi-speedometer2"></i> Home</a></li>
          <li class="active">Salaries</li>
        </ol>
      </section>

      <!-- Main Content -->
      <section class="content">
        <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <div class="box-header with-border">
                <a href="#compute" data-toggle="modal" class="btn btn-sm btn-flat axis-btn-green">Compute Salaries</a> 
              </div>
              <div class="box-body table-responsive">
                <table id="example1" class="table table-bordered">
                  <thead>
                    <th style="width: 12px; max-width: 12px !important;">#</th>
                    <th>Coverage</th>
                    <th>Name</th>
                    <th>Collections</th>
                    <th>Salary</th>
                    <th style="width: 40px; min-width: 40px !important;">Status</th>
                    <th style="width: 100px; min-width: 100px !important;">Action</th>
                  </thead>
                  <tbody>
      <?php
      $id = 1;
      while ($row = $remu_stmt->fetch()) { ?>
                    <tr>
                      <td><?php echo $id; ?></td>
                      <td>
                        <?php
                          $dateStart = date('M d, Y', strtotime($row['start_date']));
                          $dateEnd = date('M d, Y', strtotime($row['start_date'] . ' +6 days'));
                          echo $dateStart . " - " . $dateEnd;
                        ?>
                      <td>
                        <?php
                          $name =   $row['first_name'] . " ";
                          $name .=  ($row['middle_name'] != "") ? $row['middle_name'] . " " : "";
                          $name .=  $row['last_name'];
                          echo $name;
                        ?>
                      </td>
                      </td>
                      <td style="text-align: right;">Php <?php echo number_format($row['collection'], 2); ?></td>
                      <td style="text-align: right;">Php <?php echo number_format($row['amount'], 2); ?></td>
                      <td>
                      <?php if ($row['paid'] == 1) { ?>
                        <small><i class="bi bi-circle-fill" style="color: #33a073;"></i>&nbsp;&nbsp;&nbsp;PAID</small>
                      <?php } else { ?>
                        <small><i class="bi bi-circle-fill" style="color: #cc483b;"></i>&nbsp;&nbsp;&nbsp;UNPAID</small>
                      <?php } ?>
                      </td>
                      <td>
                      <?php if ($row['paid'] == 0) { ?>
                        <button class='btn btn-success btn-sm recompute btn-flat' 
                        data-compute_salary_id='<?php echo $row['id']; ?>'> Recompute</button>
                        <?php if ($row['amount'] != 0) { ?>
                        <button class='btn btn-warning btn-sm pay btn-flat' 
                        data-pay_salary_id='<?php echo $row['id']; ?>'> Pay</button>
                        <?php } ?>
                      <?php } else { ?>
                        <button class='btn btn-success btn-sm btn-flat' disabled> Recompute</button>
                      <?php } ?>
                      </td>
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
<?php include 'modal/salaryModal.php'; ?>
<?php include 'modal/message2Modal.php'; ?>

  <script>
    $(document).ready(function() {
      $("#start_date").select2();
    });

    $(document).on('click', '.recompute', function(e){
      e.preventDefault();
      $('#recompute').modal('show');
      var compute_salary_id = $(this).data('compute_salary_id');
      $('#compute_salary_id').val(compute_salary_id)
    });

    $(document).on('click', '.pay', function(e){
      e.preventDefault();
      $('#pay').modal('show');
      var pay_salary_id = $(this).data('pay_salary_id');
      $('#pay_salary_id').val(pay_salary_id)
    });
  </script>

  <script>
    <?php if (isset($_SESSION['computed'])) { ?>
    $('#computed').modal('show');
    <?php unset($_SESSION['computed']); } ?>

    <?php if (isset($_SESSION['error'])) { ?>
    $('#error').modal('show')
    <?php unset($_SESSION['error']); } ?>

    <?php if (isset($_SESSION['recomputed'])) { ?>
    $('#recomputed').modal('show');
    <?php unset($_SESSION['recomputed']); } ?>

    <?php if (isset($_SESSION['paid'])) { ?>
    $('#paid').modal('show');
    <?php unset($_SESSION['paid']); } ?>
  </script>

<?php
  }
}
$salary = new Salary(); $salary->getData();
?>

</body>
</html>