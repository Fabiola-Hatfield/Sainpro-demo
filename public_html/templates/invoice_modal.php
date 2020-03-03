<div class="modal fade" id="show-more" role="dialog" aria-labelledby="show-inv-modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="show-inv-modal">Invoice Info</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body" id="invoice-details">
                <div class="table-responsive table-wrapper-scroll-y scrollbar-y">
                    <table class="table table-hover table-bordered" id="invoice-det">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Invoice no.</th>
                            <th>Price</th>
                            <th>Quantity</th>
                        </tr>
                        </thead>
                        <tbody id="get-invoice-det">
                        <!--BODY IS RECEIVED FROM DATABASE-->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>