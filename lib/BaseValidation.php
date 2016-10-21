<?php
include '../lib/medoo.php';

class BaseValidation 
{
    var $db;

    function __construct()
    {
        $database = array(
            'database_type' => 'mysql',
            'database_name' => 'ssh_db',
            'server' => 'localhost',
            'username' => 'ssh',
            'password' => '1234',
            'charset' => 'utf8'
        );
        $this->db = new medoo($database);
    }
}
?>
