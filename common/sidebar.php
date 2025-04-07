<?php
/*
 * Side Bar
 * Description: Common Side Bar Template
 * Author: Vernyll Jan P. Asis
 */
?>

<aside class="main-sidebar" style="overflow-y: auto; position: fixed; top: 0;">
    <section class="sidebar">
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header" style="color: #fff;font-size: 26px;display: flex;place-items: center;margin-left: 15px;">
                <img src="../images/logo.png" width="50px"> <h4 style="margin-left: 10px;">FNVTTC<br><span style="font-size: 0.9em;">Financial Reporting System<span></h4>
            </li>
            <li class="axis-header"><img src="../images/logo.png" width="50px"></li>
<?php if ($_SESSION['type'] == 0): // Administrator ?>
            <li><a href="dashboard.php"><i class="bi bi-speedometer2"></i><span>Dashboard</span></a></li>
            <li><a href="ejeeps.php"><i class="bi bi-truck-front"></i><span>E-Jeeps</span></a></li>
            <li><a href="drivers.php"><i class="bi bi-person-circle"></i><span>Drivers</span></a></li>
            <li><a href="collections.php"><i class="bi bi-cash-stack"></i><span>Collections</span></a></li>
            <li><a href="salaries.php"><i class="bi bi-wallet2"></i><span>Salaries</span></a></li>
            <li><a href="expenses.php"><i class="bi bi-receipt"></i><span>Expenses</span></a></li>
            <li class="treeview">
                <a href="#">
                    <i class="bi bi-file-earmark-pdf"></i><span>Reports</span>
                    <span class="pull-right-container"><i class="bi bi-chevron-down pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="payroll.php"><i class="bi bi-cash-coin"></i><span>Weekly Payroll</span></a></li>
                    <li><a href="report.php"><i class="bi bi-cash-coin"></i><span>Monthly Report</span></a></li>
                    <li><a href="income_statement.php"><i class="bi bi-cash-coin"></i><span>Income Statement</span></a></li>
                    <li><a href="cashflow_statement.php"><i class="bi bi-cash-coin"></i><span>Statement of Cash Flows</span></a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="bi bi-database-fill-gear"></i><span>Administration</span>
                    <span class="pull-right-container"><i class="bi bi-chevron-down pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="accounts.php"><i class="bi bi-people"></i><span>User Accounts</span></a></li>
                    <li><a href="audittrail.php"><i class="bi bi-list-check"></i><span>Audit Trail</span></a></li>
                    <li><a href="routes.php"><i class="bi bi-sign-turn-slight-right-fill"></i><span>E-Jeep Routes</span></a></li>
                    <li><a href="rates.php"><i class="bi bi-percent"></i><span>Salary Rates</span></a></li>
                    <li><a href="categories.php"><i class="bi bi-tags"></i><span>Expense Categories</span></a></li>
                </ul>
            </li>
<?php elseif ($_SESSION['type'] == 1): // Manager ?>
            <li><a href="dashboard.php"><i class="bi bi-speedometer2"></i><span>Dashboard</span></a></li>
            <li><a href="ejeeps.php"><i class="bi bi-truck-front"></i><span>E-Jeeps</span></a></li>
            <li><a href="drivers.php"><i class="bi bi-person-circle"></i><span>Drivers</span></a></li>
            <li><a href="collections.php"><i class="bi bi-cash-stack"></i><span>Collections</span></a></li>
            <li><a href="salaries.php"><i class="bi bi-wallet2"></i><span>Salaries</span></a></li>
            <li><a href="payroll.php"><i class="bi bi-cash-coin"></i><span>Payroll</span></a></li>
            <li><a href="expenses.php"><i class="bi bi-receipt"></i><span>Expenses</span></a></li>
            <li class="treeview">
                <a href="#">
                    <i class="bi bi-file-earmark-pdf"></i><span>Reports</span>
                    <span class="pull-right-container"><i class="bi bi-chevron-down pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="monthly_profits.php"><i class="bi bi-coin"></i>Monthly Profits</a></li>
                    <li><a href="income_statement.php"><i class="bi bi-coin"></i>Income Statement</a></li>
                    <li><a href="cashflow_statement.php"><i class="bi bi-coin"></i>Statement of Cash Flows</a></li>
                </ul>
            </li>
<?php elseif ($_SESSION['type'] == 2): // Cashier ?>
            <li><a href="dashboard.php"><i class="bi bi-speedometer2"></i><span>Dashboard</span></a></li>
            <li><a href="collections.php"><i class="bi bi-cash-stack"></i><span>Collections</span></a></li>
            <li><a href="expenses.php"><i class="bi bi-receipt"></i><span>Expenses</span></a></li>
<?php endif; ?>
        </ul>
    </section>
</aside>
