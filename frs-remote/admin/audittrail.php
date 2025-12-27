<?php
/*
 * Audit Trail
 * Description: Audit Trail View
 * Author: Vernyll Jan P. Asis
 */

session_start();
if(!isset($_SESSION['type'])) {
    header('location: ./');
}

require_once '../config/config.php';
date_default_timezone_set('Asia/Manila');
class Trail {
    private $db;

    public function __construct() {
        $conn = new Connection();
        $this->db = $conn->getConnection();
    }

    public function getData(){
        $trail_sql = "SELECT * FROM `frs_trail` AS a JOIN `frs_users` AS b ON a.`user_id` = b.`id` ORDER BY a.`date` DESC";
        $trail_stmt = $this->db->query($trail_sql);
        return $trail_stmt->fetchAll();
    }
}

$trail = new Trail();
$trails = $trail->getData();
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
                <h1>Audit Trail</h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="bi bi-speedometer2"></i> Home</a></li>
                    <li>Administration</li>
                    <li class="active">Audit Trail</li>
                </ol>
            </section>
            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-body table-responsive">
                                <table id="example1" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 12px; max-width: 12px !important;">#</th>
                                            <th style="width: 120px; max-width: 120px !important;">Date & Time</th>
                                            <th style="width: 250px; max-width: 250px !important;">Name</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php
$id = 1;
foreach ($trails as $row) { ?>
<tr>
    <td><?php echo $id; ?></td>
    <td><?php echo (new DateTime($row['date']))->format('M d, Y h:iA'); ?></td>
    <td><?php echo $row['first_name'] . " " . $row['last_name']; ?></td>
    <td><?php echo $row['description']; ?></td>
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
</body>
</html>