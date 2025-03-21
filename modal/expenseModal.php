<?php
/*
 * Expense Modal
 * Description: Expense Modal
 * Author: Vernyll Jan P. Asis
 */
?>


<!-- Edit Expense -->
<div class="modal fade" id="editExpense">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal" method="POST" action="../controller/expenseController.php">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h3 class="modal-title" style="color: #00693e;">Edit Expense</h3>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_expense_id" name="expense_id">
                    <div class="form-group">
                        <label for="date" class="col-sm-3 control-label">Date</label>
                        <div class="col-sm-8">
                            <input class="form-control" id="edit_date" name="date" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="category_name" class="col-sm-3 control-label">Category</label>
                        <div class="col-sm-8">
                            <input class="form-control" id="edit_category_name" name="category_name" readonly>
                            <input type="hidden" id="edit_category_id" name="category_id">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description" class="col-sm-3 control-label">Description</label>
                        <div class="col-sm-8">
                            <input class="form-control" id="edit_description" name="description" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="amount" class="col-sm-3 control-label">Amount</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" id="edit_amount" name="amount" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-flat axis-btn-green" name="edit"><i class="bi bi-floppy"></i> Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Expense -->
<div class="modal fade" id="deleteExpense">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal" method="POST" action="../controller/expenseController.php">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h3 class="modal-title" style="color: #00693e;">Delete Expense</h3>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="delete_expense_id" name="expense_id">
                    <div class="text-center">
                        <p>Are you sure you want to delete expense?</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-flat axis-btn-red" name="delete"><i class="bi bi-trash3"></i> Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>