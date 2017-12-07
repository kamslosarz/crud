<?php

namespace Core;

use Core\Component\Controller;
use Core\Component\Dispatcher;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Kernel
{
    /**
     * @param Request $request
     * @return Response
     */
    public function handle(Request $request)
    {
        $params = explode('/', $request->getRequestUri());

        $request->query = new ParameterBag([
            'action' => isset($params[1]) ? $params[1] : 'index'
        ]);
        $request->request = new ParameterBag(
            $_POST
        );;

        $response = new Response();
        $dispatcher = new Dispatcher();
        $controller = isset($params[0]) ? ucfirst(strtolower($params[0])) : 'Default';
        /** @var Controller $controller */
        $controller = new $controller($request);
        $loader = new \Twig_Loader_Array(array(
            'cache' => true,
        ));
        $twig = new \Twig_Environment($loader);
        $controller->setTwig($twig);
        $response->setContent($dispatcher->dispatch($controller, $request));

        return $response;
    }
}

?>