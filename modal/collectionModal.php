<?php
/*
 * Collection Modal
 * Description: Collection Modal
 * Author: Vernyll Jan P. Asis
 */
include '../modal/driverModal.php';
include '../modal/routeModal.php';
include '../modal/ejeepModal.php';

?>


<!-- Add Collection -->
<div class="modal fade" id="addCollection">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal" method="POST" action="../controller/collectionController.php">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h3 class="modal-title" style="color: #00693e;">Add Collection</h3>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="date" class="col-sm-3 control-label">Date</label>
                        <div class="col-sm-8">
                            <input class="form-control" id="date" name="date" value="<?php echo date('m/d/Y'); ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="driver_id" class="col-sm-3 control-label">Driver</label>
                        <div class="col-sm-8" style="display: flex;">
                            <select id="driver_id" name="driver_id" style="width: 90%;" required>
                                <?php
                                $sql = "SELECT * FROM `frs_drivers` WHERE `deleted` != b'1'";
                                $stmt = $this->db->query($sql);
                                while ($row = $stmt->fetch()) {
                                ?>
                                <option value="<?php echo $row['id'] ?>">
                                    <?php echo $row['first_name'] . " " . $row['last_name']; ?>
                                </option>
                                <?php } ?>
                            </select>
                            <a href="#addDriver" data-dismiss="modal" data-toggle="modal" class="btn btn-sm axis-btn-green" style="width: 10%; padding: 5px 0 0 0; border-radius: 0 !important;"><i class="bi bi-plus-circle"></i></a>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="ejeep_id" class="col-sm-3 control-label">E-Jeep</label>
                        <div class="col-sm-8" style="display: flex;">
                            <select id="ejeep_id" name="ejeep_id" style="width: 90%;" required>
                                <?php
                                $sql = "SELECT * FROM `frs_ejeeps` WHERE `deleted` != b'1'";
                                $stmt = $this->db->query($sql);
                                while ($row = $stmt->fetch()) {
                                ?>
                                <option value="<?php echo $row['id'] ?>">
                                    <?php echo $row['plate']; ?>
                                </option>
                                <?php } ?>
                            </select>
                            <a href="#addEjeep" data-dismiss="modal" data-toggle="modal" class="btn btn-sm axis-btn-green" style="width: 10%; padding: 5px 0 0 0; border-radius: 0 !important;"><i class="bi bi-plus-circle"></i></a>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="route_id" class="col-sm-3 control-label">Route</label>
                        <div class="col-sm-8" style="display: flex;">
                            <select id="route_id" name="route_id" style="width: 90%;" required>
                                <?php
                                $sql = "SELECT * FROM `frs_routes` WHERE `deleted` != b'1'";
                                $stmt = $this->db->query($sql);
                                while ($row = $stmt->fetch()) {
                                ?>
                                <option value="<?php echo $row['id'] ?>">
                                    <?php echo $row['description']; ?>
                                </option>
                                <?php } ?>
                            </select>
                            <a href="#addRoute" data-dismiss="modal" data-toggle="modal" class="btn btn-sm axis-btn-green" style="width: 10%; padding: 5px 0 0 0; border-radius: 0 !important;"><i class="bi bi-plus-circle"></i></a>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="amount" class="col-sm-3 control-label">Amount</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" id="amount" name="amount" required>
                        </div>
                    </div>
                     <!-- For computation ng salary-->
                    <div class="form-group">
                        <label for="rate" class="col-sm-3 control-label">Commission Rate</label>
                        <div class="col-sm-8" style="display: flex;">
                            <input type="number" class="form-control" id="rate" name="rate" required>
                        </div>
                        <label for="basicSalary" class="col-sm-3 control-label">Basic Salary per Day</label>
                        <div class="col-sm-8" style="display: flex;">
                            <input type="number" class="form-control" id="basicSalary" name="basicSalary" required>
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

<!-- Edit Collection -->
<div class="modal fade" id="editCollection">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal" method="POST" action="../controller/collectionController.php">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h3 class="modal-title" style="color: #00693e;">Edit Collection</h3>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_collection_id" name="collection_id">
                    <div class="form-group">
                        <label for="date" class="col-sm-3 control-label">Date</label>
                        <div class="col-sm-8">
                            <input class="form-control" id="edit_date" name="date" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="driver_name" class="col-sm-3 control-label">Driver</label>
                        <div class="col-sm-8">
                            <input class="form-control" id="edit_driver_name" name="driver_name" readonly>
                            <input type="hidden" id="edit_driver_id" name="driver_id">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="ejeep_plate" class="col-sm-3 control-label">E-Jeep</label>
                        <div class="col-sm-8">
                            <input class="form-control" id="edit_ejeep_plate" name="ejeep_plate" readonly>
                            <input type="hidden" id="edit_ejeep_id" name="ejeep_id">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="route_description" class="col-sm-3 control-label">Route</label>
                        <div class="col-sm-8">
                            <input class="form-control" id="edit_route_description" name="route_description" readonly>
                            <input type="hidden" id="edit_route_id" name="route_id">
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

<!-- Delete Collection -->
<div class="modal fade" id="deleteCollection">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal" method="POST" action="../controller/collectionController.php">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h3 class="modal-title" style="color: #00693e;">Delete Collection</h3>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="delete_collection_id" name="collection_id">
                    <div class="text-center">
                        <p>Are you sure you want to delete collection?</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-flat axis-btn-red" name="delete"><i class="bi bi-trash3"></i> Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>