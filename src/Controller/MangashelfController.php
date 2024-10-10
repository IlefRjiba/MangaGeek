<?php

namespace App\Controller;

use App\Entity\Mangashelf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Persistence\ManagerRegistry;


class MangashelfController extends AbstractController
{
    
    #[Route('/mangashelf', name: 'mangashelf_list', methods:['GET'] )]
    public function listAction(ManagerRegistry $doctrine): Response
    {
        $entityManager= $doctrine->getManager();
        $mangashelfs = $entityManager->getRepository(Mangashelf::class)->findAll();

        return $this->render('mangashelf/index.html.twig', [
            'controller_name' => 'MangashelfController',
            "mangashelves" => $mangashelfs
        ]);
    }


    /**
     * @param Integer $id
     */
    #[Route('/mangashelf/{id}', name: 'mangashelf_show', requirements: ['id' => '\d+'])]
    public function show(ManagerRegistry $doctrine, $id) : Response
    {
            $mangashelfRepo = $doctrine->getRepository(mangashelf::class);
            $mangashelf = $mangashelfRepo->find($id);

            if (!$mangashelf) {
                    throw $this->createNotFoundException('The mangashelf does not exist');
            }

            return $this->render('mangashelf/show.html.twig',
            [ 'mangashelf' => $mangashelf ]);

    }

}
