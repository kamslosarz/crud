<?php

namespace Controller;

use Core\Component\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @param Request $request
     * @param null $params
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function indexAction(Request $request = null, $params = null)
    {
        return $this->twig->render('default/index.html.twig');
    }
}

?>