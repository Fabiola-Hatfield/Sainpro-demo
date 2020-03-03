<?php

// Class Connection (Connection to database)
Class Connection{

	var $db_host = "localhost";
	var $db_user = "root";
	var $db_password = "";
	var $db_name = "sainpro";
	var $conn;

    /**
     * Creates & check connection
     * @return mysqli
     */
	function getConnString() {

		$con = mysqli_connect($this->db_host, $this->db_user, $this->db_password, $this->db_name) or die("Connection to MySQL failed.");

		if (mysqli_connect_errno()) {
			die("Failed to connect to MySQL.");
		} else {
			$this->conn = $con;
		}
		return $this->conn;
	}
}
