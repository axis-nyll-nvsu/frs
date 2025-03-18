<?php
/*
 * Add E-Jeep Modal
 * Description: Add E-Jeep Modal
 * Author: Vernyll Jan P. Asis
 */
?>


<!-- Add E-Jeep -->
<div class="modal fade" id="addEjeep">
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
                    <button type="submit" class="btn btn-flat axis-btn-green" name="add">
                        <i class="bi bi-floppy"></i> Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>