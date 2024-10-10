<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Manga;
use App\Entity\Mangashelf;

class MangaController extends AbstractController
{
    #[Route('/manga', name: 'app_manga')]
    public function index(): Response
    {
        return $this->render('manga/index.html.twig', [
            'controller_name' => 'MangaController',
        ]);
    }

    /**
     * @param Integer $id
     */
    #[Route('/manga/{id}', name: 'mangas_show', requirements: ['id' => '\d+'])]
    public function show(ManagerRegistry $doctrine, $id) : Response
    {
            $mangaRepo = $doctrine->getRepository(Manga::class);
            $manga = $mangaRepo->find($id);

            if (!$manga) {
                    throw $this->createNotFoundException('The manga does not exist');
            }

            return $this->render('manga/show.html.twig',
            [ 'manga' => $manga ]);

    }
}
