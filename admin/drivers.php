<?php
/*
 * drivers.php
 * Description: Drivers Page
 * Author: 
 * Modified: 11-28-2024
 */

  session_start();
  if(!isset($_SESSION['type'])) {
    header('location: ./');
  }

 require_once '../config/config.php';
  class Driver {
    private $db;

    public function __construct() {
        $conn = new Connection();
        $this->db = $conn->getConnection();
    }

    public function getData(){ 
      $driver_sql = "SELECT * FROM `frs_drivers` WHERE `deleted` != b'1'";
      $driver_stmt = $this->db->query($driver_sql);
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
        <h1>Drivers</h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="bi bi-speedometer2"></i> Home</a></li>
          <li class="active">Drivers</li>
        </ol>
      </section>

      <!-- Main Content -->
      <section class="content">
        <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <div class="box-header with-border">
                <a href="#addnew" data-toggle="modal" class="btn btn-sm btn-flat axis-btn-green">Add Driver</a> 
              </div>
              <div class="box-body table-responsive">
                <table id="example1" class="table table-bordered">
                  <thead>
                    <th style="width: 12px; max-width: 12px !important;">#</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Contact Number</th>
                    <th style="width: 78px; min-width: 78px !important;">Action</th>
                  </thead>
                  <tbody>
      <?php
      $id = 1;
      while ($row = $driver_stmt->fetch()) { ?>
                    <tr>
                      <td><?php echo $id; ?></td>
                      <td>
                        <?php
                          echo $row['first_name'] . " ";
                          echo ($row['middle_name'] != "") ? $row['middle_name'] . " " : "";
                          echo $row['last_name'];
                        ?>
                      </td>
                      <td><?php echo $row['address']; ?></td>
                      <td><?php echo $row['contact']; ?></td>
                      <td>
                        <button class='btn btn-success btn-sm edit btn-flat' 
                        data-edit_driver_id='<?php echo $row['id']; ?>'
                        data-edit_firstname='<?php echo $row['first_name']; ?>'
                        data-edit_lastname='<?php echo $row['last_name']; ?>'
                        data-edit_middlename='<?php echo $row['middle_name']; ?>'
                        data-edit_address='<?php echo $row['address']; ?>'
                        data-edit_contact='<?php echo $row['contact']; ?>'> Edit</button>
                        <button class='btn btn-danger btn-sm delete btn-flat' 
                        data-delete_driver_id='<?php echo $row['id']; ?>'> Delete</button>
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
<?php include 'modal/driverModal.php'; ?>
<?php include 'modal/messageModal.php'; ?>

  <script>
    $(document).on('click', '.edit', function(e){
      e.preventDefault();
      $('#edit').modal('show');
      var edit_driver_id = $(this).data('edit_driver_id');
      var edit_firstname = $(this).data('edit_firstname');
      var edit_lastname = $(this).data('edit_lastname');
      var edit_middlename = $(this).data('edit_middlename');
      var edit_address = $(this).data('edit_address');
      var edit_contact = $(this).data('edit_contact');
      $('#edit_driver_id').val(edit_driver_id)
      $('#edit_firstname').val(edit_firstname)
      $('#edit_lastname').val(edit_lastname)
      $('#edit_middlename').val(edit_middlename)
      $('#edit_address').val(edit_address)
      $('#edit_contact').val(edit_contact)
    });

    $(document).on('click', '.delete', function(e){
      e.preventDefault();
      $('#delete').modal('show');
      var delete_driver_id = $(this).data('delete_driver_id');
      $('#delete_driver_id').val(delete_driver_id)
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
$driver = new Driver(); $driver->getData();
?>

</body>
</html>