<?php
/*
* Salary View
* Description: Salaries View
* Author: Vernyll Jan P. Asis
*/

session_start();
if(!isset($_SESSION['type'])) {
header('location: ./');
}

require_once '../config/config.php';
class Salary {
    private $db;

    public function __construct() {
            $conn = new Connection();
            $this->db = $conn->getConnection();
    }

    public function getData(){
        $salary_sql =   "SELECT
                            a.`id`,
                            b.`first_name`,
                            b.`last_name`,
                            a.`date`,
                            a.`collection`,
                            a.`salary`,
                            a.`driver_id`,
                            a.`rate_id`,
                            c.`quota`,
                            c.`base_salary`,
                            c.`base_rate`,
                            c.`excess_rate` " .
                        "FROM `frs_salaries` AS a " .
                        "INNER JOIN `frs_drivers` AS b " .
                        "ON a.`driver_id` = b.`id` " .
                        "INNER JOIN `frs_rates` AS c " .
                        "ON a.`rate_id` = c.`id` " .
                        "ORDER BY a.`date` DESC, b.`first_name` ASC";
        $salary_stmt = $this->db->query($salary_sql);
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
            <h1>Salaries</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="bi bi-speedometer2"></i> Home</a></li>
                <li class="active">Salaries</li>
            </ol>
        </section>

        <!-- Main Content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <p>
                                <strong>FORMULAS</strong><br>
                                For collections meeting the quota: <span style="font-family: 'Courier New';">Base Salary + (Collection x Add-On Rate)</span><br>
                                For collections not meeting the quota: <span style="font-family: 'Courier New';">Collection x Base Rate</span>
                            </p>
                        </div>
                        <div class="box-body table-responsive">
                            <table id="example1" class="table table-bordered">
                                <thead>
                                    <th style="width: 12px; max-width: 12px !important;">#</th>
                                    <th>Date</th>
                                    <th>Name</th>
                                    <th>Salary Rates</th>
                                    <th>Collection</th>
                                    <th>Salary</th>
                                    <th style="width: 78px; min-width: 78px !important;">Action</th>
                                </thead>
                                <tbody>
<?php
$id = 1;
while ($row = $salary_stmt->fetch()) { ?>
<tr>
    <td><?php echo $id; ?></td>
    <td><?php echo $row['date']; ?></td>
    <td><?php echo $row['first_name'] . " " . $row['last_name']; ?></td>
    <td>
<?php
    echo "Quota: " . number_format($row['quota'], 2) . " | ";
    echo "Base Salary: " . number_format($row['base_salary'], 2) . " | ";
    echo "Base Rate: " . $row['base_rate'] . "% | ";
    echo "Add-On Rate: " . $row['excess_rate'] . "%";
?>
    </td>
    <td style="text-align: right;">Php <?php echo number_format($row['collection'], 2); ?></td>
    <td style="text-align: right;">Php <?php echo number_format($row['salary'], 2); ?></td>
    <td>
        <button class="btn btn-success btn-sm edit btn-flat"
        data-edit_salary_id="<?php echo $row['id']; ?>"
        data-edit_rate_id="<?php echo $row['rate_id']; ?>"> Change Rates</button>
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
<?php include '../modal/salaryModal.php'; ?>
<?php include '../modal/messageModal.php'; ?>

<script>
    $(document).ready(function() {
        $("#start_date").select2();
    });

    $(document).on('click', '.recompute', function(e){
        e.preventDefault();
        $('#recompute').modal('show');
        var compute_salary_id = $(this).data('compute_salary_id');
        $('#compute_salary_id').val(compute_salary_id)
    });

    $(document).on('click', '.pay', function(e){
        e.preventDefault();
        $('#pay').modal('show');
        var pay_salary_id = $(this).data('pay_salary_id');
        $('#pay_salary_id').val(pay_salary_id)
    });
</script>

<script>
    <?php if (isset($_SESSION['computed'])) { ?>
    $('#computed').modal('show');
    <?php unset($_SESSION['computed']); } ?>

    <?php if (isset($_SESSION['error'])) { ?>
    $('#error').modal('show')
    <?php unset($_SESSION['error']); } ?>

    <?php if (isset($_SESSION['recomputed'])) { ?>
    $('#recomputed').modal('show');
    <?php unset($_SESSION['recomputed']); } ?>

    <?php if (isset($_SESSION['paid'])) { ?>
    $('#paid').modal('show');
    <?php unset($_SESSION['paid']); } ?>
</script>

<?php
}
}
$salary = new Salary(); $salary->getData();
?>

</body>
</html>