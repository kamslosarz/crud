<?php

namespace App\Controller;

use App\Form\UserForm;
use Core\Component\Controller;
use Entity\User;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    public function indexAction(Request $request, array $params = null)
    {
        $users = $this->entityManager->getRepository('Entity\User');

        return $this->render('user/index.html.twig', [
            'users' => $users->findAll()
        ]);
    }

    public function editAction(Request $request, array $params = null)
    {

    }

    private function getForm(User $user)
    {
        /** @var FormBuilder $builder */
        $builder = $this->formFactory->createBuilder(FormType::class, null, [
            'action' => '/user/new',
            'method' => 'POST'
        ]);
        return $builder->add('name', TextType::class)
            ->add('surname', TextType::class)
            ->add('phone', TextType::class)
            ->add('address', TextType::class)
            ->getForm()
            ->setData((array)$user);
    }

    public function newAction(Request $request, array $params = null)
    {
        /** @var Form $form */
        $form = $this->getForm(new User());

        return $this->render('user/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function deleteAction(Request $request, array $params = null)
    {


    }
}

?>