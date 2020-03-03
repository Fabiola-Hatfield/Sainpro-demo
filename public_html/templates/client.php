<div class="modal fade" id="add-client-modal" role="dialog" aria-labelledby="add-clnt-modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="add-clnt-modal">Add Client</h5>
            </div>

            <div class="modal-body">
                <form id="client-form" autocomplete="off">
                    <div class="form-body">

                        <!-- json response will be here -->
                        <div class="alert alert-danger adding-error" role="alert" id="c-error" style="display: none;">
                            ...
                        </div>
                        <div class="alert alert-success adding-success" role="alert" id="c-success"
                             style="display: none;">...
                        </div>
                        <!-- json response will be here -->

                        <div class="form-group">
                            <label for="client-name">Full Name</label>
                            <div class="input-group">
                                <input name="client-name" id="client-name" type="text" class="form-control"
                                       placeholder="Austin Hatfield" maxlength="40" autofocus>
                            </div>
                            <span class="help-block" id="error"></span>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-lg-6">
                                <label for="phone">Phone Number</label>
                                <div class="input-group">
                                    <input name="phone" id="phone" type="text" class="form-control"
                                           placeholder="(+1)1234567890ext123" maxlength="14" autofocus>
                                </div>
                                <span class="help-block" id="error"></span>
                            </div>

                            <div class="form-group col-lg-6">
                                <label for="client-email">E-mail Address</label>
                                <div class="input-group">
                                    <input name="client-email" id="client-email" type="text" class="form-control"
                                           placeholder="example@domain.com" maxlength="50">
                                </div>
                                <span class="help-block" id="error"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="address">Address</label>
                            <div class="input-group">
                                <input name="address" id="address" type="text" class="form-control"
                                       placeholder="Address" autofocus>
                            </div>
                            <span class="help-block" id="error"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="add-client-btn" name="add-client-btn" class="btn btn-primary adding-submit">
                            Add
                        </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>