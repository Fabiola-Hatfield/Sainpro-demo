<div class="modal fade" id="upd-prof-modal" role="dialog" aria-labelledby="update-profile" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="update-profile">Update Profile</h5>
            </div>
            <div class="modal-body">
                <!-- form start -->
                <form id="profile-form" autocomplete="off">
                    <div class="form-body">
                        <!-- json response will be here -->
                        <div class="alert alert-danger edit-error" role="alert" id="prof-error" style="display: none;">
                            ...
                        </div>
                        <div class="alert alert-success edit-success" role="alert" id="prof-success"
                             style="display: none;">...
                        </div>
                        <!-- json response will be here -->
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <input type="hidden" name="myid" id="myid" readonly/>
                                <label for="prof-reg-date">Register Date</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="prof-reg-date" id="prof-reg-date"
                                           readonly/>
                                </div>
                                <span class="help-block" id="error"></span>
                            </div>

                            <div class="form-group col-md-6">
                                <input type="hidden" name="eproid" id="eproid" value=""/>
                                <label for="prof-name">Full Name</label>
                                <div class="input-group">
                                    <input name="prof-name" id="prof-name" type="text" class="form-control"
                                           placeholder="Austin Hatfield" maxlength="40" autofocus>
                                </div>
                                <span class="help-block" id="error"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="prof-email">E-mail Address</label>
                            <div class="input-group">
                                <input name="prof-email" id="prof-email" type="text" class="form-control"
                                       placeholder="example@domain.com" maxlength="50">
                            </div>
                            <span class="help-block" id="error"></span>
                        </div>

                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label for="prof-password">Password</label>
                                <div class="input-group">
                                    <input name="prof-password" id="prof-password" type="password" class="form-control"
                                           placeholder="Password">
                                </div>
                                <span class="help-block" id="error"></span>
                            </div>

                            <div class="form-group col-lg-6">
                                <label for="prof-cpassword">Confirm Password</label>
                                <div class="input-group">
                                    <input name="prof-cpassword" id="prof-cpassword" type="password"
                                           class="form-control" placeholder="Confirm Password">
                                </div>
                                <span class="help-block" id="error"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="prof-user-type">User type</label>
                            <div class="input-group">
                                <input name="prof-user-type" id="prof-user-type" type="text" class="form-control"
                                       readonly>
                            </div>
                            <span class="help-block" id="error"></span>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" id="upd-prof-btn" name="upd-prof-btn" class="btn btn-primary upd-btn">Save
                            Changes
                        </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>