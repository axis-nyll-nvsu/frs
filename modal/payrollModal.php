<!-- Payout Modal -->
<div class="modal fade" id="payout">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal" method="POST" action="../controller/payrollController.php">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h3 class="modal-title" style="color: #00693e;">Payout</h3>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="driver_name" name="driver_name">
                    <input type="hidden" id="pay_week" name="pay_week">
                    <input type="hidden" id="total_salary" name="total_salary">
                    
                    <div class="text-center">
                        <p>You are about to payout the salary of <b id="modal_driver_name"></b> for <b id="modal_week"></b></p>
                        <p>Total Salary: <b>₱<span id="modal_salary"></span></b></p>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-flat axis-btn-green" name="add" ><i class="bi bi-floppy"></i> Payout</button>
                </div>
            </form>
        </div>
    </div>
</div>

