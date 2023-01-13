<?php
$args = $argv;
switch ($args[1]){

    # list controllers
    case 'list:controller':

        require_once 'vendor/autoload.php';
        require_once 'config/config.php';
        require_once 'routes/index.php';

        $searchKey = $args[2] ?? "";

        global $routeItems;

        $line = "";
        foreach ($routeItems as $key => $value){
            if(!empty($searchKey)){
                // Search
                if(str_contains($value["path"], $searchKey)){
                    $line .= "{ url: '" . $value["path"] . "', method: '" . $value["method"] . "', name: '" . $value["name"] . "' } \n";
                }
            }else {
                $line .= "{ url: '" . $value["path"] . "', method: '" . $value["method"] . "', name: '" . $value["name"] . "' } \n";
            }
        }

        if($searchKey){
            echo "Found results:\n";
        }
        if(empty($line)){
            echo "No controllers found!";
        }else {
            echo $line;
        }

        break;

    # php console.php make:controller ProfileController
    case 'make:controller':

        $controllerName = $args[2];

        $getControllerTemplate = file_get_contents(__DIR__."/config/make_controller.txt");
        $getControllerTemplate = strtr($getControllerTemplate, [
            "{ControllerName}" => $controllerName
        ]);

        $createFileName = __DIR__."/app/Controllers/" . $controllerName . ".php";

        if(!file_exists($createFileName)) {
            file_put_contents($createFileName, $getControllerTemplate);
        }else{
            echo "Controller already exists!";
        }

        break;
    default:
        // No function call
        break;
}