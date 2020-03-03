<div class="modal fade" id="updusr-form" role="dialog" aria-labelledby="upd-user-modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="upd-user-modal">Manage User</h5>
            </div>
            <div class="modal-body">
                <form id="update-user-form" autocomplete="off">
                    <div class="form-body">
                        <!-- json response will be here -->
                        <div class="alert alert-danger edit-error" role="alert" id="eu-error" style="display: none;">
                            ...
                        </div>
                        <div class="alert alert-success edit-success" role="alert" id="eu-success"
                             style="display: none;">...
                        </div>
                        <!-- json response will be here -->
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <input type="hidden" name="eu-id" id="eu-id"/>
                                <input type="hidden" name="eu-last" id="eu-last"/>
                                <label for="eureg-date">Register Date</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="eureg-date" id="eureg-date" readonly/>
                                </div>
                                <span class="help-block" id="error"></span>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="eu-name">Full Name</label>
                                <div class="input-group">
                                    <input name="eu-name" id="eu-name" type="text" class="form-control"
                                           placeholder="Austin Hatfield" maxlength="40" autofocus>
                                </div>
                                <span class="help-block" id="error"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="eu-email">E-mail Address</label>
                            <div class="input-group">
                                <input name="eu-email" id="eu-email" type="text" class="form-control"
                                       placeholder="example@domain.com" maxlength="50">
                            </div>
                            <span class="help-block" id="error"></span>
                        </div>
                        <div class="form-group">
                            <label for="euuser-type">User Type</label>
                            <select name="euuser-type" class="form-control" id="euuser-type">
                                <option value="">Choose a user type</option>
                                <option value="Admin">Administrator</option>
                                <option value="User">User</option>
                            </select>
                            <span class="help-block" id="error"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="upd-user-btn" name="upd-user-btn" class="btn btn-primary upd-btn">Save
                            Changes
                        </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>