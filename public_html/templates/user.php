<div class="modal fade" id="add-user-modal" role="dialog" aria-labelledby="add-usr-modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="add-usr-modal">Add User</h5>
            </div>

            <div class="modal-body">
                <!-- form starts here-->
                <form id="user-form" autocomplete="off">
                    <div class="form-body">
                        <!-- json response will be here -->
                        <div class="alert alert-danger adding-error" role="alert" id="u-error"
                             style="display: none;">
                            ...
                        </div>
                        <div class="alert alert-success adding-success" role="alert" id="u-success"
                             style="display: none;">
                            ...
                        </div>
                        <!-- json response will be here -->

                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <div class="input-group">
                                <input name="name" id="name" type="text" class="form-control"
                                       placeholder="Austin Hatfield" maxlength="40" autofocus>
                            </div>
                            <span class="help-block" id="error"></span>
                        </div>

                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <div class="input-group">
                                <input name="email" id="email" type="text" class="form-control"
                                       placeholder="example@domain.com" maxlength="50">
                            </div>
                            <span class="help-block" id="error"></span>
                        </div>

                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label for="password">Password</label>
                                <div class="input-group">
                                    <input name="password" id="password" type="password" class="form-control"
                                           placeholder="Password">
                                </div>
                                <span class="help-block" id="error"></span>
                            </div>

                            <div class="form-group col-lg-6">
                                <label for="cpassword">Confirm password</label>
                                <div class="input-group">
                                    <input name="cpassword" id="cpassword" type="password" class="form-control"
                                           placeholder="Confirm Password">
                                </div>
                                <span class="help-block" id="error"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="user-type">User type</label>
                            <select name="user-type" class="form-control" id="user-type">
                                <option value="">Choose an user type</option>
                                <option value="Admin">Administrator</option>
                                <option value="User">User</option>
                            </select>
                            <span class="help-block" id="error"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="add-user-btn" name="add-user-btn"
                                class="btn btn-primary adding-submit">Add
                        </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>