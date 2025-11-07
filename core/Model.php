<?php
class Model
{
    protected function db()
    {
        require '../config/config.php';
        static $db = null;
        if ($db === null) {
            $db = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);
        }
        return $db;
    }
}
