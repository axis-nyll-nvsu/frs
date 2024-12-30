<?php
/*
 * remunerationModal.php
 * Description: Remuneration Modal
 * Author: 
 * Modified: 12-26-2024
 */
?>

<!-- Compute Remuneration -->
<div class="modal fade" id="compute">
  <div class="modal-dialog">
    <div class="modal-content">
      <form class="form-horizontal" method="POST" action="../controller/remunerationController.php">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h3 class="modal-title" style="color: #00693e;">Compute Salaries</h3>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="start_date" class="col-sm-3 control-label">Coverage</label>
            <div class="col-sm-8">
              <select id="start_date" name="start_date" style="width: 100%;" required>
                <?php
                $givenDate = date('Y-m-d');
                $date = new DateTime($givenDate);
                $dayOfWeek = $date->format('w');
                $daysFromSaturday = ((6 - $dayOfWeek) % 7) - 13;
                $date->modify("{$daysFromSaturday} days");
                $nearestSaturday = $date->format('Y-m-d');

                $count = 1;
                while ($count <= 5) {
                  $dateStart = new DateTime($nearestSaturday);
                  $dateEnd = new DateTime($nearestSaturday);
                  $dateEnd->modify("+6 days");
                  $coverage = $dateStart->format('M d, Y') . " - " . $dateEnd->format('M d, Y');
                  echo "<option value='$nearestSaturday'>$coverage</option>";
                  $dateStart->modify("-7 days");
                  $dateEnd->modify("-7 days");
                  $nearestSaturday = $dateStart->format('Y-m-d');
                  $count++;
                }
                ?>
              </select>
            </div>
          </div>
          <div class="text-center">
            <p>Please ensure all collections have been recorded before computing remunerations.</p>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-flat axis-btn-green" name="compute"><i class="fa fa-check"></i> Compute</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Recompute Remuneration -->
<div class="modal fade" id="recompute">
  <div class="modal-dialog">
    <div class="modal-content">
      <form class="form-horizontal" method="POST" action="../controller/remunerationController.php">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h3 class="modal-title" style="color: #00693e;">Recompute Salary</h3>
        </div>
        <div class="modal-body">
          <input type="hidden" id="compute_salary_id" name="salary_id">
          <div class="text-center">
            <p>Are you sure you want to recompute this driver's salary?</p>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-flat axis-btn-green" name="recomp"><i class="fa fa-check"></i> Recompute</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Pay Remuneration -->
<div class="modal fade" id="pay">
  <div class="modal-dialog">
    <div class="modal-content">
      <form class="form-horizontal" method="POST" action="../controller/remunerationController.php">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h3 class="modal-title" style="color: #00693e;">Pay Salary</h3>
        </div>
        <div class="modal-body">
          <input type="hidden" id="pay_salary_id" name="salary_id">
          <div class="text-center">
            <p style="color: #990f02;">This action will create a record of payment and prevent recomputation!</p>
            <p>Are you sure you want to pay this driver's salary?</p>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-flat axis-btn-green" name="pay"><i class="fa fa-check"></i> Pay</button>
        </div>
      </form>
    </div>
  </div>
</div>