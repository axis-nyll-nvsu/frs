<?php
/*
 * sidebar.php
 * Description: Global HTML Sidebar
 * Author: 
 * Modified: 11-23-2024
 */
?>

<link rel="stylesheet" type="text/css" href="../dist/css/style.css">
<aside class="main-sidebar" style="overflow-y: auto; position: fixed; top: 0;">
  <section class="sidebar">
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header" style="color: #fff;font-size: 26px;display: flex;place-items: center;margin-left: 15px;">
        <img src="../images/logo.png" width="50px"> <h4 style="margin-left: 10px;">Financial Reporting <br>Management System</h4>
      </li>
      <li class="axis-header"><img src="../images/logo.png" width="50px"></li>

<?php if ($_SESSION['type'] == 0): // Administrator ?>
      <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> <span> Dashboard</span></a></li>
      <li><a href="drivers.php"><i class="fa fa-car-side"></i> <span> Drivers</span></a></li>
      <li><a href="remunerations.php"><i class="fa fa-money"></i> <span> Remunerations</span></a></li>
      <li><a href="fares.php"><i class="fa fa-money"></i> <span> Fare Collections</span></a></li>
      <li><a href="collections.php"><i class="fa fa-wallet"></i> <span> Other Collections</span></a></li>
      <li><a href="expenses.php"><i class="fa fa-money-check"></i> <span> Expenses</span></a></li>
      <li class="treeview">
        <a href="#"><i class="fa fa-file-pdf"></i> <span> Financial Reports</span><span class="pull-right-container"><i class="fa fa-angle-down pull-right"></i></span></a>
        <ul class="treeview-menu">
          <li><a href="income_statement.php"><i class="fa fa-angle-right"></i> Income Statement</a></li>
          <li><a href="cashflow_statement.php"><i class="fa fa-angle-right"></i> Statement of Cash Flows</a></li>
          <li><a href="profits.php"><i class="fa fa-angle-right"></i> Daily Profits</a></li>
        </ul>
      </li>
      <li><a href="accounts.php"><i class="fa fa-users"></i> <span> Accounts</span></a></li>
      <li><a href="audittrail.php"><i class="fa fa-list"></i> <span> Audit Trail</span></a></li>
<?php endif; ?>

<?php if ($_SESSION['type'] == 1): // Manager ?>
      <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> <span> Dashboard</span></a></li>
      <li><a href="drivers.php"><i class="fa fa-car-side"></i> <span> Drivers</span></a></li>
      <li><a href="remunerations.php"><i class="fa fa-money"></i> <span> Remunerations</span></a></li>
      <li><a href="fares.php"><i class="fa fa-money"></i> <span> Fare Collections</span></a></li>
      <li><a href="collections.php"><i class="fa fa-wallet"></i> <span> Other Collections</span></a></li>
      <li><a href="expenses.php"><i class="fa fa-money-check"></i> <span> Expenses</span></a></li>
      <li class="treeview">
        <a href="#"><i class="fa fa-file-pdf"></i> <span> Financial Reports</span><span class="pull-right-container"><i class="fa fa-angle-down pull-right"></i></span></a>
        <ul class="treeview-menu">
          <li><a href="income_statement.php"><i class="fa fa-angle-right"></i> Income Statement</a></li>
          <li><a href="cashflow_statement.php"><i class="fa fa-angle-right"></i> Statement of Cash Flows</a></li>
          <li><a href="profits.php"><i class="fa fa-angle-right"></i> Daily Profits</a></li>
        </ul>
      </li>
<?php endif; ?>

<?php if ($_SESSION['type'] == 2): // Cashier ?>
      <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> <span> Dashboard</span></a></li>
      <li><a href="fares.php"><i class="fa fa-money"></i> <span> Fare Collections</span></a></li>
      <li><a href="collections.php"><i class="fa fa-wallet"></i> <span> Other Collections</span></a></li>
      <li><a href="expenses.php"><i class="fa fa-money-check"></i> <span> Expenses</span></a></li>
<?php endif; ?>

    </ul>
  </section>
</aside>
