<?php

namespace Core;

use Core\Component\Controller;
use Core\Component\Dispatcher;
use Core\Component\Route;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Bridge\Twig\Form\TwigRendererEngine;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension;
use Symfony\Component\Form\Forms;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class Kernel
{
    /**
     * @param Request $request
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     */
    public function handle(Request $request)
    {
        $session = new Session();
        $session->start();
        $request->setSession($session);

        $route = new Route($request);

        $response = new Response();
        $dispatcher = new Dispatcher();
        $controller = 'App\\Controller\\' . ($route->getControllerName() ? ucfirst(strtolower($route->getControllerName())) : 'Default') . 'Controller';

        if (class_exists($controller, true)) {
            /** @var Controller $controller */
            $controller = new $controller($request);
            $loader = new \Twig_Loader_Filesystem([
                dirname(__DIR__) . '/src/View/'
            ]);

            $twig = new \Twig_Environment($loader, [
                //'cache' => dirname(__DIR__) . '/cache'
                'cache' => false,
                'debug' => true
            ]);

            $twig->addExtension(new \Twig_Extension_Debug());

            $twig->addFunction(new \Twig_Function('flashMessage', function () use ($session) {
                $message = $session->get('message');
                $session->set('message', '');

                return $message;
            }));
            $twig->addFunction(new \Twig_Function('hasMessage', function () use ($session) {
                return $session->has('message');
            }));

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

            $response->setContent($dispatcher->dispatch($controller, $request, $route));
        }

        return $response;
    }
}

?>