<?php
/*
 * Add Expense Modal
 * Description: Add Expense Modal
 * Author: Vernyll Jan P. Asis
 */
 include '../modal/addCategoryModal.php';
?>


<!-- Add Expense -->
<div class="modal fade" id="addExpense">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal" method="POST" action="../controller/expenseController.php">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h3 class="modal-title" style="color: #00693e;">Add Expense</h3>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="date" class="col-sm-3 control-label">Date</label>
                        <div class="col-sm-8">
                            <input class="form-control" id="date" name="date" value="<?php echo date('m/d/Y'); ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="category_id" class="col-sm-3 control-label">Category</label>
                        <div class="col-sm-8" style="display: flex;">
                            <select class="form-control" id="category_id" name="category_id" style="width: 90%;" required>
                            <?php
                            $sql = "SELECT * FROM `frs_categories` WHERE `deleted` != b'1'";
                            $stmt = $this->db->query($sql);
                            while ($row = $stmt->fetch()) {
                            ?>
                                <option value="<?php echo $row['id'] ?>"><?php echo $row['description'] ?></option>
                            <?php } ?>
                            </select>
                            <a href="#addCategory" data-dismiss="modal" data-toggle="modal" class="btn btn-sm axis-btn-green" style="width: 10%; padding: 5px 0 0 0; border-radius: 0 !important;"><i class="bi bi-plus-circle"></i></a>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description" class="col-sm-3 control-label">Description</label>
                        <div class="col-sm-8">
                            <input class="form-control" id="description" name="description" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="amount" class="col-sm-3 control-label">Amount</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" id="amount" name="amount" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-flat axis-btn-green" name="add"><i class="bi bi-floppy"></i> Save</button>
                </div>
            </form>
        </div>
    </div>
</div>