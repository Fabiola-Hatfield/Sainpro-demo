<?php

class Manage
{

    private $conn;

    // Constructor function
    function __construct()
    {
        // Create instance of class Connection
        $db_obj = new Connection();
        $this->conn = $db_obj->getConnString();
    }

    /**
     * 1. Define empty variable "$stmt".
     * 2. Prepare SQL statement template depending on $table & send it,
     *    store it in $stmt.
     * 3. Bind the parameters to the SQL statement.
     * 4. Try to execute the statement.
     * 5. Store the result set from the prepared statement query in $result.
     * 6. Create an array $rows.
     * 7. If num_rows in $result is greater than 0,
     *    While a row of data exists, put that row in $row as an associative array,
     *    stores $row in array $rows.
     * 8. Return $rows.
     * @param $table - The database selected table
     * @param $query - The word to search
     * @return array
     */
    public function getData($table, $query)
    {
        $stmt = '';
        switch ($table){
            case "product":
                $stmt = $this->conn->prepare("SELECT * FROM " . $table . " WHERE product_name LIKE CONCAT('%',?,'%') OR entry_date LIKE CONCAT('%',?,'%') OR unit LIKE CONCAT('%',?,'%')");
                $stmt->bind_param('sss', $query, $query, $query);
                break;
            case "user":
                $stmt = $this->conn->prepare("SELECT * FROM " . $table . " WHERE user_name LIKE CONCAT('%',?,'%') OR user_email LIKE CONCAT('%',?,'%') OR user_type LIKE CONCAT('%',?,'%') OR register_date LIKE CONCAT('%',?,'%')");
                $stmt->bind_param('ssss', $query, $query, $query, $query);
                break;
            case "client":
                $stmt = $this->conn->prepare("SELECT * FROM " . $table . " WHERE client_name LIKE CONCAT('%',?,'%') OR client_email LIKE CONCAT('%',?,'%') OR client_address LIKE CONCAT('%',?,'%')");
                $stmt->bind_param('sss', $query, $query, $query);
                break;
            case "invoice":
                $stmt = $this->conn->prepare("SELECT * FROM " . $table . " WHERE client_name LIKE CONCAT('%',?,'%')");
                $stmt->bind_param('s', $query);
                break;
        }
        $stmt->execute() or die($this->conn->error);
        $result = $stmt->get_result();
        $rows = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
        }
        return $rows;
    }


    /**
     * 1. Prepare SQL statement template to select all records from selected table depending on the parameter received.
     *    store it in $stmt.
     * 2. Try to execute the statement.
     * 3. Store the result set from the prepared statement query in $result.
     * 4. Create an array $rows.
     * 5. If num_rows in $result is greater than 0,
     *    While a row of data exists, put that row in $row as an associative array,
     *    stores $row in array $rows.
     *    Return $rows (inside if)
     * 6. Return 0
     * @param $table - The database selected table
     * @param $column - The column to search for invoice information
     * @return array|int
     */
    public function getAllData($table, $column = null)
    {
        if($column){
            $stmt = $this->conn->prepare("SELECT * FROM " . $table . " WHERE " . "invoice_no" . " = ". $column);
        }else{
            $stmt = $this->conn->prepare("SELECT * FROM " . $table);
        }
        $stmt->execute() or die($this->conn->error);
        $result = $stmt->get_result();
        $rows = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
            return $rows;
        }
        return 0;
    }


    /**
     * 1. Prepare SQL statement template to delete record with corresponding primary key
     *    from selected table & store it in $stmt.
     * 2. Bind the parameters to the SQL query.
     * 3. Try to execute the statement & store result in $result.
     * 4. If $result is true,
     *    return "1" ($stmt was executed)
     * 5. If $result is not true,
     *    return "0" ($stmt was not executed).
     * @param $table - The table to which the record to be deleted belongs
     * @param $pk - The first part of condition
     * @param $id - The second part of the condition
     * @return int
     */
    public function deleteRecord($table, $pk, $id)
    {
        $stmt = $this->conn->prepare("DELETE FROM " . $table . " WHERE " . $pk . " = ?");
        $stmt->bind_param("i", $id);
        $result = $stmt->execute() or die($this->conn->error);
        if ($result) {
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * 1. Prepare SQL statement template to select all data of record with corresponding primary key
     *    from selected table & store it in $stmt.
     * 2. Bind the parameter to the SQL query.
     * 3. Try to execute the statement.
     * 4. Store the result set from the prepared statement query in $result.
     * 5. Create an empty variable $row.
     * 6. If num_rows in $result equals to 1,
     *    fetch result as an associative array and store it in $row.
     * 7. Return $row
     * @param $table - The table to which the record to belongs
     * @param $pk - The first part of condition
     * @param $id - The second part of condition
     * @return array|string|null
     */
    public function getSingleRecord($table, $pk, $id) {
        $stmt = $this->conn->prepare("SELECT * FROM " . $table . " WHERE " . $pk . "= ? " . "LIMIT 1");
        $stmt->bind_param("i", $id);
        $stmt->execute() or die($this->conn->error);
        $result = $stmt->get_result();
        $row = "";
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
        }
        return $row;
    }


    /**
     * 1. Create empty variables "sql" & "condition"
     * 2. Loop through associative array $where to create condition
     * 3. Extract 5 last characters of $condition (AND )
     * 4. Loop through associative array $fields to create structure [column1 = value1, column2 = value2,]
     * 5. Extract 2 last characters of $condition (, )
     * 6. Prepare sql statement template to update selected table and execute statement.
     * 7. If statement was executed, return "1".
     * @param $table
     * @param $where
     * @param $fields
     * @return int|string
     */
    public function UpdateRecord($table, $where, $fields)
    {

        $column_value = "";
        $condition = "";
        foreach ($where as $key => $value) {

            $condition .= $key . "='" . $value . "' AND ";   // id="5" AND '
        }

        $condition = substr($condition, 0, -5); // id="5"

        foreach ($fields as $key => $value) {

            $column_value .= $key . "='" . $value . "', ";            // m_name="example", qty="5", ;
        }

        $column_value = substr($column_value, 0, -2);            // m_name="example", qty="5";

        $stmt = $this->conn->prepare("UPDATE " . $table . " SET " . $column_value . " WHERE " . $condition);
        $result = $stmt->execute() or die($this->conn->error);
        if ($result) {
            return "1";
        }
        return 0;
    }


    /**
     * Return TRUE if the number of elements in $array is not equal
     * to the number of elements after removing duplicates
     * @param $array - The array to be checked
     * @return bool
     */
    function findDuplicates($array)
    {
        return count($array) !== count(array_unique($array));
    }

    /**
     * 1. If method findDuplicates returns TRUE, then return -1.
     * 2. If method findDuplicates return false, then
     *    Prepare SQL statement template to insert data into selected table & store it in $stmt.
     * 2. Bind the parameters to the SQL statement & try to execute it.
     * 4. Store the auto generated id used in the query.
     * 5. If the auto generated id is not null then,
     *      Loop through the products to find the remaining quantity of product before placing order.
     *         If the remaining is less than 0, then returns 0.
     *         If the remaining is 0, update status column to 0 (unavailable).
     *    Prepare, bind and execute sql statement to update quantity column.
     *    Prepare, bind and execute sql statement to insert data into invoice_details table.
     *    Return auto generated id
     * @param $orderdate - The order date
     * @param $cust_name - The customer name
     * @param $ar_tqty - The array with quantity of product in stock
     * @param $ar_qty - The array with quantity of requested products
     * @param $ar_price - The array with price of products
     * @param $ar_pro_name - The array with product names
     * @param $sub_total - The sub total amount
     * @param $taxes - The taxes amount
     * @param $discount - The discount amount
     * @param $net_total - The new_total amount
     * @param $paid - The paid amount
     * @param $due - The due amount
     * @param $payment_type - The payment tyoe
     * @return int
     */

    public function storeOrderInvoice($orderdate, $cust_name, $ar_tqty, $ar_qty, $ar_price, $ar_pro_name, $sub_total, $taxes, $discount, $net_total, $paid, $due, $payment_type)
    {

        if ($this->findDuplicates($ar_pro_name)) {
            return -1;
        } else {

            $stmt = $this->conn->prepare("INSERT INTO 
			`invoice`(`client_name`, `order_date`, `sub_total`,
			 `taxes`, `discount`, `net_total`, `paid`, `due`, `payment_type`) VALUES (?,?,?,?,?,?,?,?,?)");

            $stmt->bind_param("ssdddddds", $cust_name, $orderdate, $sub_total, $taxes, $discount, $net_total, $paid, $due, $payment_type);
            $stmt->execute() or die($this->conn->error);

            $invoice_no = $stmt->insert_id;

            if ($invoice_no != null) {

                for ($i = 0; $i < count($ar_price); $i++) {

                    $rem_qty = $ar_tqty[$i] - $ar_qty[$i];

                    if ($rem_qty < 0) {
                        return 0;

                    } else if ($rem_qty == 0) {

                        $stmt = $this->conn->prepare("UPDATE product SET status = 0 WHERE product_name = ?");
                        $stmt->bind_param("s", $ar_pro_name[$i]);
                        $stmt->execute() or die($this->conn->error);
                    }

                    $stmt = $this->conn->prepare("UPDATE product SET quantity = '$rem_qty' WHERE product_name = ?");
                    $stmt->bind_param("s", $ar_pro_name[$i]);
                    $stmt->execute() or die($this->conn->error);

                    $stmt = $this->conn->prepare("INSERT INTO `invoice_details`(`invoice_no`, `product_name`, `price`, `qty`) 
                                                            VALUES ('" . $invoice_no . "','" . $ar_pro_name[$i] . "','" . $ar_price[$i] . "','" . $ar_qty[$i] . "');");
                    $stmt->execute() or die($this->conn->error);
                }
                return $invoice_no;
            } else {
                return $ar_pro_name;
            }
        }
    }
}

?>
	