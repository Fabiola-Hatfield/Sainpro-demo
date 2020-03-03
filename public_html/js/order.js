/**
 * @file
 *     order.js contains all the necessary functions & event handlers
 *     to place an order.
 * @author Fabiola Berenice Hatfield
 *
 */
$(document).ready(function () {
    "use strict";

    let DOMAIN = "http://localhost/sainprohost/public_html";

    // Adds a method to validate that the paid amount is not greater than the due amount
    $.validator.addMethod("maxallowed", function (value, element, param) {
        let $due = parseFloat(value, 10);
        let $total = parseFloat($(param).val(), 10);
        return $due <= $total;
    });

    /// Adds a method to validate that the discount amount is not greater than the due amount
    $.validator.addMethod("maxdiscount", function (value, element, params) {
        let $subtotal = parseFloat($(params[0]).val(), 10);
        let $taxes = parseFloat($(params[1]).val(), 10);
        let $due_amount = $subtotal + $taxes;
        return parseFloat(value, 10) <= $due_amount;
    });


    addNewClient();
    addNewRow();


    /**
     * Check for a click event on an element with id "add" (add button) inside <div> with id "add-remove-btns",
     * calls addNewRow function.
     */
    $("div#add-remove-btns").on("click", "#add", function () {
        addNewRow();
    });


    /**
     * 1. Check for a click event on an element with id "remove" (remove button)
     *    inside <div> with id "add-remove-btns" .
     * 2. Loop through each input element with name "check-row" inside the table body (checkbox),
     *    if the checked property of the checkbox is true, then
     *    remove all the ancestors that are <tr>.
     * 3. Loop through each element with class ".number" to
     *    change their content (update # column).
     * 4. Call calculate method to update calculations.
     */
    $("div#add-remove-btns").on("click", "#remove", function (){
        $("table tbody").find("input[name='check-row']").each(function () {
            if ($(this).prop("checked")){
                $(this).parents("tr").remove();
            }
        });
        let n = 0;
        $(".number").each(function () {
            $(this).html(++n);
        });
        calculate(0, 0);
    });


    /**
     * 1. Check for a change event on an element with class "prod-id" (drop-down list)
     *    inside element with id "invoice-item" (table body).
     * 2. Declare and initialize variable "id" with the value attribute of selected element (product id),
     * 3. Declare variable "tr" & initialize it with the closest <tr> element.
     * 4. If id is not empty, then
     *    AJAX request to get information of selected product,
     *    If the request returns data, then
     *    set corresponding value attribute to every <td> element.
     *    Call calculate method to update calculations.
     * 5. If id is empty (none selected element on drop-drown list), then
     *    set value attribute of every <td> element to UNDEFINED.
     *    Call calculate method to update calculations.
     */
    $("#invoice-item").on("change", ".prod-id", function () {
        let id = $(this).val();
        let tr = $(this).closest("tr");
        if(id !== ""){
           $.ajax({
               url: DOMAIN + "/operations/invoice.php?action=getPriceQty",
               method: "POST",
               dataType: "json",
               data: {get_price_qty: 1, id: id},
           }).done(function (data) {
               if (data) {
                   tr.find(".tqty").val(data.quantity);
                   tr.find(".pro-name").val(data.product_name);
                   tr.find(".unit").val(data.unit);
                   tr.find(".qty").prop("disabled", false).val(1);
                   tr.find(".price").val(data.sell_price);
                   tr.find(".amt").html(tr.find(".qty").val() * tr.find(".price").val());
                   calculate(0, 0);
               } else {
                   swal.fire("Error!", "Something went wrong!", "error");
               }
           });
        }else{
           tr.find(".tqty").val(undefined);
           tr.find(".pro-name").val(undefined);
           tr.find(".unit").val(undefined);
           tr.find(".qty").prop("disabled", true).val(undefined);
           tr.find(".price").val(undefined);
           tr.find(".amt").html(0);
           calculate(0, 0);
        }
    });


    /**
     * 1. Check for a keyup event on an element with class "qty" (Quantity column)
     *    inside element with id "invoice-item"  (table body).
     * 2. Declare and initialize variable "qty" with the keyup context,
     * 3. Declare variable "tr" & initialize it with the closest <tr> element.
     * 4. If the element value is not a number, then
     *    show an error alert, set the element value to 1 &
     *    call the calculate method to update calculations.
     * 5. If the element value is a number, then
     *      Make sure that the quantity is not 0 or
     *      greater than total amount in stock.
     * 6. Changes html content of the corresponding element with class ".amt".
     * 7. Call calculate method to update calculations.
     */
    $("#invoice-item").on("keyup", ".qty", function () {
        let qty = $(this);
        let tr = $(this).closest("tr");
        if (isNaN(qty.val())) {
            swal.fire("Error!", "Invalid amount!", "error");
            qty.val(1);
            calculate(0, $("#paid").val() - 0);
        } else {
            if (qty.val() !== "" && qty.val() - 0 == 0) {
                swal.fire("Error!", "Quantity cannot be 0", "error");
                qty.val(1);
            } else if ((qty.val() - 0) > (tr.find(".tqty").val() - 0)) {
                swal.fire("We are sorry!", "Total product amount is not in stock!", "warning");
                qty.val(1);
            }
        }
        tr.find(".amt").html(qty.val() * tr.find(".price").val());
        calculate(0, $("#paid").val() - 0);
    });



    /**
     * 1. Check for a keyup event on an element with id "discount" (discount input)
     *    inside <div> with id "disc".
     * 2. Declare and initialize variable "discount" with the value attribute of that element,
     * 3. Call calculate method to update calculations.
     */
    $("div#disc").on("keyup", "#discount", function () {
        let discount = $(this).val();
        calculate(discount, 0);
    });

    /**
     * 1. Check for a keyup event on an element with id "paid" (paid input)
     *    inside <div> with id "amount-paid".
     * 2. Declare and initialize variable "paid" with the value attribute of that element,
     * 3. Declare and initialize variable "discount" with the value attribute
     *    of the element with id "discount" (discount input),
     * 4. Call calculate method to update calculations.
     */
    $("div#amount-paid").on("keyup", "#paid", function () {
        let paid = $(this).val();
        let discount = $("#discount").val();
        calculate(discount, paid);
    });


    /**
     * @description
     * 1. AJAX request to get <tr> element and its content.
     * 2. Append data returned into element with id "invoice-item" (table body).
     *    of the element with id "discount" (discount input),
     * 3. Call calculate method to update calculations.
     * 4. Loop through each element with class ".number" to
     *    change their content (update # column).
     */
    function addNewRow() {
        $.ajax({
            url: DOMAIN + "/operations/invoice.php?action=newProdRow",
            type: "POST",
            data: {get_product_row: 1},
        }).done(function (data) {
            $("#invoice-item").append(data);
            let n = 0;
            $(".number").each(function () {
                $(this).html(++n);
            });
        });
    }


    /**
     * @description
     * 1. AJAX request to get <option> elements with the name of clients.
     * 2. Append data returned into element with id "cust-name" (drop-down list).
     */
    function addNewClient() {
        $.ajax({
            url: DOMAIN + "/operations/invoice.php?action=showClient",
            type: "POST",
            data: {get_new_client: 1},
        }).done(function (data) {
            $("#cust-name").append(data);
        });
    }


    /**
     * @description
     * 1. Declare and initialize variables "sub_total", "taxes", "net_total" & "due" with value 0,
     *    Declare and initialize variables "discount" & "paid_amt" with the parameters received.
     * 2. For each element with the class "amt",
     *    call roundNumber method with the sum of current sub_total & the current .amt as parameters &
     *    stores the result in sub_total variable.
     * 3. Store new values for taxes, net_total and due variables.
     * 4. Set value attributes for elements with ids: taxes, sub-total, discount, net-total & due
     * @param dis - The discount amount
     * @param paid - The paid amount
     */
    function calculate(dis, paid) {
        let sub_total = 0;
        let taxes = 0;
        let net_total = 0;
        let due = 0;
        let discount = dis;
        let paid_amt = paid;
        $(".amt").each(function () {
            sub_total = roundNumber((sub_total + ($(this).html() * 1)));
        });
        taxes = roundNumber(0.06 * sub_total);

        net_total = roundNumber(taxes + sub_total);
        net_total = roundNumber(net_total - discount);
        due = roundNumber(net_total - paid_amt);
        $("#taxes").val(taxes);
        $("#sub-total").val(sub_total);
        $("#discount").val(discount);
        $("#net-total").val(net_total);
        $("#due").val(due);
    }


    /**
     * @description Round the number to two decimals
     * @param number - The number to be rounded
     * @returns {number}
     */
    function roundNumber(number) {
        let rounded_number = +(Math.round(number * 100) / 100).toFixed(2);
        return rounded_number;
    }


    // Validates the get-order-data FORM before sending it.
    $("#get-order-data").validate({
        rules: {
            "cust-name": {
                required: true,
            },
            paid: {
                required: true,
                number: true,
                min: 1,
                maxallowed: "#net-total",
            },
            "prod-id[]": {
                required: true,
            },
            "prod-qty[]": {
                required: true,
            },
            discount: {
                number: true,
                maxdiscount: ["#sub-total", "#taxes"],
            },
        }, messages: {
            "cust-name": {
                required: "Please, select a customer name",
            },
            paid: {
                required: "Please, insert an amount",
                number: "Invalid amount. Only numbers are allowed",
                min: "Amount paid cannot be 0",
                maxallowed: "Payment cannot be greater than total",
            },
            "prod-id[]": {
                required: "Please, select a product",
            },
            "prod-qty[]": {
                required: "Please, insert a quantity",
            },
            discount: {
                number: "Invalid amount. Only numbers are allowed",
                maxdiscount: "Discount cannot be greater than total",
            },
        },
        errorPlacement: function (error, element) {
            $(element).closest(".form-group").find(".help-block").html(error.html());
        },
        highlight: function (element) {
            $(element).closest(".form-control").removeClass("has-success").addClass("has-error");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).closest(".form-control").removeClass("has-error");
            $(element).closest(".form-group").find(".help-block").html("");
        },
        submitHandler: placeOrder
    });


    /**
     * @description
     * 1. Serialize the data of the form & stores the result in variable "invoice".
     * 2. AJAX request to prepare & create order.
     * 3. If data received equals to -1, means the user add a product more than once.
     * 4. If data received equals to 0, means one of the products is out of stock.
     * 5. If none of the above is true, means he order was successful,
     *    reset the form & ask users if they need to print the invoice.
     * 6. If invoice is requested, prepares the data required &
     *    set an AJAX request to create a PDF file.
     * @param dis - The discount amount
     * @param paid - The paid amount
     */
    function placeOrder() {
        let invoice = $("#get-order-data").serialize();
        $.ajax({
            url: DOMAIN + "/operations/invoice.php?action=prepareOrder",
            method: "POST",
            data: $("#get-order-data").serialize(),
        }).done(function (data) {
            if (data == -1){
                swal.fire({
                    title: "Cannot proceed",
                    text: "Duplicate products in order",
                    icon: "error",
                    allowOutsideClick: false
                }).then((result) => {
                    $("#paid").val(0);
                    calculate($("#discount").val(),0);
                });
            }
            else if (data == 0) {
                swal.fire({
                    title: "Cannot proceed",
                    text: "One of the products is out of stock!",
                    icon: "error",
                    allowOutsideClick: false
                }).then((result) => {
                    $("#paid").val(0);
                    calculate($("#discount").val(),0);
                });
            } else {
                $("#get-order-data").trigger("reset");
                $("#amt").html(0);
                swal.fire({
                    title: "Success!",
                    text: "Would you like to print the invoice?",
                    icon: "success",
                    showCancelButton: true,
                    allowOutsideClick: false,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, print",
                    cancelButtonText: "No, exit"
                }).then((result) => {
                    if (result.value) {
                        let new_data = "invoice-no=" + data.trim() + "&" + invoice;
                        $.ajax({
                            url: DOMAIN + "/operations/invoice_bill.php?" + new_data,
                            method: "POST",
                            data: new_data,
                        }).done(function () {
                            window.location.href = DOMAIN + "/PDF_INVOICE/PDF_INVOICE_" + data + ".pdf";
                        });
                    }else {
                        location.reload();
                    }
                });
            }
        });
    }
});