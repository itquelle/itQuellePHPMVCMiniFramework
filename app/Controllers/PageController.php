<?php 

namespace App\Controllers;

use App\Activity;
use App\Attributes\AppRoute;
use App\Models\Kunden;
use Symfony\Component\Routing\RouteCollection;

class PageController extends Activity {

    #[AppRoute('/', method: 'GET', name: 'home')]
	public function onCreate(RouteCollection $routes){

        $this->view->assign([
            "name" => "Ben"
        ]);

        $this->view->render("index");

	}

    #[AppRoute('/test', method: 'GET', name: 'hometest', action: 'onCreateText')]
    public function onCreateText(RouteCollection $routes){

        $this->view->assign([
            "name" => "Ben"
        ]);

        $this->view->render("index");

    }

}