<?php
/*
 * Profile Modal
 * Description: Profile Modal
 * Author: Vernyll Jan P. Asis
 */
?>


<!-- Update Profile -->
<div class="modal fade" id="profile">
  <div class="modal-dialog">
    <div class="modal-content">
      <form class="form-horizontal" method="POST" action="../controller/profileController.php" enctype="multipart/form-data">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h3 class="modal-title" style="color: #00693e;">
            <?php echo ($_SESSION['type'] == 0) ? "Admin Profile" : "Staff Profile"; ?>
          </h3>
        </div>
        <div class="modal-body">
          <input type="hidden" id="user_id" name="user_id">
          <div class="form-group">
            <label for="email" class="col-sm-3 control-label">Email</label>
            <div class="col-sm-8">
              <input type="email" class="form-control" id="email" name="email" required>
            </div>
          </div>
          <div class="form-group">
            <label for="password" class="col-sm-3 control-label">Password</label>
            <div class="col-sm-8">
              <input type="password" class="form-control" id="password" name="password" required>
            </div>
          </div>
          <div class="form-group">
            <label for="firstname" class="col-sm-3 control-label">First Name</label>
            <div class="col-sm-8">
              <input class="form-control" id="firstname" name="firstname" required>
            </div>
          </div>
          <div class="form-group">
            <label for="middlename" class="col-sm-3 control-label">Middle Name</label>
            <div class="col-sm-8">
              <input class="form-control" id="middlename" name="middlename" required>
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
          <div class="form-group">
            <label for="photo" class="col-sm-3 control-label">Photo</label>
            <div class="col-sm-8">
              <input type="file" class="form-control" id="img" name="img" accept="image/*">
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