<?php

namespace Core\Component;

use Core\Component\Controller;
use Symfony\Component\HttpFoundation\Request;

class Dispatcher
{
    public function dispatch(Controller $controller,Request $request,  Route $route)
    {
        if (method_exists($controller, $route->getAction())) {
            if($route->getParams()){
                return $controller->{$route->getAction()}($request, ...array_values($route->getParams()));
            }else{
                return $controller->{$route->getAction()}($request);
            }
        }

        return null;
    }
}

?>