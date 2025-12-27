<?php
/*
 * Add Category Modal
 * Description: Add Category Modal
 * Author: Charlene B. Dela Cruz
 */
?>


<!-- Add Category -->
<div class="modal fade" id="addCategory">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal" method="POST" action="../controller/categoryController.php">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h3 class="modal-title" style="color: #00693e;">Add Category</h3>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="description" class="col-sm-3 control-label">Description</label>
                        <div class="col-sm-8">
                            <input class="form-control" id="description" name="description" required>
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