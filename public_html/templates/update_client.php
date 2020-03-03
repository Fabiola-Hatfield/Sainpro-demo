<div class="modal fade" id="updclient-form" role="dialog" aria-labelledby="upd-client-modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="upd-client-modal">Update Client's Info</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form id="update-client-form" autocomplete="off">
                    <div class="form-body">
                        <!-- json response will be here -->
                        <div class="alert alert-danger edit-error" role="alert" id="ec-error" style="display: none;">
                            ...
                        </div>
                        <div class="alert alert-success edit-success" role="alert" id="ec-success"
                             style="display: none;">
                            ...
                        </div>
                        <!-- json response will be here -->

                        <div class="form-group">
                            <input type="hidden" name="ec-id" id="ec-id"/>
                            <label for="ec-name">Full Name</label>
                            <div class="input-group">
                                <input name="ec-name" id="ec-name" type="text" class="form-control"
                                       placeholder="Austin Hatfield" maxlength="40" autofocus>
                            </div>
                            <span class="help-block" id="error"></span>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-lg-6">
                                <label for="ec-phone">Phone Number</label>
                                <div class="input-group">
                                    <input name="ec-phone" id="ec-phone" type="text" class="form-control"
                                           placeholder="(+1)1234567890ext123" maxlength="14" autofocus>
                                </div>
                                <span class="help-block" id="error"></span>
                            </div>

                            <div class="form-group col-lg-6">
                                <label for="ec-email">E-mail Address</label>
                                <div class="input-group">
                                    <input name="ec-email" id="ec-email" type="text" class="form-control"
                                           placeholder="example@domain.com" maxlength="50">
                                </div>
                                <span class="help-block" id="error"></span>
                            </div>

                            <div class="form-group col-lg-12">
                                <label for="ec-address">Address</label>
                                <div class="input-group">
                                    <input name="ec-address" id="ec-address" type="text" class="form-control"
                                           placeholder="Address" autofocus>
                                </div>
                                <span class="help-block" id="error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="upd-client-btn" name="upd-client-btn" class="btn btn-primary upd-btn">Save
                            Changes
                        </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>