<?php 

namespace App\Controllers;

use App\Activity;
use App\Attributes\AppRoute;
use App\Models\Kunden;
use Symfony\Component\Routing\RouteCollection;

class PageController extends Activity {

    #[AppRoute('/', method: 'GET', name: 'home')]
	public function onCreate(RouteCollection $routes){

        $kunden = new Kunden();

        $this->view->assign([
            "kunden_items" => $kunden->getUsers(limit: 10)
        ]);

        $this->view->render("index");

	}

}