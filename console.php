<?php
$args = $argv;
switch ($args[1]){

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