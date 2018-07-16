<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\User1Type;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/user")
 */
class UserController extends Controller
{
    /**
     * @Route("/", name="user_index", methods="GET")
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
            'title'=>"Gestion Utilisateur",
            'connected'=>true
        ]);
    }

    /**
     * @Route("/new", name="user_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
            'title'=>"Création Utilisateur",
            'connected'=>true
        ]);
    }

    /**
     * @Route("/{user_id}", name="user_show", methods="GET")
     */
    public function show(int $user_id): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $this->getDoctrine()->getRepository('App:User')->find($user_id),
            'title'=>"Visualisation Utilisateur",
            'connected'=>true
        ]);
    }

    /**
     * @Route("/{user_id}/edit", name="user_edit", methods="GET|POST")
     */
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_edit', ['user_id' => $user->getUser_id()]);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
            'title'=>"Edition Utilisateur",
            'connected'=>true
        ]);
    }

    /**
     * @Route("/user/{user_id}", name="user_delete", methods="DELETE")
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getUser_id(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $user->setUserDeleted(true);
            $em->persist($user);
            $em->flush();
        }

        return $this->redirectToRoute('user_index');
    }

    /**
     * @return Response
     */
    public function details(): Response
    {
        return $this->render("pages/user-details.html.twig",array(
            'title'=>"Détails d'utilisateur",
            'connected'=>true,
            'user'=>$this->getUser()
        ));
    }
}
