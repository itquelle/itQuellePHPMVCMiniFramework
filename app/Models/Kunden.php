<?php
namespace App\Models;

use App\Database;
use App\Service\BugReport;

class Kunden extends Database {

    public int $kundenLimit = 50;

    public function getUsers(int $limit): array{

        $limit = $limit??$this->kundenLimit;

        try {
            $get = $this->db->prepare("SELECT * FROM kunden WHERE id = :id LIMIT $limit");
            $get->execute([
                ":id" => 22
            ]);
            $row = $get->fetchAll();

        }catch (\PDOException $e){
            $bug = new BugReport();
            $get->debugDumpParams();
            $bug->addSQL($e);
        }

        return $row;
    }

    public function getById(int $userId = 0): array{
        return $this->db->query("SELECT * FROM kunden WHERE user_id = '".$userId."'")->fetch();
    }

}