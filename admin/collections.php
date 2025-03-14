<?php
/*
 * Fares
 * Description: Fares View
 * Author: Vernyll Jan P. Asis
 */

  session_start();
  if(!isset($_SESSION['type'])) {
    header('location: ./');
  }

 require_once '../config/config.php';
  class Fare {
    private $db;

    public function __construct() {
        $conn = new Connection();
        $this->db = $conn->getConnection();
    }

    public function getData(){ 
      $fare_sql = "SELECT a.`id`, b.`first_name`, b.`middle_name`, b.`last_name`, c.`name` AS `terminal_name` , a.`date`, a.`amount`, a.`driver_id`, a.`terminal_id` " . 
                    "FROM `frs_fares` AS a " .
                    "INNER JOIN `frs_drivers` AS b " .
                    "ON a.`driver_id` = b.`id` " .
                    "INNER JOIN `frs_terminals` AS c " .
                    "ON a.`terminal_id` = c.`id` " .
                    "WHERE a.`deleted` != b'1' " .
                    "ORDER BY a.`date` DESC";
      $fare_stmt = $this->db->query($fare_sql);
?>
<!DOCTYPE html>
<html style="background-color: #00693e;">
<head>
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
        <h1>Fare Collections &mdash; Booking Fees</h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="bi bi-speedometer2"></i> Home</a></li>
          <li class="active">Fare Collections</li>
        </ol>
      </section>

      <!-- Main Content -->
      <section class="content">
        <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <div class="box-header with-border">
                <a href="#addnew" data-toggle="modal" class="btn btn-sm btn-flat axis-btn-green">Add Fare Collection</a> 
              </div>
              <div class="box-body table-responsive">
                <table id="example1" class="table table-bordered">
                  <thead>
                    <th style="width: 12px; max-width: 12px !important;">#</th>
                    <th>Date</th>
                    <th>Driver</th>
                    <th>Terminal</th>
                    <th>Amount</th>
                    <th style="width: 78px; min-width: 78px !important;">Action</th>
                  </thead>
                  <tbody>
      <?php
      $id = 1;
      while ($row = $fare_stmt->fetch()) { ?>
                    <tr>
                      <td><?php echo $id; ?></td>
                      <td><?php echo $row['date']; ?></td>
                      <td>
                        <?php
                          $name =   $row['first_name'] . " ";
                          $name .=  ($row['middle_name'] != "") ? $row['middle_name'] . " " : "";
                          $name .=  $row['last_name'];
                          echo $name;
                        ?>
                      </td>
                      <td><?php echo $row['terminal_name']; ?></td>
                      <td style="text-align: right;">Php <?php echo number_format($row['amount'], 2); ?></td>
                      <td>
                        <button class='btn btn-success btn-sm edit btn-flat' 
                        data-edit_fare_id='<?php echo $row['id']; ?>'
                        data-edit_date='<?php echo (new DateTime($row['date']))->format('m/d/Y'); ?>'
                        data-edit_driver_id='<?php echo $row['driver_id']; ?>'
                        data-edit_driver_name='<?php echo $name; ?>'
                        data-edit_terminal_id='<?php echo $row['terminal_id']; ?>'
                        data-edit_terminal_name='<?php echo $row['terminal_name']; ?>'
                        data-edit_amount='<?php echo $row['amount']; ?>'> Edit</button>
                        <button class='btn btn-danger btn-sm delete btn-flat' 
                        data-delete_fare_id='<?php echo $row['id']; ?>'> Delete</button>
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

<?php include '../common/footer.php'; ?>
<?php include '../modal/profileModal.php'; ?>
<?php include '../modal/fareModal.php'; ?>
<?php include '../modal/messageModal.php'; ?>

  <script>
    $(document).ready(function() {
      $("#date").datepicker();
      $("#edit_date").datepicker();
      $("#driver_id").select2();
      $("#terminal_id").select2();
    });

    $(document).on('click', '.edit', function(e){
      e.preventDefault();
      $('#edit').modal('show');
      var edit_fare_id = $(this).data('edit_fare_id');
      var edit_date = $(this).data('edit_date');
      var edit_driver_id = $(this).data('edit_driver_id');
      var edit_driver_name = $(this).data('edit_driver_name');
      var edit_terminal_id = $(this).data('edit_terminal_id');
      var edit_terminal_name = $(this).data('edit_terminal_name');
      var edit_amount = $(this).data('edit_amount');
      $('#edit_fare_id').val(edit_fare_id)
      $('#edit_date').datepicker('setDate', new Date(edit_date));
      $('#edit_driver_id').val(edit_driver_id)
      $('#edit_driver_name').val(edit_driver_name)
      $('#edit_terminal_id').val(edit_terminal_id)
      $('#edit_terminal_name').val(edit_terminal_name)
      $('#edit_amount').val(edit_amount)
    });

    $(document).on('click', '.delete', function(e){
      e.preventDefault();
      $('#delete').modal('show');
      var delete_fare_id = $(this).data('delete_fare_id');
      $('#delete_fare_id').val(delete_fare_id)
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

<?php
  }
}
$fare = new Fare(); $fare->getData();
?>

</body>
</html>