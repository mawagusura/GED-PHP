<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


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
    public function new(Request $request,UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() ) {

            $user->setUserFirstName($form->getData()->getUserFirstName());
            $user->setUserLastName($form->getData()->getUserLastName());
            $user->setUsername($form->getData()->getUsername());
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            // Par defaut l'utilisateur aura toujours le rôle ROLE_USER
            $user->setRoles(['ROLE_USER']);

            // l'utilisateur n'est pas supprimé
            $user->setUserDeleted(false);

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
    public function edit(Request $request,int $user_id,UserPasswordEncoderInterface $passwordEncoder ): Response
    {
        $user = $this->getDoctrine()->getRepository('App:User')->find($user_id);
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() ) {

            $user->setUserFirstName($form->getData()->getUserFirstName());
            $user->setUserLastName($form->getData()->getUserLastName());
            $user->setUsername($form->getData()->getUsername());
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            // Par defaut l'utilisateur aura toujours le rôle ROLE_USER
            $user->setRoles(['ROLE_USER']);

            // l'utilisateur n'est pas supprimé
            $user->setUserDeleted(false);

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_edit', ['user_id' => $user->getId()]);
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
     * @param int $user_id
     * @return Response
     */
    public function delete(Request $request, int $user_id): Response
    {
        $user= $this->getDoctrine()->getRepository('App:User')->find($user_id);
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
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
