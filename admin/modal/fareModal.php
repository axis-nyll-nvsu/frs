<?php
/*
 * fareModal.php
 * Description: Fare Collections Modal
 * Author: 
 * Modified: 12-26-2024
 */
?>

<!-- Add Fare Collection -->
<div class="modal fade" id="addnew">
  <div class="modal-dialog">
    <div class="modal-content">
      <form class="form-horizontal" method="POST" action="../controller/fareController.php">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h3 class="modal-title" style="color: #00693e;">Add Fare Collection</h3>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="date" class="col-sm-3 control-label">Date</label>
            <div class="col-sm-8">
              <input class="form-control" id="date" name="date" value="<?php echo date("m/d/Y"); ?>" required>
            </div>
          </div>
          <div class="form-group">
            <label for="driver_id" class="col-sm-3 control-label">Driver</label>
            <div class="col-sm-8">
              <select id="driver_id" name="driver_id" style="width: 100%;" required>
                <option value="0">Select Driver</option>
                <?php
                $sql = "SELECT * FROM `frs_drivers` WHERE `deleted` != b'1'";
                $stmt = $this->conn()->query($sql);
                while ($row = $stmt->fetch()) {
                ?>
                <option value="<?php echo $row['id'] ?>">
                  <?php
                    echo $row['first_name'] . " ";
                    echo ($row['middle_name'] != "") ? $row['middle_name'] . " " : "";
                    echo $row['last_name'];
                  ?>
                </option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="terminal_id" class="col-sm-3 control-label">Terminal</label>
            <div class="col-sm-8">
              <select id="terminal_id" name="terminal_id" style="width: 100%;" required>
                <option value="0">Select Terminal</option>
                <?php
                $sql = "SELECT * FROM `frs_terminals` WHERE `deleted` != b'1'";
                $stmt = $this->conn()->query($sql);
                while ($row = $stmt->fetch()) {
                ?>
                <option value="<?php echo $row['id'] ?>">
                  <?php
                    echo $row['name'];
                  ?>
                </option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="amount" class="col-sm-3 control-label">Amount</label>
            <div class="col-sm-8">
              <input class="form-control" id="amount" name="amount" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-flat axis-btn-green" name="add"><i class="fa fa-save"></i> Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit Fare Collection -->
<div class="modal fade" id="edit">
  <div class="modal-dialog">
    <div class="modal-content">
      <form class="form-horizontal" method="POST" action="../controller/fareController.php">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h3 class="modal-title" style="color: #00693e;">Edit Fare Collection</h3>
        </div>
        <div class="modal-body">
          <input type="hidden" id="edit_fare_id" name="fare_id">
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
            <label for="terminal_name" class="col-sm-3 control-label">Terminal</label>
            <div class="col-sm-8">
              <input class="form-control" id="edit_terminal_name" name="terminal_name" readonly>
              <input type="hidden" id="edit_terminal_id" name="terminal_id">
            </div>
          </div>
          <div class="form-group">
            <label for="amount" class="col-sm-3 control-label">Amount</label>
            <div class="col-sm-8">
              <input class="form-control" id="edit_amount" name="amount" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-flat axis-btn-green" name="edit"><i class="fa fa-save"></i> Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Delete Fare Collection -->
<div class="modal fade" id="delete">
  <div class="modal-dialog">
    <div class="modal-content">
      <form class="form-horizontal" method="POST" action="../controller/fareController.php">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h3 class="modal-title" style="color: #00693e;">Delete Fare Collection</h3>
        </div>
        <div class="modal-body">
          <input type="hidden" id="delete_fare_id" name="fare_id">
          <div class="text-center">
            <p>Are you sure you want to delete fare collection?</p>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-flat axis-btn-red" name="delete"><i class="fa fa-trash"></i> Delete</button>
        </div>
      </form>
    </div>
  </div>
</div>