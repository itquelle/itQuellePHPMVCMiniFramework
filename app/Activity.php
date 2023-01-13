<?php
namespace App;

use App\Database;

class Activity extends Database{

    public Template $view;

    public function __construct(){
        // @extend: database
        parent::__construct();

        // @extend: template (twig)
        $this->view = new Template();
    }

}