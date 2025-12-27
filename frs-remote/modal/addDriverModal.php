<?php
/*
 * Add Driver Modal
 * Description: Add Driver Modal
 * Author: Vernyll Jan P. Asis
 */
?>


<!-- Add Driver -->
<div class="modal fade" id="addDriver">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal" method="POST" action="../controller/driverController.php">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h3 class="modal-title" style="color: #00693e;">Add Driver</h3>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="firstname" class="col-sm-3 control-label">First Name</label>
                        <div class="col-sm-8">
                            <input class="form-control" id="firstname" name="firstname" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lastname" class="col-sm-3 control-label">Last Name</label>
                        <div class="col-sm-8">
                            <input class="form-control" id="lastname" name="lastname" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address" class="col-sm-3 control-label">Address</label>
                        <div class="col-sm-8">
                            <input class="form-control" id="address" name="address" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="contact" class="col-sm-3 control-label">Contact</label>
                        <div class="col-sm-8">
                            <input class="form-control" id="contact" name="contact" required>
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