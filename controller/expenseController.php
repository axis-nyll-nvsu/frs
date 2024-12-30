<?php
/*
 * expenseController.php
 * Description: Expense Controller
 * Author: 
 * Modified: 12-27-2024
 */

session_start();
include '../config/config.php';

class ExpenseController extends Connection {
  public function addExpense() {
    $user = $_SESSION['user_id'];
    $date = date('Y-m-d',strtotime($_POST['date']));
    $category = $_POST['category_id'];
    $description = $_POST['description'];
    $amount = $_POST['amount'];

    $sqlinsert = "INSERT INTO `frs_expenses`(`date`, `category_id`, `description`, `amount`, `created_by`) VALUES (?,?,?,?,?)";
    $statementinsert = $this->conn()->prepare($sqlinsert);
    $statementinsert->execute([$date, $category, $description, $amount, $user]);

    $description = "Added a new expense.";
    $sqlinsert = "INSERT INTO `frs_audittrail` (`user_id`, `description`) VALUES (?,?)";
    $statementinsert = $this->conn()->prepare($sqlinsert);
    $statementinsert->execute([$user, $description]);

    $_SESSION['success'] = 'success';
    echo "<script>window.location.href='../admin/expenses.php';</script>";
  }
  
  public function editExpense() {
    $user = $_SESSION['user_id'];
    $expense = $_POST['expense_id'];
    $date = date('Y-m-d',strtotime($_POST['date']));
    $category = $_POST['category_id'];
    $description = $_POST['description'];
    $amount = $_POST['amount'];

    echo $description;
    
    $sqlupdate = "UPDATE `frs_expenses` SET `date` = ?, `category_id` = ?, `description` = ?, `amount` = ?, `updated_by` = ? WHERE `id` = ?";
    $statementupdate = $this->conn()->prepare($sqlupdate);
    $statementupdate->execute([$date, $category, $description, $amount, $user, $expense]);

    $description = "Updated expense.";
    $sqlinsert = "INSERT INTO `frs_audittrail` (`user_id`, `description`) VALUES (?,?)";
    $statementinsert = $this->conn()->prepare($sqlinsert);
    $statementinsert->execute([$user, $description]);

    $_SESSION['updated'] = 'updated';
    echo "<script>window.location.href='../admin/expenses.php';</script>";
  }
  
  public function deleteExpense() {
    $user = $_SESSION['user_id'];
    $expense = $_POST['expense_id'];

    $sqlupdate = "UPDATE `frs_expenses` SET `deleted` = b'1', `updated_by` = ? WHERE `id` = ?";
    $statementupdate = $this->conn()->prepare($sqlupdate);
    $statementupdate->execute([$user, $expense]);

    $description = "Deleted expense.";
    $sqlinsert = "INSERT INTO `frs_audittrail` (`user_id`, `description`) VALUES (?,?)";
    $statementinsert = $this->conn()->prepare($sqlinsert);
    $statementinsert->execute([$user, $description]);

    $_SESSION['deleted'] = 'deleted';
    echo "<script>window.location.href='../admin/expenses.php';</script>";
  }
}

$controller = new ExpenseController();

if (isset($_POST['add'])) $controller->addExpense();
if (isset($_POST['edit'])) $controller->editExpense();
if (isset($_POST['delete'])) $controller->deleteExpense();