<?php
/*
 * Collections
 * Description: Collections View
 * Author: Vernyll Jan P. Asis
 */

  session_start();
  if(!isset($_SESSION['type'])) {
    header('location: ./');
  }

 require_once '../config/config.php';
  class Collection {
    private $db;

    public function __construct() {
        $conn = new Connection();
        $this->db = $conn->getConnection();
    }

    public function getData(){ 
      $collection_sql = "SELECT a.`id`, a.`receipt`, b.`description` AS `category`, a.`date`, a.`amount`, a.`category_id` " . 
                    "FROM `frs_collections` AS a " .
                    "INNER JOIN `frs_categories` AS b " .
                    "ON a.`category_id` = b.`id` " .
                    "WHERE a.`deleted` != b'1' " .
                    "ORDER BY a.`date` DESC, b.`id` ASC";
      $collection_stmt = $this->db->query($collection_sql);
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
        <h1>Other Collections</h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="bi bi-speedometer2"></i> Home</a></li>
          <li class="active">Other Collections</li>
        </ol>
      </section>

      <!-- Main Content -->
      <section class="content">
        <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <div class="box-header with-border">
                <a href="#addnew" data-toggle="modal" class="btn btn-sm btn-flat axis-btn-green">Add Other Collection</a> 
              </div>
              <div class="box-body table-responsive">
                <table id="example1" class="table table-bordered">
                  <thead>
                    <th style="width: 12px; max-width: 12px !important;">#</th>
                    <th>Date</th>
                    <th>OR Number</th>
                    <th>Collection</th>
                    <th>Amount</th>
                    <th style="width: 78px; min-width: 78px !important;">Action</th>
                  </thead>
                  <tbody>
      <?php
      $id = 1;
      while ($row = $collection_stmt->fetch()) { ?>
                    <tr>
                      <td><?php echo $id; ?></td>
                      <td><?php echo $row['date']; ?></td>
                      <td><?php echo $row['receipt']; ?></td>
                      <td><?php echo $row['category']; ?></td>
                      <td style="text-align: right;">Php <?php echo number_format($row['amount'], 2); ?></td>
                      <td>
                        <button class='btn btn-success btn-sm edit btn-flat' 
                        data-edit_collection_id='<?php echo $row['id']; ?>'
                        data-edit_date='<?php echo (new DateTime($row['date']))->format('m/d/Y'); ?>'
                        data-edit_receipt='<?php echo $row['receipt']; ?>'
                        data-edit_category_id='<?php echo $row['category_id']; ?>'
                        data-edit_category_name='<?php echo $row['category']; ?>'
                        data-edit_amount='<?php echo $row['amount']; ?>'> Edit</button>
                        <button class='btn btn-danger btn-sm delete btn-flat' 
                        data-delete_collection_id='<?php echo $row['id']; ?>'> Delete</button>
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
<?php include '../modal/collectionModal.php'; ?>
<?php include '../modal/messageModal.php'; ?>

  <script>
    $(document).ready(function() {
      $("#date").datepicker();
      $("#edit_date").datepicker();
      $("#category_id").select2();
    });

    $(document).on('click', '.edit', function(e){
      e.preventDefault();
      $('#edit').modal('show');
      var edit_collection_id = $(this).data('edit_collection_id');
      var edit_date = $(this).data('edit_date');
      var edit_receipt = $(this).data('edit_receipt');
      var edit_category_id = $(this).data('edit_category_id');
      var edit_category_name = $(this).data('edit_category_name');
      var edit_amount = $(this).data('edit_amount');
      $('#edit_collection_id').val(edit_collection_id)
      $('#edit_date').datepicker('setDate', new Date(edit_date))
      $('#edit_receipt').val(edit_receipt)
      $('#edit_category_id').val(edit_category_id)
      $('#edit_category_name').val(edit_category_name)
      $('#edit_amount').val(edit_amount)
    });

    $(document).on('click', '.delete', function(e){
      e.preventDefault();
      $('#delete').modal('show');
      var delete_collection_id = $(this).data('delete_collection_id');
      $('#delete_collection_id').val(delete_collection_id)
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
$collection = new Collection(); $collection->getData();
?>

</body>
</html>