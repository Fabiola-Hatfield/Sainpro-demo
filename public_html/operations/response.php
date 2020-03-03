<?php
require_once("../database/connection.php");
include_once("manage.php");


$params = $_REQUEST;
$action = $params["action"] != "" ? $params["action"] : "";

// Creates instance of DBOperation class
$db_ope_obj = new DBOperation();

/**
 * Call the corresponding method depending on the value of variable $action
 */
switch ($action) {
    case "prepToDel":
        $db_ope_obj->prepToDel();
        break;
    case "prepareSingleRecord":
        $db_ope_obj->prepareSingleRecord();
        break;
    case "prepToReadRecords":
        $db_ope_obj->prepToReadRecords();
        break;
    case "prepareToSearch":
        $db_ope_obj->prepareToSearch();
        break;
    case "addUser":
        $db_ope_obj->addUser();
        break;
    case "updateUser":
        $db_ope_obj->updateUser();
        break;
    case "addClient":
        $db_ope_obj->addClient();
        break;
    case "updateClient":
        $db_ope_obj->updateClient();
        break;
    case "addProduct":
        $db_ope_obj->addProduct();
        break;
    case "updateProduct":
        $db_ope_obj->updateProduct();
        break;
    case "updateProfile":
        $db_ope_obj->updateProfile();
        break;
    default:
        return;
}

/**
 * Function to prevent SQL Injection
 * @param $data
 * @return string
 */
function TestInput($data)
{
    $data = trim($data); // Strip unnecessary characters (extra space, tab, newline)
    $data = stripslashes($data); // Remove backslashes (\) from the user input data
    $data = htmlspecialchars($data); // Convert special characters to HTML entities
    return $data;
}


// Class DBOperation
class DBOperation
{

    protected $conn;
    protected $m;

    // Constructor function
    function __construct()
    {
        $db = new Connection();
        $this->conn = $db->getConnstring();

        // Create instance of class Manage
        $this->m = new Manage();

    }


    /**
     * 1. If delete was posted,
     * 2. Stores "id" & "table" posted in variables.
     * 3. Call deleteRecord method with respective parameters,
     * 4. echo $result.
     */
    function prepToDel()
    {
        if (isset($_POST["delete"])) {
            $id = $_POST["id"];
            $table = $_POST["table"];
            $result = $this->m->deleteRecord($table, "id", $id);
            echo $result;
        }
    }


    /**
     * 1. If show_data was posted,
     * 2. Stores "id" & "table" posted in variables.
     * 3. Call getSingleRecord method with respective parameters,
     *    convert & stores the retrieved data in $result, echo $result.
     */
    function prepareSingleRecord()
    {
        if (isset($_POST["show_data"])) {
            $eid = $_POST["id"];
            $table = $_POST["table"];
            $result = $this->m->getSingleRecord($table, "id", $eid);
            echo json_encode($result);
            exit();
        }
    }

    /**
     * 1. If read-records was posted,
     * 2. Call getAllData method with the posted table as parameter,
     *    store the result in $rows.
     * 3. If $rows is not 0, then call method createTableRow
     *    with the table posted & $rows as parameters.
     */
    function prepToReadRecords()
    {
        if (isset($_POST["read-records"])) {
            $invoice_no = $_POST["invoice-no"];
            $table = $_POST["table"];
            $rows = $this->m->getAllData($table, $invoice_no);
            if ($rows !== 0) {
                $this->createTableRow($table, $rows);
                ?>
                <?php
                exit();
            }
        }
    }

    function invoice()
    {
        if (isset($_POST["show_data"])) {
            $eid = $_POST["invoice-no"];
            $table = $_POST["table"];
            $result = $this->m->getData($table, $eid);
            if (count($result) > 0) {
                $this->createTableRow($table, $result);
                exit();
            }
        }
    }


    /**
     * 1. If query was posted,
     * 2. Call TestInput function with the posted query as parameter,
     *    & store the result in $word.
     * 3. Escapes special characters in $word
     * 4. Call method getData with the posted table and $word as parameters
     *    & store the result in $result.
     * 5. If the number of elements in $result is greater than 0,
     *     call method createTableRow with the posted table and $result as parameters.
     * 6. If the number of elements in $result is not greater than 0,
     *     means there is no data matching the $word.
     * 7. If query was not posted, call method prepToReadRecords.
     */
    function prepareToSearch()
    {
        if (isset($_POST["query"])) {
            $table = $_POST["table"];
            $word = TestInput($_POST["query"]);
            $word = mysqli_real_escape_string($this->conn, $word);
            $result = $this->m->getData($table, $word);
            if (count($result) > 0) {
                $this->createTableRow($table, $result);
                exit();
            } else {
                echo "NO DATA TO SHOW";
            }
        } else {
            $this->prepToReadRecords();
        }
        exit();
    }


    /**
     * HTML code to create <tr> elements depending on the value of $table
     * @param $table - The table to which the row to be created belongs
     * @param $rows - Array with the necessary data from database.
     */
    function createTableRow($table, $rows)
    {
        $n = 1;
        switch ($table) {
            case "user":
                foreach ($rows as $row) {
                    ?>
                    <tr>
                        <td><?php echo $n; ?></td>
                        <td><?php echo $row["user_name"]; ?></td>
                        <td><?php echo $row["user_email"]; ?></td>
                        <td><?php echo $row["register_date"]; ?></td>
                        <td><?php echo $row["last_login"]; ?></td>
                        <td><?php echo $row["user_type"]; ?></td>
                        <td>
                            <i class="fas fa-edit edit-user edit-icon" title="Edit" data-toggle="modal"
                               data-target="#updusr-form"
                               edit-id="<?php echo $row["id"]; ?>"></i>
                            <i class="fas fa-trash del-user del-icon" title="Delete" data-toggle="tooltip"
                               data-deleteid="<?php echo $row["id"]; ?>"></i>
                        </td>
                    </tr>
                    <?php
                    $n++;
                }
                break;
            case "client":
                foreach ($rows as $row) {
                    ?>
                    <tr>
                        <td><?php echo $n; ?></td>
                        <td><?php echo $row["client_name"]; ?></td>
                        <td><?php echo $row["client_phone"]; ?></td>
                        <td><?php echo $row["client_address"]; ?></td>
                        <td><?php echo $row["client_email"]; ?></td>
                        <td align="center">
                            <i class="fas fa-edit edit-client edit-icon" title="Edit" data-toggle="modal"
                               data-target="#updclient-form" edit-id="<?php echo $row["id"]; ?>"></i>
                            <i class="fas fa-trash del-client del-icon" title="Delete" data-toggle="tooltip"
                               data-deleteid="<?php echo $row["id"]; ?>"></i>
                        </td>
                    </tr>
                    <?php
                    $n++;
                }
                break;
            case "product":
                foreach ($rows as $row) {
                    ?>
                    <tr>
                        <td><?php echo $n; ?></td>
                        <td><?php echo $row["product_name"]; ?></td>
                        <td><?php echo $row["entry_date"]; ?></td>
                        <td><?php echo $row["entry_price"]; ?></td>
                        <td><?php echo $row["sell_price"]; ?></td>
                        <td><?php echo $row["quantity"]; ?></td>
                        <td><?php echo $row["unit"]; ?></td>
                        <td><?php echo $row["description"]; ?> </td>
                        <?php
                        if ($row["status"] == 1) {
                            ?>
                            <td><i class="fas fa-check-circle available" title="Status"></i></td>
                            <?php

                        } else {
                            ?>
                            <td><i class="fas fa-check-circle unavailable" title="Status"></i></td>
                            <?php
                        }
                        ?>

                        <td>
                            <i class="fas fa-edit edit-product edit-icon" title="Edit" data-toggle="modal"
                               data-target="#eform-product" edit-id="<?php echo $row["id"]; ?>"></i>
                            <i class="fas fa-trash del-product del-icon" title="Delete" data-toggle="tooltip"
                               data-deleteid="<?php echo $row["id"]; ?>"></i>
                        </td>
                    </tr>
                    <?php
                    $n++;
                }
                break;
            case "invoice":
                foreach ($rows as $row) {
                    ?>
                    <tr>
                        <td><?php echo $n; ?></td>
                        <td><?php echo $row["client_name"]; ?></td>
                        <td><?php echo $row["order_date"]; ?></td>
                        <td><?php echo $row["net_total"]; ?></td>
                        <td><?php echo $row["paid"]; ?></td>
                        <td>
                            <i class="fas fa-eye show-more edit-icon" title="Show more data"
                               show-id="<?php echo $row["invoice_no"]; ?>"></i>
                        </td>
                    </tr>
                    <?php
                    $n++;
                }
                break;
            case "invoice_details":
                foreach ($rows as $row) {
                    ?>
                    <tr>
                        <td><?php echo $n; ?></td>
                        <td><?php echo $row["product_name"]; ?></td>
                        <td><?php echo $row["price"]; ?></td>
                        <td><?php echo $row["qty"]; ?></td>
                    </tr>
                    <?php
                    $n++;
                }
                break;

        }

    }


    /**
     * 1. Prepare SQL statement template to select data of selected user & send it,
     *    store it in $stmt.
     * 3. Bind the parameters to the SQL statement.
     * 4. Try to execute the statement.
     * 5. Store the result set from the prepared statement query in $result.
     * 6. If num_rows in $result is 1, means there is a user with same email;
     *    return 1
     *    If not, return 0.
     * @param $user_email - The email posted
     * @param $uid - The id of user to be updated
     * @return int
     */
    private function checkEmailUpdate($user_email, $uid)
    {
        $stmt = $this->conn->prepare("SELECT * FROM user WHERE user_email=? AND id!=?");
        $stmt->bind_param("si", $user_email, $uid);
        $stmt->execute() or die($this->conn->error);
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * 1. Prepare SQL statement template to select data of selected user & send it,
     *    store it in $stmt.
     * 3. Bind the parameters to the SQL statement.
     * 4. Try to execute the statement.
     * 5. Store the result set from the prepared statement query in $result.
     * 6. If num_rows in $result is greater than 0, means user already exists
     *    return 1
     *    If not, return 0.
     * @param $user_email - The email posted
     * @return int
     */
    private function checkEmail($user_email)
    {
        $stmt = $this->conn->prepare("SELECT * FROM user WHERE user_email = ?");
        $stmt->bind_param("s", $user_email);
        $stmt->execute() or die($this->conn->error);
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return 1;
        } else {
            return 0;
        }
    }

//----------------------------------MANAGE USER-------------------------------------------------------

    /**
     * 1. If add-user-btn was posted,
     *      Store posted email in $user_email.
     *      If method checkEmail returns 1, means there is a user with same email.
     *      If checkEmail does not return 1 then,
     *          store posted data in respective variables.
     *          Use password_hash() to encrypt the password.
     *          Prepare, bind and try to execute sql statement to inster data into user table.
     *          If $result is true ($stmt was executed) then, echo "1";
     * @param $user_email - The email posted
     * @param $uid - The id of user to be updated
     * @return int
     */
    function addUser()
    {
        if (isset($_POST["add-user-btn"])) {
            $user_email = $_POST["email"];
            if ($this->checkEmail($user_email)) {
                echo "User with same email already exists. Please, try again";
            } else {
                $user_name = $_POST["name"];
                $user_password = $_POST["cpassword"];
                $hashed_password = password_hash($user_password, PASSWORD_BCRYPT);
                $user_type = $_POST["user-type"];
                date_default_timezone_set("America/Mexico_City");
                $date = date("Y-m-d H:i:s");
                $last_log = null;
                $stmt = $this->conn->prepare("INSERT INTO `user` (`user_name`, `user_email`, `password`, `register_date`, `last_login`, `user_type`) VALUES
					(?,?,?,?,?,?)");
                $stmt->bind_param("ssssss", $user_name, $user_email, $hashed_password, $date, $last_log, $user_type);
                $result = $stmt->execute() or die($this->conn->error);
                if ($result) {
                    echo "1";
                } else {
                    echo "Something went wrong";
                }
            }
            exit();
        }
    }


    /**
     * 1. If upd-user-btn was posted,
     *      Store posted email and id in variables.
     *      If method checkEmail returns 1, means there is a user with same email.
     *      If checkEmail does not return 1 then,
     *          store rest of posted data in respective variables.
     *          Call method UpdateRecord with respective parameters,
     *          store the result in $result.
     *          echo $result;
     */
    function updateUser()
    {
        if (isset($_POST["upd-user-btn"])) {
            $eu_email = $_POST["eu-email"];
            $eu_id = $_POST["eu-id"];
            if ($this->checkEmailUpdate($eu_email, $eu_id)) {
                echo "User with same email already exists. Please, try again";
            } else {
                $eu_name = $_POST["eu-name"];
                $eureg_date = $_POST["eureg-date"];
                $eu_user_type = $_POST["euuser-type"];
                $result = $this->m->UpdateRecord("user", ["id" => $eu_id], ["user_name" => $eu_name, "user_email" => $eu_email, "register_date" => $eureg_date, "user_type" => $eu_user_type]);
                echo $result;
            }
        }
    }


//----------------------------------MANAGE CLIENT----------------------

    private function CheckClientUpdate($client_name, $client_phone, $cid)
    {
        $stmt = $this->conn->prepare("SELECT * FROM client WHERE client_name=? AND client_phone=? AND id!=?");
        $stmt->bind_param("ssi", $client_name, $client_phone, $cid);
        $stmt->execute() or die($this->conn->error);
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            return 1;
        } else {
            return 0;
        }
    }

    // Check if the client exists before adding a new one
    private function CheckClient($client_name, $client_phone)
    {
        $stmt = $this->conn->prepare("SELECT * FROM client WHERE client_name=? AND client_phone =?");
        $stmt->bind_param("ss", $client_name, $client_phone);
        $stmt->execute() or die($this->conn->error);
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    // Add Client
    function addClient()
    {
        if (isset($_POST["add-client-btn"])) {
            $client_name = $_POST["client-name"];
            $client_phone = $_POST["phone"];
            if ($this->CheckClient($client_name, $client_phone)) {
                echo "Client already exists. Please, try again.";
            } else {
                $client_address = $_POST["address"];
                $client_email = $_POST["client-email"];
                $stmt = $this->conn->prepare("INSERT INTO `client` (`client_name`,`client_phone`,`client_address`, `client_email`) VALUES
                (?,?,?,?)");
                $stmt->bind_param("ssss", $client_name, $client_phone, $client_address, $client_email);
                $result = $stmt->execute() or die($this->conn->error);
                if ($result) {
                    echo "1";
                } else {
                    echo "Something went wrong!";
                }
            }
            exit();
        }
    }

    // Update Client
    function updateClient()
    {
        if (isset($_POST["upd-client-btn"])) {
            $ecid = $_POST["ec-id"];
            $ecname = TestInput($_POST["ec-name"]);
            $ecphone = TestInput($_POST["ec-phone"]);
            $ecname = mysqli_real_escape_string($this->conn, $ecname);
            $ecphone = mysqli_real_escape_string($this->conn, $ecphone);
            if ($this->CheckClientUpdate($ecname, $ecphone, $ecid)) {
                echo "Client already exists. Please, try again.";
            } else {
                $ecaddress = TestInput($_POST["ec-address"]);
                $ecemail = TestInput($_POST["ec-email"]);
                $ecaddress = mysqli_real_escape_string($this->conn, $ecaddress);
                $ecemail = mysqli_real_escape_string($this->conn, $ecemail);
                $result = $this->m->UpdateRecord("client", ["id" => $ecid], ["client_name" => $ecname, "client_phone" => $ecphone, "client_address" => $ecaddress, "client_email" => $ecemail]);
                echo $result;
            }
        }
    }


//----------------------------------MANAGE PRODUCTS----------------------

    // Check if the product exists before updating the table
    private function checkProductUpdate($prod_name, $pid)
    {
        $stmt = $this->conn->prepare("SELECT * FROM product WHERE product_name=? AND id!=?");
        $stmt->bind_param("si", $prod_name, $pid);
        $stmt->execute() or die($this->conn->error);
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            return 1;
        } else {
            return 0;
        }
    }

    // Check if the product exists before adding a new one
    private function checkProduct($prod_name)
    {
        $stmt = $this->conn->prepare("SELECT * FROM product WHERE product_name = ?");
        $stmt->bind_param("s", $prod_name);
        $stmt->execute() or die($this->conn->error);
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    // Add product
    function addProduct()
    {

        if (isset($_POST["add-prod-btn"])) {
            $product_name = $_POST["product-name"];
            if ($this->checkProduct($product_name)) {
                echo "This product already exists! Please, try again.";
            } else {
                $description = $_POST["description"];
                $entry_price = $_POST["entry-price"];
                $sell_price = $_POST["sell-price"];
                $quantity = $_POST["quantity"];
                $unit = $_POST["unit"];
                $entry_date = $_POST["entry_date"];
                $status = 1;
                $stmt = $this->conn->prepare("INSERT INTO `product`(`product_name`, `entry_date`, `description`, `entry_price`, `sell_price`, `quantity`, `unit`, `status`) VALUES
					(?,?,?,?,?,?,?,?)");
                $stmt->bind_param("sssdddsi", $product_name, $entry_date, $description, $entry_price, $sell_price, $quantity, $unit, $status);
                $result = $stmt->execute() or die($this->conn->error);
                if ($result) {
                    echo "1";
                } else {
                    echo "Something went wrong!";
                }
            }
            exit();
        }
    }

    // updateProduct
    function updateProduct()
    {
        if (isset($_POST["upd-prod-btn"])) {
            $eproduct_name = $_POST["eprod-name"];
            $epid = $_POST["epid"];
            if ($this->checkProductUpdate($eproduct_name, $epid)) {
                echo "Product already exists. Please, try again.";
            } else {
                $eentry_date = $_POST["eentry-date"];
                $edescription = TestInput($_POST["edescription"]);
                $eentry_price = TestInput($_POST["eentry-price"]);
                $esell_price = TestInput($_POST["esell-price"]);
                $equantity = TestInput($_POST["equantity"]);
                $eunit = TestInput($_POST["eunit"]);
                $edescription = mysqli_real_escape_string($this->conn, $edescription);
                $eentry_price = mysqli_real_escape_string($this->conn, $eentry_price);
                $esell_price = mysqli_real_escape_string($this->conn, $esell_price);
                $equantity = mysqli_real_escape_string($this->conn, $equantity);
                $eunit = mysqli_real_escape_string($this->conn, $eunit);
                $status = 1;
                $result = $this->m->UpdateRecord("product", ["id" => $epid], ["product_name" => $eproduct_name, "entry_date" => $eentry_date, "description" => $edescription, "entry_price" => $eentry_price, "sell_price" => $esell_price, "quantity" => $equantity, "unit" => $eunit, "status" => $status]);
                echo $result;
            }
        }
    }

//----------------------------------MANAGE PROFILE----------------------		

    // Update profile
    function updateProfile()
    {
        if (isset($_POST["upd-prof-btn"])) {
            $proemail = $_POST["prof-email"];
            $myid = $_POST["myid"];
            if ($this->checkEmailUpdate($proemail, $myid)) {
                echo "User with this email already exists. Please, try again.";
            } else {
                $proname = TestInput($_POST["prof-name"]);
                $procpassword = TestInput($_POST["prof-cpassword"]);
                $proreg_date = TestInput($_POST["prof-reg-date"]);
                $prouser_type = TestInput($_POST["prof-user-type"]);
                $proname = mysqli_real_escape_string($this->conn, $proname);
                $procpassword = mysqli_real_escape_string($this->conn, $procpassword);
                $hashed_propass = password_hash($procpassword, PASSWORD_BCRYPT);
                $proreg_date = mysqli_real_escape_string($this->conn, $proreg_date);
                date_default_timezone_set("America/Mexico_City");
                $date = date("Y-m-d H:i:s");
                $prouser_type = mysqli_real_escape_string($this->conn, $prouser_type);
                $m = new Manage();
                $result = $m->UpdateRecord("user", ["id" => $myid], ["user_name" => $proname, "user_email" => $proemail, "password" => $hashed_propass, "register_date" => $proreg_date, "last_login" => $date, "user_type" => $prouser_type]);
                echo $result;
            }
        }
    }
}

?>