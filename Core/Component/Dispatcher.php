<?php

namespace Core\Component;

use Core\Component\Controller;
use Symfony\Component\HttpFoundation\Request;

class Dispatcher
{
    public function dispatch(Controller $controller, Request $request)
    {
        $params = [];

        foreach ($request->request as $name => $value) {
            $params[$name] = $value;
        }

        if (method_exists($controller, $request->query->get('action'))) {
            return $controller->{$request->query->get('action')}($request, ...$params);
        }

        return null;
    }
}

?>