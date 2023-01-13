<?php
namespace App;

use PDO;
use PDOException;

class Database{

    public PDO $db;

    public function __construct(){

        try{

            $this->db = new PDO(
                "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8;",
                DB_USER,
                DB_PASS,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_EMULATE_PREPARES => true,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );

        }catch (PDOException $e){

            die(
                $e->getMessage()
            );
        }

    }

    public function __destruct(){

    }

}