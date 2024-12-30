<?php
/*
 * collectionModal.php
 * Description: Other Collections Modal
 * Author: 
 * Modified: 12-26-2024
 */
?>

<!-- Add Other Collection -->
<div class="modal fade" id="addnew">
  <div class="modal-dialog">
    <div class="modal-content">
      <form class="form-horizontal" method="POST" action="../controller/collectionController.php">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h3 class="modal-title" style="color: #00693e;">Add Other Collection</h3>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="date" class="col-sm-3 control-label">Date</label>
            <div class="col-sm-8">
              <input class="form-control" id="date" name="date" required>
            </div>
          </div>
          <div class="form-group">
            <label for="category_id" class="col-sm-3 control-label">Collection</label>
            <div class="col-sm-8">
              <select id="category_id" name="category_id" style="width: 100%;" required>
                <option value="0">Select Collection</option>
                <?php
                $sql = "SELECT * FROM `frs_categories` WHERE `deleted` != b'1'";
                $stmt = $this->conn()->query($sql);
                while ($row = $stmt->fetch()) {
                ?>
                <option value="<?php echo $row['id'] ?>"><?php echo $row['description']; ?></option>
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

<!-- Edit Other Collection -->
<div class="modal fade" id="edit">
  <div class="modal-dialog">
    <div class="modal-content">
      <form class="form-horizontal" method="POST" action="../controller/collectionController.php">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h3 class="modal-title" style="color: #00693e;">Edit Other Collection</h3>
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
            <label for="category_name" class="col-sm-3 control-label">Collection</label>
            <div class="col-sm-8">
              <input class="form-control" id="edit_category_name" name="category_name" readonly>
              <input type="hidden" id="edit_category_id" name="category_id">
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

<!-- Delete Other Collection -->
<div class="modal fade" id="delete">
  <div class="modal-dialog">
    <div class="modal-content">
      <form class="form-horizontal" method="POST" action="../controller/collectionController.php">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h3 class="modal-title" style="color: #00693e;">Delete Other Collection</h3>
        </div>
        <div class="modal-body">
          <input type="hidden" id="delete_collection_id" name="collection_id">
          <div class="text-center">
            <p>Are you sure you want to delete other collection?</p>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-flat axis-btn-red" name="delete"><i class="fa fa-trash"></i> Delete</button>
        </div>
      </form>
    </div>
  </div>
</div>