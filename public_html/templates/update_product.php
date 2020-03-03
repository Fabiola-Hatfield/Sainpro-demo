<div class="modal fade" id="eform-product" role="dialog" aria-labelledby="upd-product-modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="upd-product-modal">Manage Product</h5>
            </div>

            <div class="modal-body">
                <form id="update-product-form" autocomplete="off">
                    <div class="form-body">
                        <!-- json response will be here -->
                        <div class="alert alert-danger edit-error" role="alert" id="ep-error" style="display: none;">
                            ...
                        </div>
                        <div class="alert alert-success edit-success" role="alert" id="ep-success"
                             style="display: none;">...
                        </div>
                        <!-- json response will be here -->

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <input type="hidden" name="epid" id="epid" value=""/>
                                <label for="eentry-date">Date</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="eentry-date" id="eentry-date"
                                           value="<?php echo date("Y-m-d"); ?>" readonly/>
                                </div>
                                <span class="help-block" id="error"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="eprod-name">Name of Product</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="eprod-name" id="eprod-name"
                                           placeholder="Type name of product">
                                </div>
                                <span class="help-block" id="error"></span>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="eentry-price">Price of Cost</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="eentry-price" id="eentry-price"
                                           placeholder="50.00"/>
                                </div>
                                <span class="help-block" id="error"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="esell-price">Retail Value</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="esell-price" id="esell-price"
                                           placeholder="50.00">
                                </div>
                                <span class="help-block" id="error"></span>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="equantity">Quantity</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="equantity" id="equantity"
                                           placeholder="10"/>
                                </div>
                                <span class="help-block" id="error"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <div class="form-group">
                                    <label for="eunit">Unit</label>
                                    <select name="eunit" class="form-control" id="eunit">
                                        <option value="">Choose a unit type</option>
                                        <option value="Pounds">Pounds</option>
                                        <option value="Inches">Inches</option>
                                        <option value="Feet">Feet</option>
                                        <option value="Pieces">Pieces</option>
                                        <option value="Liters">Liters</option>
                                        <option value="Other">Other</option>
                                    </select>
                                    <span class="help-block" id="error"></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edescription">Description</label>
                            <div class="input-group">
                                <textarea class="form-control" name="edescription" id="edescription">
                                </textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="upd-prod-btn" name="upd-prod-btn" class="btn btn-primary upd-btn">
                            Save Changes
                        </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>