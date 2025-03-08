<?php
/*
 * accounts.php
 * Description: Accounts Page
 * Author: 
 * Modified: 12-27-2024
 */

  session_start();
  if(!isset($_SESSION['type'])) {
    header('location: ./');
  }

 require_once '../config/config.php';
  class Account {
    private $db;

    public function __construct() {
        $conn = new Connection();
        $this->db = $conn->getConnection();
    }

    public function getData(){ 
      $account_sql = "SELECT * FROM `frs_users` WHERE `id` != 1 AND `deleted` != b'1'";
      $account_stmt = $this->db->query($account_sql);
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
        <h1>Accounts</h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="bi bi-speedometer2"></i> Home</a></li>
          <li class="active">Accounts</li>
        </ol>
      </section>

      <!-- Main Content -->
      <section class="content">
        <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <div class="box-header with-border">
                <a href="#addnew" data-toggle="modal" class="btn btn-sm btn-flat axis-btn-green">Add Account</a> 
              </div>
              <div class="box-body table-responsive">
                <table id="example1" class="table table-bordered">
                  <thead>
                    <th style="width: 12px; max-width: 12px !important;">#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Type</th>
                    <th style="width: 78px; min-width: 78px !important;">Action</th>
                  </thead>
                  <tbody>
      <?php
      $id = 1;
      while ($row = $account_stmt->fetch()) { ?>
                    <tr>
                      <td><?php echo $id; ?></td>
                      <td>
                        <?php
                          echo $row['first_name'] . " ";
                          echo ($row['middle_name'] != "") ? $row['middle_name'] . " " : "";
                          echo $row['last_name'];
                        ?>
                      </td>
                      <td><?php echo $row['email']; ?></td>
                      <td>
                        <?php
                        switch($row['type']) {
                          case 0: echo "Administrator"; break;
                          case 1: echo "Manager"; break;
                          case 2: echo "Cashier"; break;
                        }
                        ?>
                      </td>
                      <td>
                        <button class='btn btn-success btn-sm edit btn-flat' 
                        data-edit_account_id='<?php echo $row['id']; ?>'
                        data-edit_type='<?php echo $row['type']; ?>'
                        data-edit_email='<?php echo $row['email']; ?>'
                        data-edit_firstname='<?php echo $row['first_name']; ?>'
                        data-edit_middlename='<?php echo $row['middle_name']; ?>'
                        data-edit_lastname='<?php echo $row['last_name']; ?>'
                        data-edit_address='<?php echo $row['address']; ?>'
                        data-edit_contact='<?php echo $row['contact']; ?>'> Edit</button>
                        <button class='btn btn-danger btn-sm delete btn-flat' 
                        data-delete_account_id='<?php echo $row['id']; ?>'> Delete</button>
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
<?php include 'modal/accountModal.php'; ?>
<?php include 'modal/messageModal.php'; ?>

  <script>
    $(document).ready(function() {
      $('#type').select2();
      $('#edit_type').select2();
    });

    $(document).on('click', '.edit', function(e){
      e.preventDefault();
      $('#edit').modal('show');
      var edit_account_id = $(this).data('edit_account_id');
      var edit_type = $(this).data('edit_type');
      var edit_email = $(this).data('edit_email');
      var edit_firstname = $(this).data('edit_firstname');
      var edit_middlename = $(this).data('edit_middlename');
      var edit_lastname = $(this).data('edit_lastname');
      var edit_address = $(this).data('edit_address');
      var edit_contact = $(this).data('edit_contact');
      $('#edit_account_id').val(edit_account_id)
      $('#edit_type').val(edit_type)
      $('#edit_email').val(edit_email)
      $('#edit_firstname').val(edit_firstname)
      $('#edit_middlename').val(edit_middlename)
      $('#edit_lastname').val(edit_lastname)
      $('#edit_address').val(edit_address)
      $('#edit_contact').val(edit_contact)
    });

    $(document).on('click', '.delete', function(e){
      e.preventDefault();
      $('#delete').modal('show');
      var delete_account_id = $(this).data('delete_account_id');
      $('#delete_account_id').val(delete_account_id)
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
$account = new Account(); $account->getData();
?>

</body>
</html>