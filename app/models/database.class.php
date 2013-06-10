<?php
  class Database {

    public static function getConnection() {
        require 'database.php';
        return pg_connect("host={$db_host} port={$db_port} dbname={$db_dbname} user={$db_user} password={$db_pswd}");
    }
  }
?>