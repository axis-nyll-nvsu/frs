<?php
/*
 * Rate View
 * Description: Rate View
 * Author: Vernyll Jan P. Asis
 */

session_start();
if(!isset($_SESSION['type'])) {
    header('location: ./');
}

require_once '../config/config.php';
    class Rate {
        private $db;

        public function __construct() {
            $conn = new Connection();
            $this->db = $conn->getConnection();
        }

        public function getData(){ 
            $routes_sql = "SELECT * FROM `frs_rates` WHERE `deleted` != b'1'";
            $routes_stmt = $this->db->query($routes_sql);
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
                <h1>Salary Rates</h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="bi bi-speedometer2"></i> Home</a></li>
                    <li class="active">Rates</li>
                </ol>
            </section>

            <!-- Main Content -->
            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-header with-border">
                                <a href="#addRate" data-toggle="modal" class="btn btn-sm btn-flat axis-btn-green">Add Rate</a>
                            </div>
                            <div class="box-body table-responsive">
                                <table id="example1" class="table table-bordered">
                                    <thead>
                                        <th style="width: 12px; max-width: 12px !important;">#</th>
                                        <th>Quota</th>
                                        <th>Base Salary</th>
                                        <th>Base Rate</th>
                                        <th>Add-On Rate</th>
                                        <th style="width: 78px; min-width: 78px !important;">Action</th>
                                    </thead>
                                    <tbody>
<?php
$id = 1;
while ($row = $routes_stmt->fetch()) { ?>
<tr>
    <td><?php echo $id; ?></td>
    <td><?php echo $row['quota']; ?></td>
    <td><?php echo $row['base_salary']; ?></td>
    <td><?php echo $row['base_rate']; ?>%</td>
    <td><?php echo $row['addon_rate']; ?>%</td>
    <td>
        <button class="btn btn-success btn-sm edit btn-flat"
        data-edit_rate_id="<?php echo $row['id']; ?>"
        data-edit_quota="<?php echo $row['quota']; ?>"
        data-edit_base_salary="<?php echo $row['base_salary']; ?>"
        data-edit_base_rate="<?php echo $row['base_rate']; ?>"
        data-edit_addon_rate="<?php echo $row['addon_rate']; ?>"> Edit</button>
        <button class="btn btn-danger btn-sm delete btn-flat"
        data-delete_route_id="<?php echo $row['id']; ?>"> Delete</button>
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
<?php include '../modal/rateModal.php'; ?>
<?php include '../modal/messageModal.php'; ?>
<script>
$(document).on('click', '.edit', function(e){
    e.preventDefault();
    $('#edit').modal('show');
    var edit_rate_id = $(this).data('edit_rate_id');
    var edit_quota = $(this).data('edit_quota');
    var edit_base_salary = $(this).data('edit_base_salary');
    var edit_base_rate = $(this).data('edit_base_rate');
    var edit_addon_rate = $(this).data('edit_addon_rate');
    $('#edit_route_id').val(edit_route_id)
    $('#edit_quota').val(edit_route_id)
    $('#edit_base_salary').val(edit_quota)
    $('#edit_base_rate').val(edit_base_rate)
    $('#edit_addon_rate').val(edit_addon_rate)
});

$(document).on('click', '.delete', function(e){
    e.preventDefault();
    $('#delete').modal('show');
    var delete_rate_id = $(this).data('delete_rate_id');
    $('#delete_rate_id').val(delete_rate_id)
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
$rate = new Rate(); $rate->getData();
?>

</body>
</html>