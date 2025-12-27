<?php
/*
 * Backup Modal
 * Description: Select data to backup
 * Author: Charlene B. Dela Cruz
 */
?>

<!-- Backup Modal -->
<div class="modal fade" id="backupModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <form method="POST">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h3 class="modal-title" style="color: #00693e;">
                        Backup Database
                    </h3>
                </div>

                <div class="modal-body">
                    <?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success">
        <?= $_SESSION['success']; ?>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger">
        <?= $_SESSION['error']; ?>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>


                    <p style="font-size:16px; font-weight:600;">
                        Select data to include in backup:
                    </p>

                    <div class="row" style="font-size:15px;">

                        <!-- LEFT COLUMN -->
                        <div class="col-sm-6">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="tables[]" value="frs_users" checked>
                                    Users
                                </label>
                            </div>

                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="tables[]" value="frs_drivers" checked>
                                    Drivers
                                </label>
                            </div>

                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="tables[]" value="frs_ejeeps" checked>
                                    E-Jeeps
                                </label>
                            </div>

                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="tables[]" value="frs_routes" checked>
                                    Routes
                                </label>
                            </div>

                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="tables[]" value="frs_categories" checked>
                                    Categories
                                </label>
                            </div>
                        </div>

                        <!-- RIGHT COLUMN -->
                        <div class="col-sm-6">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="tables[]" value="frs_collections" checked>
                                    Collections
                                </label>
                            </div>

                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="tables[]" value="frs_expenses" checked>
                                    Expenses
                                </label>
                            </div>

                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="tables[]" value="frs_salaries" checked>
                                    Salaries
                                </label>
                            </div>

                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="tables[]" value="frs_rates" checked>
                                    Rates
                                </label>
                            </div>

                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="tables[]" value="frs_trail" checked>
                                    Audit Trail
                                </label>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" name="backup_selected" class="btn btn-flat axis-btn-green">
                        <i class="bi bi-database"></i> Backup
                    </button>

                    
                </div>
            </form>

        </div>
    </div>
</div>
