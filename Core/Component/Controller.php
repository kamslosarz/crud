<?php

namespace Core\Component;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;

/**
 * @property EntityManager entityManager
 */
class Controller
{
    /** @var Request $request */
    public $request;

    /**@var \Twig_Environment $twig */
    public $twig;

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
     * @param $name
     * @param $params
     * @return string
     */
    public function render($name, $params)
    {
        try {
            return $this->twig->render($name, $params);
        } catch (\Twig_Error_Loader $e) {
        } catch (\Twig_Error_Runtime $e) {
        } catch (\Twig_Error_Syntax $e) {
        }

        return null;
    }
}

?>