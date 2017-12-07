<?php

namespace Core\Component;

use Symfony\Component\HttpFoundation\Request;

class Controller
{
    /** @var Request $request */
    public $request;

    /**@var \Twig_Environment $twig*/
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
    public function setTwig(\Twig_Environment $twig){
        $this->twig = $twig;
    }
}

?>