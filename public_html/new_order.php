<?php
include_once("db_config_isset_session.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>New Invoice</title>
    <!-- Scripts jQuery, ajax, bootstrap -->
    <?php
    include_once("templates/main_css.php");
    ?>

    <?php
    include_once("templates/scripts.php");
    ?>
    <script type="text/javascript" src="js/order.js"></script>


</head>
<body>

<div class="overlay">
    <div class="loader"></div>
</div>

<!-- Navbar !-->
<?php include_once("templates/header.php"); ?>
<br><br/>

    <div class="container">
        <div class="row">
            <div class="col-md-10 mx-auto">
                <div class="card order-card">
                    <div class="card-header text-white"><h5>New Order</h5>
                    </div>
                    <div class="card-body">
                        <!-- Begins form -->
                        <form id="get-order-data" autocomplete="off">
                            <div class="form-group row">
                                <label for="order-date" class="col-sm-3 col-form-label">Date</label>
                                <div class="col-sm-6">
                                    <input type="text" id="order-date" name="order-date" readonly
                                           class="form-control form-control-sm" value="<?php
                                    date_default_timezone_set('America/Chicago');
                                    echo date("Y-m-d H:i:s");
                                    ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="cust-name" class="col-sm-3 col-form-label">Client's
                                    name*</label>
                                <div class="col-sm-6">
                                    <select name="cust-name" id="cust-name" class="form-control form-control-sm">
                                    </select>
                                    <span class="help-block" id="error"></span>
                                </div>
                            </div>
                            <div class="card table-responsive" style="box-shadow: 0 0 25px 0 lightgrey">
                                <div class="card-body form-group">
                                    <h3>Order List</h3>
                                    <div class="add-remove-btns float-right" id="add-remove-btns">
                                        <i id="add" class="fas fa-plus-circle icon-add"></i>
                                        <i id="remove" class="fas fa-minus-circle icon-remove"></i>
                                    </div>
                                    <table class="table table-hover table-bordered" align="center" id="order-table-id">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th>#</th>
                                            <th>Product's name</th>
                                            <th>Quantity in stock</th>
                                            <th>Unit</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Total</th>
                                        </tr>
                                        </thead>
                                        <tbody id="invoice-item">
                                        <!-- List of products-->
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                            <p></p>
                            <div class="form-group row">
                                <label for="sub-total" class="col-sm-3 col-form-label">Subtotal</label>
                                <div class="col-sm-6">
                                    <input type="text" readonly name="sub-total" class="form-control form-control-sm"
                                           id="sub-total"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="taxes" class="col-sm-3 col-form-label">Taxes (6%)</label>
                                <div class="col-sm-6">
                                    <input type="text" readonly name="taxes" class="form-control form-control-sm"
                                           id="taxes"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="discount" class="col-sm-3 col-form-label">Discount</label>
                                <div class="col-sm-6" id="disc">
                                    <input type="text" name="discount" class="form-control form-control-sm"
                                           id="discount"/>
                                    <span class="help-block" id="error"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="net-total" class="col-sm-3 col-form-label">Net Total</label>
                                <div class="col-sm-6">
                                    <input type="number" readonly name="net-total" class="form-control form-control-sm"
                                           id="net-total"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="paid" class="col-sm-3 col-form-label">Amount Paid*</label>
                                <div class="col-sm-6" id="amount-paid">
                                    <input type="text" name="paid" class="form-control form-control-sm paid" id="paid"/>
                                    <span class="help-block" id="error"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="due" class="col-sm-3 col-form-label">Due Amount</label>
                                <div class="col-sm-6">
                                    <input type="text" readonly name="due" class="form-control form-control-sm"
                                           id="due"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="payment-type" class="col-sm-3 col-form-label">Payment
                                    method</label>
                                <div class="col-sm-6">
                                    <select name="payment-type" class="form-control form-control-sm" id="payment-type">
                                        <option value="Cash">Cash</option>
                                        <option value="Debit">Debit</option>
                                        <option value="Credit">Credit</option>
                                        <option value="Check">Check</option>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <button type="submit" id="place-order-btn" name="place-order-btn"
                                        class="btn btn-primary">Finish Order
                                </button>
                                <input type="submit" id="print-invoice" style="width:150px;"
                                       class="btn btn-success d-none" value="Print Invoice">
                            </div>
                        </form><!-- Ends form -->
                    </div>

                    <div class="card-footer text-muted  text-center bg-transparent border-primary">SAINPRO</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>