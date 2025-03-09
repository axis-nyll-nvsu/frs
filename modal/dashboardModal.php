<?php
/*
 * Dashboard Modal
 * Description: Dashboard Modal
 * Author: Vernyll Jan P. Asis
 */
?>


<!-- Add Collection -->
<div class="modal fade" id="addCollection">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            <h3 class="modal-title" style="color: #00693e;">Add Collection</h3>
        </div>
        <div class="modal-body">
            <p>Please choose type of collection:</p>
        </div>
        <div class="modal-footer">
            <a href="fares.php" class="btn btn-sm btn-flat axis-btn-green">Fare Collection</a> 
            <a href="collections.php" class="btn btn-sm btn-flat axis-btn-green">Other Collection</a> 
        </div>
    </div>
  </div>
</div>

<!-- Edit Other Collection -->
<div class="modal fade" id="edit">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            <h3 class="modal-title" style="color: #00693e;">Add Collection</h3>
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
            <label for="receipt" class="col-sm-3 control-label">OR Number</label>
            <div class="col-sm-8">
                <input class="form-control" id="edit_receipt" name="receipt" required>
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
                <input type="number" class="form-control" id="edit_amount" name="amount" required>
            </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-flat axis-btn-green" name="edit"><i class="bi bi-floppy"></i> Update</button>
        </div>
    </div>
  </div>
</div>