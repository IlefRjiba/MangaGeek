<?php

namespace App\Controller;

use App\Entity\Mangashelf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Persistence\ManagerRegistry;


class MangashelfController extends AbstractController
{

    #[Route('/mangashelf', name: 'mangashelf_list', methods: ['GET'])]
    public function listAction(ManagerRegistry $doctrine): Response
    {
        $member = $this->getUser();

        if ($member) {
            $mangashelf = $member->getMangashelf();

            // Check if the user has an associated Mangashelf
            if ($mangashelf) {
                return $this->render('mangashelf/show.html.twig', [
                    'mangashelf' => $mangashelf, // Pass the single Mangashelf object
                ]);
            }
        }

        $this->addFlash('error', 'No inventory found for the user.');
        return $this->redirectToRoute('home'); // Redirect if no Mangashelf is found
    }

    #[Route('/mangashelf/all', name: 'mangashelf_index', methods: ['GET'])]
    public function listMangashelves(ManagerRegistry $doctrine): Response
    {
        $user = $this->getUser();

        // Check if the user has the admin role
        if ($user && $this->isGranted('ROLE_ADMIN')) {
            $entityManager = $doctrine->getManager();
            $mangashelves = $entityManager->getRepository(Mangashelf::class)->findAll();

            return $this->render('mangashelf/index.html.twig', [
                'mangashelves' => $mangashelves, // Pass all Mangashelves for admin
            ]);
        }

        $this->addFlash('error', 'Access denied.');
        return $this->redirectToRoute('home'); // Redirect non-admin users
    }



    /**
     * @param Integer $id
     */
    #[Route('/mangashelf/{id}', name: 'mangashelf_show', requirements: ['id' => '\d+'])]
    public function show(ManagerRegistry $doctrine, $id): Response
    {
        $mangashelfRepo = $doctrine->getRepository(mangashelf::class);
        $mangashelf = $mangashelfRepo->find($id);

        if (!$mangashelf) {
            throw $this->createNotFoundException('The mangashelf does not exist');
        }

        return $this->render(
            'mangashelf/show.html.twig',
            ['mangashelf' => $mangashelf]
        );

    }

}
