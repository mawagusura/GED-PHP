<?php
/**
 * Created by PhpStorm.
 * User: Lucas EFREI
 * Date: 14/07/2018
 * Time: 16:41
 */

namespace App\Controller;


use App\Entity\DocType;
use App\Form\TypeForm;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TypeController extends Controller
{

    /**
     * @Route("/type",name="create_type")
     * @param Request $request
     * @return Response
     */
    public function createType(Request $request):Response
    {
        $type= new DocType();
        $form = $this->createForm(TypeForm::class,$type);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($type);
            $em->flush();
        }
        return $this->render('pages/home.html.twig');
    }
}