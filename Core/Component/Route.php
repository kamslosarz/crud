<?php

namespace Core\Component;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Yaml\Yaml;

class Route
{

    private $routes;
    private $controllerName;
    private $action;
    private $params;

    public function __construct(Request $request)
    {
        $this->loadRoutes();
        $this->math($request->getRequestUri());
    }

    private function math($uri)
    {
        $uri = explode('/', $uri);
        unset($uri[0]);

        foreach ($this->routes as $controller => $route) {
            foreach ($route as $action => $params) {
                $routeParams = explode('/', $params);
                $routeParamsSet = [];
                unset($routeParams[0]);
                if (sizeof($routeParams) == sizeof($uri)) {
                    foreach ($routeParams as $lp => $p) {
                        if (preg_match('/\[[:a-z0-9]+\]/', $p)) {
                            $paramName = preg_replace('/\[:([a-z0-9]{1,})\]/', '$1', $p);
                            $routeParamsSet[$paramName] = $uri[$lp];
                            $routeParams[$lp] = $uri[$lp];
                        }
                    }

                    if ($routeParams == $uri) {
                        $this->controllerName = $controller;
                        $this->action = $action;
                        $this->params = $routeParamsSet;
                        return;
                    }
                }
            }
        }

        if (isset($uri[1])) {
            $this->controllerName = $uri[1];
        } else {
            $this->controllerName = 'default';
        }
        if (isset($uri[2])) {
            $this->action = $uri[2];
        } else {
            $this->action= 'index';
        }
    }

    public function getParams()
    {
        return $this->params;
    }

    public function getControllerName()
    {
        return $this->controllerName;
    }

    public function getAction()
    {
        return $this->action . 'Action';
    }

    private function loadRoutes()
    {
        $file = __DIR__ . '/../../config/routes.yaml';
        if (file_exists($file)) {
            $this->routes = Yaml::parseFile($file);
        }

        return $this;
    }
}

?>