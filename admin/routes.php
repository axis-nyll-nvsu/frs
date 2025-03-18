<?php
/*
 * Routes
 * Description: Routes View
 * Author: Charlene B. Dela Cruz
 */

session_start();
if(!isset($_SESSION['type'])) {
    header('location: ./');
}

require_once '../config/config.php';
    class Route {
        private $db;

        public function __construct() {
            $conn = new Connection();
            $this->db = $conn->getConnection();
        }

        public function getData(){ 
            $routes_sql = "SELECT * FROM `frs_routes` WHERE `deleted` != b'1'";
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
                <h1>E-Jeep Routes</h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="bi bi-speedometer2"></i> Home</a></li>
                    <li>Administration</li>
                    <li class="active">E-Jeep Routes</li>
                </ol>
            </section>

            <!-- Main Content -->
            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-header with-border">
                                <a href="#addRoute" data-toggle="modal" class="btn btn-sm btn-flat axis-btn-green">Add Route</a>
                            </div>
                            <div class="box-body table-responsive">
                                <table id="example1" class="table table-bordered">
                                    <thead>
                                        <th style="width: 12px; max-width: 12px !important;">#</th>
                                        <th>Route</th>
                                        <th style="width: 78px; min-width: 78px !important;">Action</th>
                                    </thead>
                                    <tbody>
            <?php
            $id = 1;
            while ($row = $routes_stmt->fetch()) { ?>
                                        <tr>
                                            <td><?php echo $id; ?></td>
                                            <td><?php echo $row['description']; ?></td>
                                            <td>
                                                <button class="btn btn-success btn-sm edit btn-flat"
                                                data-edit_route_id="<?php echo $row['id']; ?>"
                                                data-edit_description="<?php echo $row['description']; ?>"> Edit</button>
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
<?php include '../modal/addRouteModal.php'; ?>
<?php include '../modal/routeModal.php'; ?>
<?php include '../modal/messageModal.php'; ?>

    <script>
        $(document).on('click', '.edit', function(e){
            e.preventDefault();
            $('#edit').modal('show');
            var edit_route_id = $(this).data('edit_route_id');
            var edit_description = $(this).data('edit_description');
            $('#edit_route_id').val(edit_route_id)
            $('#edit_description').val(edit_description)
        });

        $(document).on('click', '.delete', function(e){
            e.preventDefault();
            $('#delete').modal('show');
            var delete_route_id = $(this).data('delete_route_id');
            $('#delete_route_id').val(delete_route_id)
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
$route = new Route(); $route->getData();
?>

</body>
</html>