<?php

namespace App\Controller;

use Core\Component\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    public function indexAction(Request $request, array $params = null)
    {
        $user = $this->entityManager->getRepository('User');

        return $this->render('user/index.html.twig', [
            'user' => $user
        ]);
    }

    public function editAction(Request $request, array $params = null)
    {

    }

    public function newAction(Request $request, array $params = null)
    {


    }

    public function deleteAction(Request $request, array $params = null)
    {


    }
}

?>