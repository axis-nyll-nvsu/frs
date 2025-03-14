<?php
/*
 * E-Jeep Modal
 * Description: E-Jeep Modal
 * Author: Vernyll Jan P. Asis
 */
?>


<!-- Add E-Jeep -->
<div class="modal fade" id="addnew">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal" method="POST" action="../controller/ejeepController.php">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h3 class="modal-title" style="color: #00693e;">Add E-Jeep</h3>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="plate" class="col-sm-3 control-label">Plate No.</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="plate" name="plate" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-flat axis-btn-green" name="add_ejeep">
                        <i class="bi bi-floppy"></i> Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit E-Jeep -->
<div class="modal fade" id="edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal" method="POST" action="../controller/ejeepController.php">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h3 class="modal-title" style="color: #00693e;">Edit E-Jeep</h3>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_ejeep_id" name="ejeep_id">
                    <div class="form-group">
                        <label for="edit_plate" class="col-sm-3 control-label">Plate No.</label>
                        <div class="col-sm-8">
                            <input class="form-control" id="edit_plate" name="plate" required>
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

<!-- Delete E-Jeep -->
<div class="modal fade id="delete">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal" method="POST" action="../controller/ejeepController.php">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h3 class="modal-title" style="color: #00693e;">Delete E-Jeep</h3>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="delete_ejeep_id" name="ejeep_id">
                    <div class="text-center">
                        <p>Are you sure you want to delete e-jeep?</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-flat axis-btn-red" name="delete"><i class="bi bi-trash3"></i> Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>