<?php
/*
 * Category Modal
 * Description: Category Modal
 * Author: Charlene B. Dela Cruz
 */
?>


<!-- Edit Category -->
<div class="modal fade" id="edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal" method="POST" action="../controller/categoryController.php">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h3 class="modal-title" style="color: #00693e;">Category</h3>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_category_id" name="category_id">
                    <div class="form-group">
                        <label for="edit_description" class="col-sm-3 control-label">Description</label>
                        <div class="col-sm-8">
                            <input class="form-control" id="edit_description" name="description" required>
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

<!-- Delete Category -->
<div class="modal fade" id="delete">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal" method="POST" action="../controller/categoryController.php">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h3 class="modal-title" style="color: #00693e;">Delete Category</h3>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="delete_category_id" name="category_id">
                    <div class="text-center">
                        <p>Are you sure you want to delete category?</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-flat axis-btn-red" name="delete"><i class="bi bi-trash3"></i> Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>