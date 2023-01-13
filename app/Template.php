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

        // CDNJS Cloudflare
        $cloudflareCDN = new TemplateEngine\TwigFunction('cdnjs', function (string|int $value, bool $cache = false, string $tag = ''){
            $fileName = pathinfo(basename($value), PATHINFO_EXTENSION);
            $getPackageName = explode("/", $value)[0];
            $getPackageFileName = explode("/", basename($value))[0];

            $baseUrl = "https://cdnjs.cloudflare.com/ajax/libs/" . $value;

            // Cache
            if($cache){
                if(!file_exists(__DIR__."/../views/@package/" . $getPackageName . "/" . $getPackageFileName)) {
                    if(!is_dir(__DIR__ . "/../views/@package/" . $getPackageName)){
                        mkdir(__DIR__ . "/../views/@package/" . $getPackageName, 0777);
                        chmod(__DIR__ . "/../views/@package/" . $getPackageName, 0777);
                    }
                    file_put_contents(
                        __DIR__ . "/../views/@package/" . $getPackageName . "/" . $getPackageFileName,
                        file_get_contents("https://cdnjs.cloudflare.com/ajax/libs/" . $value)
                    );
                }

                $baseUrl = "package/" . $getPackageName . "/" . $getPackageFileName;
            }


            if($fileName == "js") {
                return '<script src="' . $baseUrl . '" type="text/javascript" ' . $tag . '></script>';
            }
            if($fileName == "css"){
                return '<link rel="stylesheet" href="' . $baseUrl . '" '.$tag.'>';
            }
        });
        $this->view->addFunction($cloudflareCDN);

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
