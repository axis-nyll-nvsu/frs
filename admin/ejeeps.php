<?php
/*
* E-Jeeps
* Description: E-Jeeps View
* Author: Vernyll Jan P. Asis
*/

session_start();
if(!isset($_SESSION['type'])) {
    header('location: ./');
}

require_once '../config/config.php';
class Ejeep {
    private $db;

    public function __construct() {
        $conn = new Connection();
        $this->db = $conn->getConnection();
    }

    public function getData(){
        $ejeep_sql = "SELECT * FROM `frs_ejeeps` WHERE `deleted` != b'1'";
        $ejeep_stmt = $this->db->query($ejeep_sql);
        return $ejeep_stmt->fetchAll();
    }
}

$ejeep = new Ejeep();
$ejeeps = $ejeep->getData();
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
        <div class="content-wrapper">
            <section class="content-header">
                <h1>E-Jeeps</h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="bi bi-speedometer2"></i> Home</a></li>
                    <li class="active">E-Jeeps</li>
                </ol>
            </section>
            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-header with-border">
                                <a href="#addEjeep" data-toggle="modal" class="btn btn-sm btn-flat axis-btn-green">Add E-Jeep</a>
                            </div>
                            <div class="box-body table-responsive">
                                <table id="example1" class="table table-bordered">
                                    <thead>
                                        <th style="width: 12px; max-width: 12px !important;">#</th>
                                        <th>Plate Number</th>
                                        <th style="width: 78px; min-width: 78px !important;">Action</th>
                                    </thead>
                                    <tbody>
<?php
$id = 1;
foreach ($ejeeps as $row) { ?>
<tr>
    <td><?php echo $id; ?></td>
    <td><?php echo $row['plate']; ?></td>
    <td>
        <button class="btn btn-success btn-sm edit btn-flat"
        data-edit_ejeep_id="<?php echo $row['id']; ?>"
        data-edit_plate="<?php echo $row['plate']; ?>"> Edit</button>
        <button class="btn btn-danger btn-sm delete btn-flat"
        data-delete_ejeep_id="<?php echo $row['id']; ?>"> Delete</button>
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
<?php include '../modal/addEjeepModal.php'; ?>
<?php include '../modal/ejeepModal.php'; ?>
<?php include '../modal/messageModal.php'; ?>
<script>
$(document).on('click', '.edit', function(e){
    e.preventDefault();
    $('#edit').modal('show');
    var edit_ejeep_id = $(this).data('edit_ejeep_id');
    var edit_plate = $(this).data('edit_plate');
    $('#edit_ejeep_id').val(edit_ejeep_id)
    $('#edit_plate').val(edit_plate)
});

$(document).on('click', '.delete', function(e){
    e.preventDefault();
    $('#delete').modal('show');
    var delete_ejeep_id = $(this).data('delete_ejeep_id');
    $('#delete_ejeep_id').val(delete_ejeep_id)
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
</body>
</html>