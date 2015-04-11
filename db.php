<?php
class database {

    private $username;
    private $password;
    private $database;

    private $db;


    public function __construct() {

        // choose which account we're using
        //TODO set DB
        self::set_localhost_acct();
        //self::set_namecheap_acct();

        // connect to db
        $this->db = new mysqli('localhost', $this->username, $this->password, $this->database);
        if ($this->db->connect_errno) {
        die("Failed to connect to MySQL: (" . $this->db->connect_errno . ") " . $this->db->connect_error);
        }
        //echo $this->db->host_info . "<br/>";
        //echo 'Connected successfully<br/>';
        }

        private function set_localhost_acct() {
        $this->username = 'root';
        $this->password = '';
        $this->database = 'poast';
        }

        private function set_namecheap_acct() {
        $this->username = '';
        $this->password = '';
        $this->database = 'poast';
        }

        public function get_db() {
        return $this->db;
    }
}