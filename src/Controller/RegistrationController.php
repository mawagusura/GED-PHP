<?php
/**
 * Created by PhpStorm.
 * User: Amaury
 * Date: 09/07/2018
 * Time: 16:43
 */

namespace App\Controller;


use App\Form\UserType;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends Controller
{
    /**
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();
        $form = $this->createForm(UserType::class,$user );

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $password = $passwordEncoder->encodePassword($user, $user->getUserPassword());
            $user->setPassword($password);

            // Par defaut l'utilisateur aura toujours le rôle ROLE_USER
            $user->setRoles(['ROLE_USER']);

            // l'utilisateur n'est pas supprimé
            $user->setUserDeleted(false);

            // On enregistre l'utilisateur dans la base
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('security_login');
        }

        else if($form->isSubmitted()){

            return $this->render(
                'pages/register.html.twig',
                array(
                    'form' => $form->createView(),
                    'title' => 'S\'inscrire',
                    'connected' => false
                )
            );
        }


        return $this->render(
            'pages/register.html.twig',
            array(
                'form' => $form->createView(),
                'title' => 'S\'inscrire',
                'connected' => false
                )
        );
    }
}