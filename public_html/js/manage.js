/**
 * @file
 *     manage.js contains all the necessary functions & event handlers to validate forms,
 *     to login to the system & to add & manage profile's, user's,
 *     product's & client's information.
 * @author Fabiola Berenice Hatfield
 *
 */
let DOMAIN = "http://localhost/sainprohost/public_html/";

// Regular Expression to validate NAMES
let nameregex = /^([A-Z"-.][a-z]+ [A-Za-z"-.]+(?:\ [a-zA-Z"-.]+)?)$/;


// Add a method to validate names
$.validator.addMethod("validname", function( value, element ) {
    return this.optional( element ) || nameregex.test( value );
});


// Regular Expression to validate EMAILS
let email_regex = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;


// Adds a method to validate emails
$.validator.addMethod("validemail", function( value, element ) {
    return this.optional( element ) || email_regex.test( value );
});


// Regular Expression to validate PHONE NUMBERS
let phone_regex = /^((\+)?[1-9]{1,2})?([-\s\.])?((\(\d{1,4}\))|\d{1,4})(([-\s\.])?[0-9]{1,12}){1,2}(\s*(ext|x)\s*\.?:?\s*([0-9]+))?$/;


// Add a method to validate phone numbers
$.validator.addMethod("validphone", function(value, element) {
    return this.optional( element ) || phone_regex.test( value );
});


/**
 * @description Contains all the neccesary methods to log in.
 * @constructor
 */
function Login(){

    // Validates the LOGIN form
    $("#login-form").validate({
        rules: {
            password: {
                required: true,
            },
            email: {
                required: true,
                validemail: true,
            },
        },
        messages: {
            password:{
                required: "Password is required",
            },
            email:{
                required: "E-mail Address is required",
                validemail: "Please, insert a valid email address",
            }
        },
        errorPlacement : function(error, element){
            $(element).closest(".form-group").find(".help-block").html(error.html());
        },
        highlight : function(element) {
            $(element).closest(".form-control").removeClass("has-success").addClass("has-error");
        },
        unhighlight: function(element, errorClass, validClass){
            $(element).closest(".form-control").removeClass("has-error");
            $(element).closest(".form-group").find(".help-block").html("");
        },
        submitHandler: logInForm
    });

    /**
     * @method logInForm
     * @description
     * 1. Serialize the data of the form & stores the result in variable "data".
     * 2. AJAX request to login.
     * 3. If data received equals to "1", redirects to dashboard.
     * 4. If data received equals is not "1", means there is a problem,
     *    & show the error received.
     * @returns {boolean}
     */
    function logInForm() {
        let data = $("#login-form").serialize();
        $.ajax({
            type : "POST",
            url  : "operations/set-unset-session.php?action=logIn",
            data : data,
            beforeSend: function(){
                $(".overlay").show();
                $("#error").fadeOut();
                $("#login-submit").prop("disabled", true);
                $("#login-submit").html("<span class='glyphicon glyphicon-transfer'></span>Sending...");
            },
        }).done(function (response) {
            if($.trim(response) === "1"){
                $("#login-submit").html("Logging in...");
                setTimeout(" window.location.href = DOMAIN +'dashboard.php'; ",2000);
            } else {
                $("#error").fadeIn(1000, function(){
                    $(".overlay").hide();
                    $("#error").html(response).show();
                    $("#login-submit").prop("disabled", false);
                    $("#login-submit").html("Log In");
                }).delay(2500).slideUp("fast");
            }
        }).fail(function (e) {
            $("#error").fadeIn(1000, function(){
                $(".overlay").hide();
                $("#error").html("Something went wrong!").show();
                $("#login-submit").prop("disabled", false);
                $("#login-submit").html("Log In");
            }).delay(2500).slideUp("fast");
        });
        return false;
    }
}

/**
 * @description Contains all the neccesary methods neccesary to validate & add
 * clients, products & users.
 * @constructor
 */
function AddRecords(){

    // Validates CLIENT MODAL FORM
    $("#client-form").validate({
        rules: {
            "client-name": {
                required: true,
                validname: true,
                minlength: 4,
            },
            phone: {
                required: true,
                validphone: true,
                minlength: 10,
            },
            "client-email": {
                validemail: true,
            },
        },
        messages: {
            "client-name": {
                required: "Name is required",
                validname: "Only letters allowed. Name must contain 2-3 words. First letter must be capitalize.",
                minlength: "Name is too short",
            },
            phone: {
                required: " Phone number is required",
                validphone: "Please, insert a valid phone number",
                minlength: "Phone number is too short",
            },
            "client-email": {
                validemail: "Please, insert a valid email address",
            },
        },
        errorPlacement : function(error, element) {
            $(element).closest(".form-group").find(".help-block").html(error.html());
        },
        highlight : function(element) {
            $(element).closest(".form-control").removeClass("has-success").addClass("has-error");
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).closest(".form-control").removeClass("has-error");
            $(element).closest(".form-group").find(".help-block").html("");
        },
        submitHandler: function () {
            addRecord("Client", "#client-form")
        }
    });


    // Validates USER MODAL FORM
    $("#user-form").validate({
        rules: {
            password: {
                required: true,
                minlength: 6,
                maxlength: 45,
            },
            cpassword: {
                required: true,
                equalTo: "#password",
            },
            name: {
                required: true,
                validname: true,
                minlength: 4,
            },
            email : {
                required : true,
                validemail: true,
            },
            "user-type": {
                required : true,
            },
        },
        messages: {
            password: {
                required: "Password is required",
                minlength: "Password must contain at least 6 characters",
            },
            cpassword: {
                required: "Confirm password",
                equalTo: "Passwords do not match!",
            },
            name:{
                required: "Name is required",
                validname: "Only letters allowed. Name must contain 2-3 words. First letter must be capitalize.",
                minlength: "Name is too short",
            },
            email: {
                required: "E-mail Address is required",
                validemail: "Please, insert a valid email address",
            },
            "user-type": {
                required : "User type is required",
            },
        },
        errorPlacement : function(error, element) {
            $(element).closest(".form-group").find(".help-block").html(error.html());
        },
        highlight : function(element) {
            $(element).closest(".form-control").removeClass("has-success").addClass("has-error");
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).closest(".form-control").removeClass("has-error");
            $(element).closest(".form-group").find(".help-block").html("");
        },
        submitHandler: function () {
            addRecord("User", "#user-form")
        }
    });


     // Validates PRODUCT MODAL FORM
    $("#product-form").validate({
        rules: {
            "product-name": {
                required: true,
                minlength: 4,
                maxlength: 40,
            },
            "entry-price": {
                required:true,
                number: true,
            },
            "sell-price": {
                required: true,
                number: true,
            },
            quantity: {
                required: true,
                number: true,
                min: 1,
            },
            unit: {
                required: true,
            },

        },
        messages: {
            "product-name": {
                required: "Product name is required",
                minlength: "Product name is too short",
                maxlength: "Product name is too long",
            },
            "entry-price": {
                required: "Price of cost is required",
                number: "Please, insert a valid amount",
            },
            "sell-price": {
                required: "Retail value is required",
                number: "Please, insert a valid amount",
            },
            quantity: {
                required: "Product quantity is required",
                number: "Please, insert a valid quantity",
                min: "Minimum quantity is 1",
            },
            unit: {
                required: "Product unit is required",
            },
        },
        errorPlacement : function(error, element) {
            $(element).closest(".form-group").find(".help-block").html(error.html());
        },
        highlight : function(element) {
            $(element).closest(".form-control").removeClass("has-success").addClass("has-error");
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).closest(".form-control").removeClass("has-error");
            $(element).closest(".form-group").find(".help-block").html("");
        },
        submitHandler: function () {
            addRecord("Product", "#product-form")
        }
    });


    /**
     * @description
     * 1. Serialize the data of the form & stores the result in variable "data".
     * 2. AJAX request to add record to database.
     * 3. If the response received equals to "1", means the data was added.
     * 4. If the response received is not "1", means there was something wrong.
     * @param table - The name of the table to which the record to add belongs
     * @param form - The element that contains the form.
     * @returns {boolean}
     */
    function addRecord(table, form){
        let data = $(form).serialize();
        $.ajax({
            type : "POST",
            url  : "operations/response.php?action=add"+table,
            data : data,
            beforeSend: function(){
                $(".adding-error").html("").fadeOut();
                $(".adding-success").html("").fadeOut();
                $(".adding-submit").prop("disabled", true);
                $(".adding-submit").html("Sending...");
            },
        }).done(function (response) {
            if($.trim(response) === "1"){
                $(".adding-submit").html("Adding...");
                $(".adding-success").fadeIn(1000, function(){
                    $(".adding-success").html(`Success! data has been added`).show();
                    $(form).trigger("reset");
                }).delay(2500).slideUp("fast");
                $(".adding-submit").html("Add");
                $(".adding-submit").prop("disabled", false);
            } else {
                $(".adding-error").fadeIn(1000, function(){
                    $(".adding-error").html(response).show();
                    $(form).trigger("reset");
                    $(".adding-submit").html("Add");
                    $(".adding-submit").prop("disabled", false);
                }).delay(2500).slideUp("fast");
            }
        });
        return false;
    }
}

/**
* @description Contains all the neccesary methods neccesary to validate & update
* profile infomation.
* @constructor
*/
function ManageProfile() {

    /**
     * 1. Check for a click event on an element with class "edit-profile" (Edit Profile button)
     *    inside <div> with class "card-body" .
     * 2. Declare and initialize variable "myid" with the id attribute of selected element (user id).
     * 3. AJAX request to prepare & show single record information.
     * 4. Set corresponding value attributes for elements with ids: myid, prof-reg-date, prof-name,
     *    prof-email & prof-user-type (input elements).
     */
    $("div.card-body").on("click", ".edit-profile", function () {
        let myid = $(this).attr("id");
        $.ajax({
            type: "POST",
            url:  "operations/response.php?action=prepareSingleRecord",
            dataType: "json",
            data: {show_data: 1, id: myid, table: "user"},
        }).done(function (data) {
            $("#myid").val(data.id);
            $("#prof-reg-date").val(data.register_date);
            $("#prof-name").val(data.user_name);
            $("#prof-email").val(data.user_email);
            $("#prof-user-type").val(data.user_type);
        }).fail(function () {
            swal.fire("Oops...!", "Something went wrong", "error");
        });
    });


    // Validates PROFILE MODAL FORM.
    $("#profile-form").validate({
        rules: {
            "prof-password": {
                required: true,
                minlength: 6,
                maxlength: 45,
            },
            "prof-cpassword": {
                required: true,
                equalTo: "#prof-password",
            },
            "prof-name": {
                required: true,
                validname: true,
                minlength: 4,
            },
            "prof-email": {
                required: true,
                validemail: true,
            },
        },
        messages: {
            "prof-password": {
                required: "Password is required",
                minlength: "Password must contain at least 6 characters",
            },
            "prof-cpassword": {
                required: "Confirm password",
                equalTo: "Passwords do not match!",
            },
            "prof-name": {
                required: "Name is required",
                validname: "Only letters allowed. Name must contain 2-3 words. First letter must be capitalize.",
                minlength: "Name is too short",
            },
            "prof-email": {
                required: "Email is required",
                validemail: "Please, insert a valid email address",
            },
        },
        errorPlacement: function (error, element) {
            $(element).closest(".form-group").find(".help-block").html(error.html());
        },
        highlight: function (element) {
            $(element).closest(".form-group").removeClass("has-success").addClass("has-error");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).closest(".form-group").removeClass("has-error");
            $(element).closest(".form-group").find(".help-block").html("");
        },
        submitHandler: updProfile
    });


    /**
     * @description
     * 1. Serialize the data of the form & stores the result in variable "data".
     * 2. AJAX request to update record in database.
     * 3. If the response received equals to "1", means the data was updated & redirects to dashboard.
     * 4. If the response received is not "1", means there was something wrong, show the error & redirects to dashboard.
     * @returns {boolean}
     */
    function updProfile() {
        let data = $("#profile-form").serialize();
        $.ajax({
            type: "POST",
            url: "operations/response.php?action=updateProfile",
            data: data,
            beforeSend: function () {
                $("#prof-error").html("").fadeOut();
                $("#prof-btn").prop("disabled", true);
                $("#prof-btn").html("Sending...");
            },
        }).done(function (response) {
            if ($.trim(response) === "1") {
                $("#prof-btn").html("Updating...");
                $("#prof-success").fadeIn(1000, function () {
                    $("#prof-success").html("Your information has been updated! You will see the added changes in your next log in").show();
                }).delay(2500).slideUp("fast");
                setTimeout(function () {
                    window.location.href = "";
                }, 3000);
            } else {
                $("#prof-error").fadeIn(1300, function () {
                    $("#prof-error").html(response).show();
                    $("#prof-btn").html("Update");
                    $("#prof-btn").prop("disabled", false);
                }).delay(2500).slideUp("fast");
                $("#prof-password").val("");
                $("#prof-cpassword").val("");
            }
        });
        return false;
    }
}

/**
 * @description Contains the neccesary methods to read, search & delete records.
 * @param table_name - The name of table to manage
 * @param delete_button - The HTML class of the delete button
 * @param search_selector - The HTML ID of the search input
 * @param data_location - The HTML tbody ID
 * @constructor
 */
function ManagePage(table_name, delete_button, search_selector, data_location) {
    readRecords();
    showModalData();
    searchData();
    prepToDelete();

    /**
     *
     *
     * 1. Check for a click event on an element with class ".show-more"
     *    inside table body <tbody>
     * 3. Get the attribute "show-id" of the element.
     * 4. AJAX request to prepare & read all the information of the record selected.
     * 5. Add data as HTML to data_location.
     * 6. Show modal that contains the information received.
     * @param data_location
     */
    this.moreInfo = function (data_location) {
        $("#get-invoice").on("click", ".show-more", function () {
            let invoice_no = $(this).attr("show-id");
            $.ajax({
                type: "POST",
                url: DOMAIN + "/operations/response.php?action=prepToReadRecords",
                data: {"read-records": 1, "invoice-no": invoice_no, table: 'invoice_details'},
            }).done(function (data) {
                $(data_location).html(data);
                $('#show-more').modal("show");
            }).fail(function () {
                swal.fire("Oops...!", "Something went wrong", "error");
            });
        });
    };
    /**
     * @description
     * 1. AJAX request to prepare & read all the records of the corresponding table.
     * 2. Data received is the <tr> elements with their respective content.
     * 3. Add data as HTML to data_location.
     */
    function readRecords() {
        $.ajax({
            type: "POST",
            url: DOMAIN + "/operations/response.php?action=prepToReadRecords",
            data: {"read-records": 1, "invoice-no": null, table: table_name.toLocaleLowerCase()},
        }).done(function (data) {
            $(data_location).html(data);
        }).fail(function () {
            swal.fire("Oops...!", "Something went wrong", "error");
        });
    }

    /**
     * @description
     * 1. Define & create variable "html_class"; it is used to know the name of
     *    the class to which the record to be modified belongs.
     * 2. Check for a click event on an element with class "edit-(table_name)"
     *    inside table body <tbody>
     * 3. Get the attribute "edit-id" of the element.
     * 4. AJAX request to prepare & read information of the record selected.
     * 5. Switch statement to know the table_name,
     *    set respective data to form elements, depending on the table.
     */
    function showModalData() {
        let html_class = ".edit-" + table_name.toLocaleLowerCase();
        $(data_location).on("click", html_class, function () {
            let eid = $(this).attr("edit-id");
            $.ajax({
                type: "POST",
                url: DOMAIN + "/operations/response.php?action=prepareSingleRecord",
                dataType: "json",
                data: {show_data: 1, id: eid, table: table_name.toLocaleLowerCase()},
            }).done(function (data) {
                switch (table_name) {
                    case "User":
                        $("#eu-id").val(data.id);
                        $("#eu-name").val(data.user_name);
                        $("#eu-email").val(data.user_email);
                        $("#eureg-date").val(data.register_date);
                        $("#euuser-type").val(data.user_type);
                        $("#eu-last").val(data.last_login);
                        break;
                    case "Client":
                        $("#ec-id").val(data.id);
                        $("#ec-name").val(data.client_name);
                        $("#ec-phone").val(data.client_phone);
                        $("#ec-address").val(data.client_address);
                        $("#ec-email").val(data.client_email);
                        break;
                    case "Product":
                        $("#epid").val(data.id);
                        $("#eprod-name").val(data.product_name);
                        $("#eentry-price").val(data.entry_price);
                        $("#esell-price").val(data.sell_price);
                        $("#equantity").val(data.quantity);
                        $("#eunit").val(data.unit);
                        $("#edescription").val(data.description);
                        break;
                }

            });
        });
    }


    /**
     * @description
     * 1. Check for a keyup event on the selector element (search input)
     *    inside of <div> with class "container".
     * 2. Declare and initialize variable "value" with the value attribute
     *    of the element(word to search),
     * 3. If value is not empty,
     *      AJAX request to prepare query, get data related & create row with that data
     * 4. Add data received as HTML to data_location <tbody>
     * 5. If value is empty, call readRecords method.
     */
    function searchData() {
        $("div.container").on("keyup", search_selector, function () {
            let value = $(this).val();
            if (value !== "") {
                $.ajax({
                    type: "POST",
                    url: DOMAIN + "/operations/response.php?action=prepareToSearch",
                    dataType: "html",
                    data: {query: value, table: table_name.toLocaleLowerCase()},
                }).done(function (answer) {
                    $(data_location).html(answer);
                }).fail(function () {
                    swal.fire("Oops...!", "Something went wrong", "error");
                });
            } else {
                readRecords();
            }
        });
    }


    /**
     * @description
     * 1. Check for a click event on the delete_button selector (delete button)
     *    inside <tbody>.
     * 2. Declare and initialize variable "id_del" with the attribute "data-deleteid"
     *    of that element,
     * 3. Call deleteData method with "id_del" as parameter.
     * 4. Prevent default action.
     */
    function prepToDelete() {
        $("tbody").on("click", delete_button, function (e) {
            let id_del = $(this).attr("data-deleteid");
            deleteData(id_del);
            e.preventDefault();
        });
    }


    // Validates the USER MODAL FORM
    $("#update-user-form").validate({
        rules: {
            "eu-name": {
                required: true,
                validname: true,
                minlength: 4,
            },
            "eu-email": {
                required: true,
                validemail: true,
            },
            "euuser-type": {
                required: true,
            },
        },
        messages: {
           "eu-name": {
                required: "Name is required",
                validname: "Only letters allowed. Name must contain 2-3 words. First letter must be capitalize.",
                minlength: "Name is too short",
            },
            "eu-email": {
                required: "Email is required",
                validemail: "Please, insert a valid email address",
            },
            "euuser-type": {
                required: "User type is required",
            },
        },
        errorPlacement: function (error, element) {
            $(element).closest(".form-group").find(".help-block").html(error.html());
        },
        highlight: function (element) {
            $(element).closest(".form-group").removeClass("has-success").addClass("has-error");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).closest(".form-group").removeClass("has-error");
            $(element).closest(".form-group").find(".help-block").html("");
        },
        submitHandler: function () {
            updForm("User", "#update-user-form");
        }
    });


    // Validates the CLIENT MODAL FORM
    $("#update-client-form").validate({
        rules: {
            "ec-name": {
                required: true,
                validname: true,
                minlength: 4,
            },
            "ec-phone": {
                required: true,
                validphone: true,
                minlength: 10,
            },
            "ec-email": {
                validemail: true,
            },
        },
        messages: {
            "ec-name": {
                required: "Name is required",
                validname: "Only letters allowed. Name must contain 2-3 words. First letter must be capitalize.",
                minlength: "Name is too short",
            },
            "ec-phone": {
                required: "Phone number is required",
                validphone: "Please, insert a valid phone number",
                minlength: "Phone number is too short",
            },
            "ec-email": {
                validemail: "Please, inser a valid email address",
            },
        },
        errorPlacement: function (error, element) {
            $(element).closest(".form-group").find(".help-block").html(error.html());
        },
        highlight: function (element) {
            $(element).closest(".form-group").removeClass("has-success").addClass("has-error");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).closest(".form-group").removeClass("has-error");
            $(element).closest(".form-group").find(".help-block").html("");
        },
        submitHandler: function () {
            updForm("Client", "#update-client-form");
        }
    });


    // Validates the PRODUCT MODAL FORM
    $("#update-product-form").validate({
        rules: {
           "eprod-name": {
                required: true,
                minlength: 4,
                maxlength: 40,
            },
            "eentry-price": {
                required: true,
                number: true,
            },
            "esell-price": {
                required: true,
                number: true,
            },
            equantity: {
                required: true,
                number: true,
                min: 1,
            },
            eunit: {
                required: true,
            },

        },
        messages: {
            "eprod-name": {
                required: "Product name is required",
                minlength: "Product name is too short",
                maxlength: "Product name is too long",
            },
            "eentry-price": {
                required: "Price of cost is required",
                number: "Please, insert a valid amount",
            },
            "esell-price": {
                required: "Retail value is required",
                number: "Please, insert a valid amount",
            },
            equantity: {
                required: "Product quantity is required",
                number: "Please, insert a valid quantity",
                min: "Minimum quantity is 1",
            },
            eunit: {
                required: "Product unit is required",
            },
        },
        errorPlacement: function (error, element) {
            $(element).closest(".form-group").find(".help-block").html(error.html());
        },
        highlight: function (element) {
            $(element).closest(".form-group").removeClass("has-success").addClass("has-error");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).closest(".form-group").removeClass("has-error");
            $(element).closest(".form-group").find(".help-block").html("");
        },
        submitHandler: function () {
            updForm("Product", "#update-product-form");
        }
    });

    /**
     * @description
     * 1. Serialize the data of the form & stores the result in variable "data".
     * 2. AJAX request to update the information of specific record.
     * 3. If data received equals to "1", means the data was updated & call readRecords method.
     * 4. If data received is not "1", means something went wrong & show the error.
     * @param table - The table to which the record to be updated belongs
     * @param form - The HTML ID of the record's form
     * @returns {boolean}
     */
    function updForm(table, form) {
        let data = $(form).serialize();
        $.ajax({
            type: "POST",
            url: "operations/response.php?action=update" + table,
            data: data,
            beforeSend: function () {
                $(".edit-error").html("").fadeOut();
                $(".edit-success").html("").fadeOut;
                $(".upd-btn").prop("disabled", true);
                $(".upd-btn").html("Sending...");
            },
        }).done(function (response) {
            if ($.trim(response) === "1") {
                $(".upd-btn").html("Updating...");
                $(".edit-success").fadeIn(1000, function () {
                    $(".edit-success").html(`Success! ${table}'s data has been updated`).show();
                    readRecords();
                }).delay(3000).slideUp("fast");
                $(".upd-btn").html("Update");
                $(".upd-btn").prop("disabled", false);
            } else {
                $(".edit-error").fadeIn(1000, function () {
                    $(".edit-error").html(response).show();
                    $(".upd-btn").html("Update");
                    $(".upd-btn").prop("disabled", false);
                }).delay(2500).slideUp("fast");
            }
        });
        return false;
    }


    /**
     * @description
     * 1. Show confirmation alert to make sure user wants to delete record.
     * 2. If confirm button was clicked,
     *    AJAX request to delete record.
     * 3. If data received equals to "1", means the record was deleted
     *    & call readRecords method.
     * 4. If data is not "1", means something went wrong.
     * @param id - The ID of the record to be deleted
     */
    function deleteData(id) {
        swal.fire({
            title: "Are you sure?",
            text: "Data can not be recovered once it's deleted.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, Delete!",
            cancelButtonText: "Cancel",
            allowOutsideClick: false,
            showLoaderOnConfirm: true,
            preConfirm: function () {
                return new Promise(function (resolve) {
                    $.ajax({
                        url: DOMAIN + "/operations/response.php?action=prepToDel",
                        type: "POST",
                        data: {delete: 1, id: id, table: table_name.toLocaleLowerCase()},
                    }).done(function (response) {
                        if (response == 1) {
                            swal.fire("Success!", table_name + " has been deleted", "success");
                            readRecords();
                        } else {
                            swal.fire("Oops...!", "Something went wrong", "error");
                        }
                    }).fail(function () {
                        swal.fire("Oops...!", "Something went wrong", "error");
                    });
                });
            },

        });
    }

}