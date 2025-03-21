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
            $collection_sql = "SELECT a.`id`, b.`first_name`, b.`last_name`, c.`plate`, d.`description`, a.`date`, a.`amount`, a.`driver_id`, a.`ejeep_id`, a.`route_id` " .
                                        "FROM `frs_collections` AS a " .
                                        "INNER JOIN `frs_drivers` AS b " .
                                        "ON a.`driver_id` = b.`id` " .
                                        "INNER JOIN `frs_ejeeps` AS c " .
                                        "ON a.`ejeep_id` = c.`id` " .
                                        "INNER JOIN `frs_routes` AS d " .
                                        "ON a.`route_id` = d.`id` " .
                                        "WHERE a.`deleted` != b'1' " .
                                        "ORDER BY a.`date` DESC";
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
                <h1>Collections</h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="bi bi-speedometer2"></i> Home</a></li>
                    <li class="active">Collections</li>
                </ol>
            </section>

            <!-- Main Content -->
            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-header with-border">
                                <a href="#addCollection" data-toggle="modal" class="btn btn-sm btn-flat axis-btn-green">Add Collection</a>
                            </div>
                            <div class="box-body table-responsive">
                                <table id="example1" class="table table-bordered">
                                    <thead>
                                        <th style="width: 12px; max-width: 12px !important;">#</th>
                                        <th>Date</th>
                                        <th>Driver</th>
                                        <th>E-Jeep</th>
                                        <th>Route</th>
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
                                            <td><?php $name = $row['first_name'] . " " . $row['last_name']; echo $name; ?>
                                            </td>
                                            <td><?php echo $row['plate']; ?></td>
                                            <td><?php echo $row['description']; ?></td>
                                            <td style="text-align: right;">Php <?php echo number_format($row['amount'], 2); ?></td>
                                            <td>
                                                <button class='btn btn-success btn-sm editCollection btn-flat'
                                                data-edit_collection_id='<?php echo $row['id']; ?>'
                                                data-edit_date='<?php echo (new DateTime($row['date']))->format('m/d/Y'); ?>'
                                                data-edit_driver_id='<?php echo $row['driver_id']; ?>'
                                                data-edit_driver_name='<?php echo $name; ?>'
                                                data-edit_ejeep_id='<?php echo $row['ejeep_id']; ?>'
                                                data-edit_ejeep_plate='<?php echo $row['plate']; ?>'
                                                data-edit_route_id='<?php echo $row['route_id']; ?>'
                                                data-edit_route_description='<?php echo $row['description']; ?>'
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
<?php include '../modal/addCollectionModal.php'; ?>
<?php include '../modal/collectionModal.php'; ?>
<?php include '../modal/messageModal.php'; ?>
<script>
$(document).ready(function() {
    $("#date").datepicker();
    $("#driver_id").select2();
    $("#ejeep_id").select2();
    $("#route_id").select2();
    $("#rate_id").select2();
});

$(document).on('click', '.editCollection', function(e){
    e.preventDefault();
    $('#editCollection').modal('show');
    var edit_collection_id = $(this).data('edit_collection_id');
    var edit_date = $(this).data('edit_date');
    var edit_driver_id = $(this).data('edit_driver_id');
    var edit_driver_name = $(this).data('edit_driver_name');
    var edit_ejeep_id = $(this).data('edit_ejeep_id');
    var edit_ejeep_plate = $(this).data('edit_ejeep_plate');
    var edit_route_id = $(this).data('edit_route_id');
    var edit_route_description = $(this).data('edit_route_description');
    var edit_amount = $(this).data('edit_amount');
    $('#edit_collection_id').val(edit_collection_id)
    $('#edit_date').datepicker('setDate', new Date(edit_date));
    $('#edit_driver_id').val(edit_driver_id)
    $('#edit_driver_name').val(edit_driver_name)
    $('#edit_ejeep_id').val(edit_ejeep_id)
    $('#edit_ejeep_plate').val(edit_ejeep_plate)
    $('#edit_route_id').val(edit_route_id)
    $('#edit_route_description').val(edit_route_description)
    $('#edit_amount').val(edit_amount)
});

$(document).on('click', '.delete', function(e){
    e.preventDefault();
    $('#deleteCollection').modal('show');
    var delete_collection_id = $(this).data('delete_collection_id');
    $('#delete_collection_id').val(delete_collection_id)
});

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