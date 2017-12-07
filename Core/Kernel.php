<?php

namespace Core;

use App\Controller\DefaultController;
use App\Controller\UserController;
use Core\Component\Controller;
use Core\Component\Dispatcher;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Phalcon\Mvc\Application;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension;
use Symfony\Component\Form\Forms;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Kernel
{
    /**
     * @param Request $request
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     */
    public function handle(Request $request)
    {
        $params = explode('/', $request->getRequestUri());
        $request->query = new ParameterBag([
            'action' => ((isset($params[2]) && $params[2]) ? $params[2] : 'index') . 'Action'
        ]);
        $request->request = new ParameterBag(
            $_POST
        );;

        $response = new Response();
        $dispatcher = new Dispatcher();
        $controller = 'App\\Controller\\' . ((isset($params[1]) && $params[1]) ? ucfirst(strtolower($params[1])) : 'Default') . 'Controller';

        if (class_exists($controller, true)) {

            /** @var Controller $controller */
            $controller = new $controller($request);
            $loader = new \Twig_Loader_Filesystem([
                dirname(__DIR__) . '/src/View/'
            ]);

            $twig = new \Twig_Environment($loader, [
                //'cache' => dirname(__DIR__) . '/cache'
                'cache' => false
            ]);

            $config = Setup::createAnnotationMetadataConfiguration(array(__DIR__ . "/../src/Entity"), true);
            $conn = array(
                'driver' => 'pdo_sqlite',
                'path' => __DIR__ . '/../data/database.sqlite',
            );

            $entityManager = EntityManager::create($conn, $config);
            $entityManager->getMetadataFactory()->getAllMetadata();
            $formFactory = Forms::createFormFactoryBuilder()
                ->addExtension(new HttpFoundationExtension())
                ->getFormFactory();

            $controller->setTwig($twig);
            $controller->setEntityManager($entityManager);
            $controller->setFormFactory($formFactory);

            $response->setContent($dispatcher->dispatch($controller, $request));
        }

        return $response;
    }
}

?>