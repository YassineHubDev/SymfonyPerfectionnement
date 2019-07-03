<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig');
    }

    /**
     * @Route("/user/liste", name="app_user")
     * @param UserRepository $userRepository
     * @return Response
     */
    public function list(UserRepository $userRepository): Response
    {
        return $this->render('userregister/list.html.twig', [
            'users' => $userRepository->findAll()
        ]);
    }

    /**
     * @Route("/user/update/{id}", name="app_user_update")
     * @param Request $request
     * @param ObjectManager $manager
     * @param User $user
     * @return Response
     */
    public function update(Request $request, ObjectManager $manager, User $user): Response
    {
        dump($request->request);

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            $this->addFlash('warning', 'Utilisateur modifié avec succés !');
            return $this->redirectToRoute('app_user');


        }
        return $this->render('updateuserregister/update.html.twig', [
            'updateForm' => $form->createView()

        ]);
    }

}
