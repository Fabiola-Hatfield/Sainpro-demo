<?php
require_once('../database/connection.php');
session_start();

$params = $_REQUEST;
$action = $params['action'] != '' ? $params['action'] : '';

// Creates instance of Session class
$session_obj = new Session();


/**
 * Call the corresponding method depending on the value of variable $action
 */
switch ($action) {
    case 'logIn':
        $session_obj->logIn();
        break;
    case 'logOut':
        $session_obj->logOut();
        break;
    default:
        return;
}

//Class Session (Manage session actions)
class Session {
    protected $conn;

    // Constructor function
    function __construct() {

        // Create instance of class Connection
        $db_obj = new Connection();
        $this->conn = $db_obj->getConnString();
    }

    /**
     * 1. If login-submit was posted,
     *    store posted email & password in variables.
     * 2. Prepare, bind and execute sql statement to select data from table user
     *    where user_email equals to the email posted.
     *    Store the result set from the prepared statement query in $result.
     * 3. If num_rows in $result is lower than 1; means the user is not registered yet.
     *    Otherwise, fetch $result as an associative array and store it in $row.
     *    Store password given by $row in variable $password_hash. (Password is encrypted).
     *    If function the function password_verify
     *    (used to verify that the password posted matches the hash),
     *     set the current date to $last_log variable.
     *     Prepare, bind and execute sql statement template to update user last_login column
     *     If $result was executed, then create array with user information
     *     & set session variables 'user' & 'last_activity'.
     * @return string
     */
    function logIn() {
        if (isset($_POST['login-submit'])) {

            $user_email = $_POST['email'];
            $user_password = $_POST['password'];
            $stmt = $this->conn->prepare("SELECT * FROM user WHERE user_email = ?");
            $stmt->bind_param('s', $user_email);
            $stmt->execute() or die($this->conn->error);
            $result = $stmt->get_result();
            if ($result->num_rows < 1) {
                echo 'User not registered.';
            } else {
                $row = $result->fetch_assoc();
                $password_hash = $row['password'];
                if (password_verify($user_password, $password_hash)) {
                    // Session starts
                    $user = array('user_id' => $row['id'],'user_name' => $row['user_name'], 'user_email' => $user_email, 'last_login' => $row['last_login'], 'user_type' => $row['user_type']);
                    $_SESSION['user'] = $user;
                    $_SESSION['last_activity'] = time();

                    echo '1';
                    //Last login time is updated


                    date_default_timezone_set('America/Mexico_City');
                    $last_login = date('Y-m-d H:i:s');

                    $stmt = $this->conn->prepare('UPDATE user SET last_login = ? WHERE user_email = ?');
                    $stmt->bind_param('ss', $last_login, $user_email);
                    $result = $stmt->execute() or die($this->conn->error);
                    if (!$result) {
                        echo  'Something went wrong';
                    }
                } else {
                    echo 'Password is not correct. Please, try again.';
                }
                exit();
            }
        }
        return 'Something went wrong';
    }

    /**
     * Free all session variables
     * If session is destroyed, redirect to login page.
     */
    function logOut() {
        unset($_SESSION['user'],$_SESSION['last_activity']);
        if (session_destroy()) {
            header('location: http://localhost/sainprohost/public_html/index.php');
        }
        exit();
    }
}