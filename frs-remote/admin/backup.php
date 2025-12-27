<?php
/*
 * backup
 * Description: Backup View
 * Author: Charlene B. Dela Cruz
 */

session_start();
if (!isset($_SESSION['type'])) {
    header('location: ./');
    exit;
}

require_once '../config/config.php';
date_default_timezone_set('Asia/Manila');

class Backup {
    private $db;

    public function __construct() {
        $conn = new Connection();
        $this->db = $conn->getConnection();
    }

    public function getData() {
        return $this->db->query("SELECT * FROM backup_logs ORDER BY backup_date DESC");
    }

    public function backupSelectedTables($tables) {

    if (empty($tables)) return false;

    $backupDir = "../backups/";
    if (!is_dir($backupDir)) {
        mkdir($backupDir, 0777, true);
    }

    $date = date("Y-m-d_H-i-s");
    $filename = "backup_$date.sql";
    $path = $backupDir . $filename;

    $sqlDump = "SET FOREIGN_KEY_CHECKS=0;\n\n";

    foreach ($tables as $table) {

        // Get table structure
        $stmt = $this->db->query("SHOW CREATE TABLE `$table`");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) continue;

        $sqlDump .= "\n" . $row['Create Table'] . ";\n\n";

        // Get table data
        $rows = $this->db->query("SELECT * FROM `$table`");
        while ($data = $rows->fetch(PDO::FETCH_ASSOC)) {
            $columns = array_map(fn($col) => "`$col`", array_keys($data));
            $values = array_map(fn($val) => $this->db->quote($val), array_values($data));

            $sqlDump .= "INSERT INTO `$table` (" .
                implode(",", $columns) .
                ") VALUES (" .
                implode(",", $values) .
                ");\n";
        }
    }

    $sqlDump .= "\nSET FOREIGN_KEY_CHECKS=1;";

    file_put_contents($path, $sqlDump);

    // ✅ ADD AUDIT TRAIL ENTRY
    // Insert audit trail
    $description = "Created database backup: $filename";

    $stmt = $this->db->prepare("
    INSERT INTO frs_trail (user_id, description, date)
    VALUES (?, ?, NOW())
    ");

    $stmt->execute([
    $_SESSION['user_id'],
    $description
]);


    return true;
}

}

// ================= HANDLER =================
$backup = new Backup();
$message = "";

if (isset($_POST['backup_selected'])) {

    if (!empty($_POST['tables'])) {

        if ($backup->backupSelectedTables($_POST['tables'])) {
            $_SESSION['success'] = "Backup successfully created!";
        } else {
            $_SESSION['error'] = "Backup failed. Please try again.";
        }

    } else {
        $_SESSION['error'] = "Please select at least one table.";
    }

    echo "<script>window.location.href='../admin/backup.php';</script>";
    exit;
}


$data = $backup->getData();
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
<?php include '../modal/backupModal.php'; ?>

<div class="content-wrapper">

<section class="content-header">
    <h1>Backup Management</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="bi bi-speedometer2"></i> Home</a></li>
        <li>Administration</li>
        <li class="active">Backup</li>
    </ol>
</section>

<section class="content">

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Create Backup</h3>
        </div>

        <div class="box-body" style="color: #00693e;">
            <?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success">
        <?= $_SESSION['success']; ?>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger">
        <?= $_SESSION['error']; ?>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

            <button class="btn btn-flat axis-btn-green" data-toggle="modal" data-target="#backupModal">
                <i class="fa fa-database"></i> Backup Database
            </button>
        </div>
    </div>

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Backup History</h3>
        </div>

        <div class="box-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Backup File</th>
                        <th>Date</th>
                        <th>Performed By</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $rows = $data->fetchAll(PDO::FETCH_ASSOC);
                if (count($rows) > 0):
                    $i = 1;
                    foreach ($rows as $row):
                ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= htmlspecialchars($row['backup_file']) ?></td>
                        <td><?= htmlspecialchars($row['backup_date']) ?></td>
                        <td><?= htmlspecialchars($row['performed_by']) ?></td>
                    </tr>
                <?php endforeach; else: ?>
                    <tr>
                        <td colspan="4" class="text-center">No backup records found.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</section>
</div>

<?php include '../common/footer.php'; ?>
<?php include '../modal/profileModal.php'; ?>
<?php include '../modal/messageModal.php'; ?>

<?php if (isset($_SESSION['success'])): ?>
<script>
    $(document).ready(function () {
        $('#success').modal('show');
    });
</script>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
<script>
    $(document).ready(function () {
        $('#error').modal('show');
    });
</script>
<?php endif; ?>



</div>
</body>
</html>
