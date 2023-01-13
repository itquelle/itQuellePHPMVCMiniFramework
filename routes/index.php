<?php

use App\Attributes\AppRoute;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

// Routes system
$routes     = new RouteCollection();
$methods    = [];
$routeItems = [];

// Loading with Attributes -> Controllers -> Add Route
$buildRoutes = glob(__DIR__ . "/../app/Controllers/*.php", GLOB_BRACE);
foreach ($buildRoutes as $key => $value) {
    $baseName = basename($value);
    $baseName = str_replace(".php", "", $baseName);

    $className = '\\App\\Controllers\\' . $baseName;
    $classInstance = new $className();

    try {
        $reflectionClass = new \ReflectionClass($classInstance);
        $methods = $reflectionClass->getMethods(\ReflectionMethod::IS_PUBLIC);
    } catch (ReflectionException $e) {
        // Error
    }


    foreach ($methods as $method) {
        try {
            $reflectionMethod = new \ReflectionMethod($classInstance, $method->getName());
            $attributes = $reflectionMethod->getAttributes(AppRoute::class);
            foreach ($attributes as $attribute) {
                $base = $attribute->newInstance();

                $routeItems[] = [
                    "path" => $base->path,
                    "name" => $base->name,
                    "method" => $base->method,
                    "action" => $base->action
                ];

                $routes->add(
                    $base->name,
                    new Route(
                        constant('URL_SUBFOLDER') . $base->path,
                        [
                            'controller'    => $baseName,
                            'method'        => $base->action ?? 'onCreate',
                        ], [], [], '', [], [$base->method ?? "GET"]
                    )
                );
            }
        } catch (ReflectionException $e) {
            // Error
        }

    }

}