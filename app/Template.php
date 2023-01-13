<?php
namespace App;

use Twig as TemplateEngine;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class Template{

    public bool $development = true;

    public array $templateAssignArrayItems = [];
    public TemplateEngine\Environment $view;

    public function __construct(){

        global $routes;

        $loader     = new TemplateEngine\Loader\FilesystemLoader(__DIR__.'/../views');
        $this->view = new TemplateEngine\Environment($loader, [
            //"cache" => __DIR__ . "/../views/cache"
        ]);

        // Functions
        $assetFunction = new TemplateEngine\TwigFunction('assets', function ($asset){
            if($this->development === true){
                return 'assets/'.$asset . "?" . uniqid();
            }else{
                return 'assets/'.$asset . "?v=" . VERSION_NUMBER;
            }
        });

        $this->view->addFunction($assetFunction);

        // Get Path
        $getPathFunction = new TemplateEngine\TwigFunction('getPath', function ($pathName) use($routes){
            return $routes->get($pathName)->getPath();
        });

        $this->view->addFunction($getPathFunction);

    }

    public function render(string $templateFile){

        try{
            echo $this->view->render($templateFile . ".twig", $this->templateAssignArrayItems);
        }catch (\ErrorException|LoaderError|RuntimeError|SyntaxError $e){
            echo $e->getMessage();
        }

    }

    public function assign(array $items){

        foreach ($items as $key => $value){
            $this->templateAssignArrayItems[$key] = $value;
        }

    }

}
