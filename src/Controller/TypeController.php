<?php
/**
 * Created by PhpStorm.
 * User: Lucas EFREI
 * Date: 14/07/2018
 * Time: 16:41
 */

namespace App\Controller;


use App\Entity\DocType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Flex\Response;
use Symfony\Component\Routing\Annotation\Route;

class TypeController extends AbstractController
{

    /**
     * @Route("/type",name="create_type")
     * @param Request $request
     * @return Response
     */
    public function createType(Request $request):Response
    {
        $type= new DocType();
        $form = $this->createForm(DocType::class,$type);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($type);
            $em->flush();
        }
        return $this->redirectToRoute('pages/home.html.twig');
    }
}