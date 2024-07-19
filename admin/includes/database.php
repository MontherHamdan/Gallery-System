<?php
require_once("new_config.php");
class Database
{

    public $connection;
    public $db;

    //this fuction to execute the connection automatically so no need to call function open_db_conn()
    public function __construct()
    {
        //call open database function
        $this->db = $this->open_db_conn();
    }

    //this function is to open database
    public function open_db_conn()
    {
        //new way to conncet with database make object from ready class call (mysqli)
        $this->connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if ($this->connection->connect_errno) {
            die("Database connection faild " . $this->connection->connect_errno);
        }
        return $this->connection;
    }

    //function for do queries
    public function query($sql)
    {
        //query method take one parameter the parameter is query
        $result = $this->db->query($sql);
        $this->confirm_query($result);
        return $result;
    }

    //make helper function 
    //this function (confirm) to check on result from query
    // will be private because we will not use out the class
    private function confirm_query($result)
    {
        if (!$result) {
            die("query faild " . $this->db->error);
        }
        //echo"success";
    }

    //this also helper to escape string 
    public function escape_string($string)
    {
        //this function put backslash(\) with the string have qutes(') or something will affect on the sql query
        //example: $unsafe_string="john's book" after the method applied => $safe_string="john\'s book "
        $escaped_string = $this->db->real_escape_string($string);
        return $escaped_string;
    }
    //method for insert id for the last row created in the table 
    public function the_insert_id()
    {
        return $this->db->insert_id;
        //old way
        // return mysqli_insert_id($this->connection);
    }
}


$database = new Database();
