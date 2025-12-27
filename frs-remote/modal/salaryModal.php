<?php
/*
 * Salary Modal
 * Description: Salary Modal
 * Author: Vernyll Jan P. Asis
 */
?>


<!-- Change Computation -->
<div class="modal fade" id="changeComputation">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal" method="POST" action="../controller/salaryController.php">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h3 class="modal-title" style="color: #00693e;">Change Computation</h3>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_salary_id" name="salary_id">
                    <div class="form-group">
                        <label for="edit_rate_value" class="col-sm-3 control-label">Old Rates</label>
                        <div class="col-sm-8">
                            <input class="form-control" id="edit_rate_value" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="rate_id" class="col-sm-3 control-label">New Rates</label>
                        <div class="col-sm-8" style="display: flex;">
                            <select id="rate_id" name="rate_id" style="width: 90%;" required>
                                <?php
                                $sql = "SELECT * FROM `frs_rates` WHERE `deleted` != b'1'";
                                $stmt = $this->db->query($sql);
                                while ($row = $stmt->fetch()) {
                                ?>
                                <option value="<?php echo $row['id'] ?>" <?php if($row['is_default'] == 1) echo 'selected';?>>
                                    <?php
                                        echo "Q: " . number_format($row['quota'], 2) . " | ";
                                        echo "BS: " . number_format($row['base_salary'], 2) . " | ";
                                        echo "BR: " . $row['base_rate'] . "% | ";
                                        echo "AR: " . $row['addon_rate'] . "%";
                                    ?>
                                </option>
                                <?php } ?>
                            </select>
                            <a href="#addRate" data-dismiss="modal" data-toggle="modal" class="btn btn-sm axis-btn-green" style="width: 10%; padding: 5px 0 0 0; border-radius: 0 !important;"><i class="bi bi-plus-circle"></i></a>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-flat axis-btn-green" name="change"><i class="bi bi-floppy"></i> Update</button>
                </div>
            </form>
        </div>
    </div>
</div>