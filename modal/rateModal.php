<?php
/*
 * Rate Modal
 * Description: Rate Modal
 * Author: Vernyll Jan P. Asis
 */
?>


<!-- Add Rate -->
<div class="modal fade" id="addRate">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal" method="POST" action="../controller/rateController.php">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h3 class="modal-title" style="color: #00693e;">Add Rate</h3>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="quota" class="col-sm-3 control-label">Quota</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" id="quota" name="quota" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="base_salary" class="col-sm-3 control-label">Base Salary</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" id="base_salary" name="base_salary" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="base_rate" class="col-sm-3 control-label">Base Rate</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" id="base_rate" name="base_rate" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="addon_rate" class="col-sm-3 control-label">Add-On Rate</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" id="addon_rate" name="addon_rate" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-flat axis-btn-green" name="add">
                        <i class="bi bi-floppy"></i> Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Set Default Rate -->
<div class="modal fade" id="edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal" method="POST" action="../controller/rateController.php">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h3 class="modal-title" style="color: #00693e;">Set Default Rate</h3>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_rate_id" name="rate_id">
                    <div class="text-center">
                        <p>Are you sure you want to set this as the default salary rate?</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-flat axis-btn-green" name="edit"><i class="bi bi-check"></i> Set</button>
                </div>
            </form>
        </div>
    </div>
</div>