<div class="modal fade" id="add-product-modal" role="dialog" aria-labelledby="add-product-modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add-product-modal">Add Product</h5>
            </div>
            <div class="modal-body">
                <!-- form start -->
                <form id="product-form" autocomplete="off">
                    <div class="form-body">
                        <!-- json response will be here -->
                        <div class="alert alert-danger adding-error" role="alert" id="prod-error"
                             style="display: none;">...
                        </div>
                        <div class="alert alert-success adding-success" role="alert" id="prod-success"
                             style="display: none;">...
                        </div>
                        <!-- json response will be here -->
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="entry_date">Entry Date</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="entry_date" id="entry_date"
                                           value="<?php echo date("Y-m-d"); ?>" readonly/>
                                </div>
                                <span class="help-block" id="error"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="product-name">Name of Product</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="product-name" id="product-name"
                                           placeholder="Oxygen">
                                </div>
                                <span class="help-block" id="error"></span>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="entry-price">Price of Cost</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="entry-price" id="entry-price"
                                           placeholder="50.00"/>
                                </div>
                                <span class="help-block" id="error"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="sell-price">Retail Price</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="sell-price" id="sell-price"
                                           placeholder="50.00">
                                </div>
                                <span class="help-block" id="error"></span>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="quantity">Quantity</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="quantity" id="quantity"
                                           placeholder="10"/>
                                </div>
                                <span class="help-block" id="error"></span>
                            </div>

                            <div class="form-group col-md-6">
                                <div class="form-group">
                                    <label for="unit">Unit</label>
                                    <select name="unit" class="form-control" id="unit">
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
                            <label for="description">Description</label>
                            <div class="input-group">
                                <textarea class="form-control" name="description" id="description">
                                </textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="add-prod-btn" name="add-prod-btn" class="btn btn-primary adding-submit">Add
                        </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>