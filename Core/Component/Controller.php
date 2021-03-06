<?php

namespace Core\Component;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * @property EntityManager entityManager
 */
class Controller
{
    /** @var Request $request */
    public $request;

    /**@var \Twig_Environment $twig */
    public $twig;

    /**@var FormFactoryInterface $twig */
    public $formFactory;

    /**
     * Controller constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param \Twig_Environment $twig
     */
    public function setTwig(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @param EntityManager $entityManager
     */
    public function setEntityManager(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param FormFactoryInterface $formFactory
     */
    public function setFormFactory(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    /**
     * @param $name
     * @param array|null $params
     * @return null|string
     */
    public function render($name, array $params = null)
    {
        try {
            return $this->twig->render($name, $params);
        } catch (\Twig_Error_Loader $e) {
            dump($e);
        } catch (\Twig_Error_Runtime $e) {
            dump($e);
        } catch (\Twig_Error_Syntax $e) {
            dump($e);
        }

        return null;
    }

    /**
     * @param $message
     * @return $this
     */
    public function addFlash($message){
        /** @var Session $session */
        $session = $this->request->getSession();
        $session->set('message', $message);

        return $this;
    }
}

?>