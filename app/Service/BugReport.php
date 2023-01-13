<?php
namespace App\Service;

use PDO;

class BugReport{

    public function addSQL(\PDOException $errorMessage){

        $getDumpMessage = ob_get_contents();
        ob_end_clean();

        $bugReportText = "--- " . date("d.m.Y H:i") . " Uhr ---\n";
        $bugReportText .= "Message: " . $errorMessage->getMessage() . "\n";
        $bugReportText .= "File: " . $errorMessage->getFile() . "\n";
        $bugReportText .= "Line: " . $errorMessage->getLine() . "\n";
        $bugReportText .= "SQL-Dump-Report: \n" . $getDumpMessage . "\n";
        $bugReportText .= "--- END ---";

        file_put_contents(__DIR__."/../../config/errors/sql.txt", $bugReportText, FILE_APPEND);

    }

}