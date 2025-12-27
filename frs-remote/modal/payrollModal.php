<!-- Payout -->
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
                    <input type="hidden" id="delete_expense_id" name="expense_id">
                    <div class="text-center">
                        <p>Magpapasahod na you?</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-flat axis-btn-red" name="delete"><i class="bi bi-trash3"></i> Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>