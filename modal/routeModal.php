<?php
/*
 * Route Modal
 * Description: Route Modal
 * Author: Charlene B. Dela Cruz
 */
?>


<!-- Edit Route -->
<div class="modal fade" id="edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal" method="POST" action="../controller/routeController.php">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h3 class="modal-title" style="color: #00693e;">Edit Route</h3>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_route_id" name="route_id">
                    <div class="form-group">
                        <label for="edit_description" class="col-sm-3 control-label">Route</label>
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

<!-- Delete Route -->
<div class="modal fade" id="delete">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal" method="POST" action="../controller/routeController.php">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h3 class="modal-title" style="color: #00693e;">Delete Route</h3>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="delete_route_id" name="route_id">
                    <div class="text-center">
                        <p>Are you sure you want to delete route?</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-flat axis-btn-red" name="delete"><i class="bi bi-trash3"></i> Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>