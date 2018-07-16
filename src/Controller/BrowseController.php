<?php
/**
 * Created by PhpStorm.
 * User: Amaury
 * Date: 14/07/2018
 * Time: 11:24
 */

namespace App\Controller;


use App\Repository\FolderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Tests\Controller;
use Symfony\Component\Routing\Annotation\Route;


class BrowseController extends AbstractController
{

    /**
     * @param FolderRepository $folderRepository
     * @Route(path="/browse", name="browse")
     */
    public function browse(FolderRepository $folderRepository){

        $racine = $folderRepository->find(1);

        $this->render('pages/browse.html.twig', [
            "dossier" => $racine
        ]);
    }
}