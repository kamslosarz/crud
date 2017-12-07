<?php

namespace App\Controller;

use Core\Component\Controller;
use Entity\User;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    public function indexAction(Request $request)
    {
        $users = $this->entityManager->getRepository('Entity\User');

        return $this->render('user/index.html.twig', [
            'users' => $users->findAll()
        ]);
    }

    public function editAction(Request $request, $id)
    {
        $user = $this->entityManager->getRepository('Entity\User')->find($id);
        if ($user instanceof User) {
            /** @var Form $form */
            $form = $this->getForm($user);
            if ($request->isMethod('POST')) {
                $form->submit($request->request->get('user'));
                if ($form->isValid() && $form->isSubmitted()) {
                    $user = $form->getData();
                    $this->entityManager->persist($user);
                    $this->entityManager->flush();
                    $this->addFlash("User updated");
                    return RedirectResponse::create('/user');
                }
            }

            return $this->render('user/edit.html.twig', [
                'form' => $form
            ]);
        }

        return RedirectResponse::create('/user');
    }

    private function getForm(User $user)
    {
        /** @var FormBuilder $builder */
        $builder = $this->formFactory->createBuilder(FormType::class, null, [
            'action' => '/user/new',
            'method' => 'POST',
            'data_class' => 'Entity\User'
        ]);
        return $builder->add('name', TextType::class)
            ->add('surname', TextType::class)
            ->add('phone', TextType::class)
            ->add('address', TextType::class)
            ->getForm()
            ->setData($user);
    }

    public function newAction(Request $request)
    {
        /** @var Form $form */
        $form = $this->getForm(new User());

        if ($request->isMethod('POST')) {
            $form->submit($request->request->get('user'));

            if ($form->isSubmitted() && $form->isValid()) {
                $this->entityManager->persist($form->getData());
                $this->entityManager->flush();
            }

            $this->addFlash("User created");
            return RedirectResponse::create('/user');
        }

        return $this->render('user/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function deleteAction(Request $request, $id)
    {
        $user = $this->entityManager->getRepository('Entity\User')->find($id);

        if ($user instanceof User) {
            $this->entityManager->remove($user);
            $this->entityManager->flush();
            $this->addFlash('User deleted');
        }

        return RedirectResponse::create('/user');
    }
}

?>