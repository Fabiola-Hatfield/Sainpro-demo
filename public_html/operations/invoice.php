<?php
// Include connection & manage files
require_once('../database/connection.php');
include_once('manage.php');

$params = $_REQUEST;
$action = $params['action'] !='' ? $params['action'] : '';

// Creates an instance of class InvoiceOperations
$inv_obj = new InvoiceOperations();

/**
 * Call the corresponding method depending on the value of variable $action
 */
switch($action) {
    case 'newProdRow':
        $inv_obj->newProdRow();
        break;
    case 'showClient':
        $inv_obj->showClient();
        break;
    case 'getPriceQty':
        $inv_obj->getPriceQty();
        break;
    case 'prepareOrder':
        $inv_obj->prepareOrder();
        break;
    default:
        return;
}

// Class InvoiceOperations (Manages invoices)
class InvoiceOperations {

    protected $conn;
    public $m;

    // Constructor function
    function __construct() {

        // Create instance of class Connection
        $db = new Connection();
        $this->conn = $db->getConnstring();

        // Create instance of class Manage
        $this->m = new Manage();
    }


    /**
     * 1. If get_product_row was posted,
     * 2. Call getAllData method with parameter 'product' & store the data retrieved in $rows.
     * 3. If $rows is not 0, then use HTML code to create the <tr> elements and their content.
     *    $rows is used to create <option> elements for name of products.
     */
    function newProdRow() {

        if (isset($_POST['get_product_row'])) {
            $rows = $this->m->getAllData('product');
            if ($rows !== 0){
                ?>
                <tr>
                    <td>
                        <label for='check-row' hidden></label>
                        <input name='check-row' id='check-row' type='checkbox'>
                    </td>

                    <td style='text-align:center;'><b class='number'>1</b></td>

                    <td class='form-group'>
                        <label for='prod-id' hidden>Product</label>
                        <select name= 'prod-id[]' id='prod-id' class='form-control form-control-sm prod-id'>
                            <option value=''>Choose a Product</option>
                            <?php
                            foreach ($rows as $row) {
                                ?><option value='<?php echo $row['id']; ?>'><?php echo $row['product_name']; ?></option><?php
                            }
                            ?>
                        </select>
                        <span class='help-block' id='error'></span>
                    </td>

                    <td>
                        <label for='prod-tqty' hidden>Quantity in Stock</label>
                        <input name='prod-tqty[]' id='prod-tqty' readonly type='text' class='form-control form-control-sm tqty'>
                    </td>

                    <td>
                        <label for='prod-unit' hidden>Unit</label>
                        <input name='prod-unit[]' id='prod-unit' readonly type='text' class='form-control form-control-sm unit'>
                    </td>

                    <td class='form-group'>
                        <label for='prod-qty' hidden>Quantity</label>
                        <input name='prod-qty[]' id='prod-qty'  type='text' class='form-control form-control-sm qty' disabled>
                        <span class='help-block' id='error'></span>
                    </td>

                    <td>
                        <label for='prod-price' hidden>Price</label>
                        <input  name='prod-price[]' id='prod-price' type='text' class='form-control form-control-sm price' readonly>
                    </td>

                    <td style='display: none;'>
                        <label for='prod-name' hidden>Product Name</label>
                        <input name='prod-name[]' id='prod-name' class='form-control form-control-sm pro-name'>
                    </td>

                    <td class='form-group'>$<span class='amt form-group' id='amt-id'>0</span>USD</td>
                </tr>
                <?php
            }
            exit();
        }
    }


    /**
     * 1. If get_new_client was posted,
     * 2. Call getAllData method with parameter 'client' & store the data retrieved in $rows.
     * 3. If $rows is not 0, then use HTML code to create the <option> elements and their content.
     *    $rows is used to set value attribute to <option> elements.
     */
    function showClient() {

        if (isset($_POST['get_new_client'])) {
            $rows = $this->m->getAllData('client');
            if($rows !==0){
                ?>
                <option value=''>Choose a client</option>
                <?php
                foreach ($rows as $row) {
                    ?><option value='<?php echo $row['client_name']; ?>'><?php echo $row['client_name']; ?></option><?php
                }
            }
            exit();
        }
    }


    /**
     * 1. If get_price_qty was posted,
     * 2. Call getSingleRecord method with parameters 'product', 'id' & the id posted,
     *    store the data retrieved in $result.
     * 3. Convert & return $result into JSON
     */
    function getPriceQty(){

        if (isset($_POST['get_price_qty'])) {
            $result = $this->m->getSingleRecord('product','id',$_POST['id']);
            echo json_encode($result);
            exit();
        }
    }

    /**
     * 1. If order-date & cust-name were posted,
     * 2. Create variable for every data posted.
     * 3. Call storeCustomerInvoice method with respective parameters,
     *    stores the retrieved data in $result & return it.
     */
    function prepareOrder(){

        if (isset($_POST['order-date']) AND isset($_POST['cust-name'])) {

            $orderdate = $_POST['order-date'];
            $cust_name = $_POST['cust-name'];
            $ar_tqty = $_POST['prod-tqty'];
            $ar_qty = $_POST['prod-qty'];
            $ar_price = $_POST['prod-price'];
            $ar_pro_name = $_POST['prod-name'];
            $sub_total = $_POST['sub-total'];
            $taxes = $_POST['taxes'];
            $discount = $_POST['discount'];
            $net_total = $_POST['net-total'];
            $paid = $_POST['paid'];
            $due = $_POST['due'];
            $payment_type = $_POST['payment-type'];

            echo $result = $this->m->storeOrderInvoice($orderdate,$cust_name,$ar_tqty,$ar_qty,$ar_price,$ar_pro_name,$sub_total,$taxes,$discount,$net_total,$paid,$due,$payment_type);
        }
    }
}
?>