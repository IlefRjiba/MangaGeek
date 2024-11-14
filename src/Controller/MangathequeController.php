<?php

namespace App\Controller;

use App\Entity\Mangatheque;
use App\Form\MangathequeType;
use App\Repository\MangathequeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Manga;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;

#[Route('/mangatheque')]
final class MangathequeController extends AbstractController
{
    #[Route(name: 'app_mangatheque_index', methods: ['GET'])]
    public function index(MangathequeRepository $mangathequeRepository): Response
    {
        return $this->render('mangatheque/index.html.twig', [
            'mangatheques' => $mangathequeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_mangatheque_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $mangatheque = new Mangatheque();
        $form = $this->createForm(MangathequeType::class, $mangatheque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($mangatheque);
            $entityManager->flush();

            // Make sure message will be displayed after redirect
            $this->addFlash('message', 'bien ajouté');

            return $this->redirectToRoute('app_mangatheque_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('mangatheque/new.html.twig', [
            'mangatheque' => $mangatheque,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_mangatheque_show', methods: ['GET'])]
    public function show(Mangatheque $mangatheque): Response
    {
        return $this->render('mangatheque/show.html.twig', [
            'mangatheque' => $mangatheque,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_mangatheque_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Mangatheque $mangatheque, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MangathequeType::class, $mangatheque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_mangatheque_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('mangatheque/edit.html.twig', [
            'mangatheque' => $mangatheque,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_mangatheque_delete', methods: ['POST'])]
    public function delete(Request $request, Mangatheque $mangatheque, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$mangatheque->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($mangatheque);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_mangatheque_index', [], Response::HTTP_SEE_OTHER);
    }


    //     /**
    //  * @param Integer $id
    //  */
    // #[Route('/manga/{id}', name: 'app_mangatheque_manga_show', requirements: ['id' => '\d+'])]
    // public function mangaShow(ManagerRegistry $doctrine, $id) : Response
    // {
    //         $mangaRepo = $doctrine->getRepository(Manga::class);
    //         $manga = $mangaRepo->find($id);

    //         if (!$manga) {
    //                 throw $this->createNotFoundException('The manga does not exist');
    //         }

    //         return $this->render('mangatheque/mangaShow.html.twig',
    //         [ 'manga' => $manga ]);

    // }



   #[Route('/{mangatheque_id}/manga/{manga_id}',
           methods: ['GET'],
           name: 'app_mangatheque_manga_show')]
   public function mangaShow(
                            #[MapEntity(id: 'mangatheque_id')] Mangatheque $mangatheque,
                            #[MapEntity(id: 'manga_id')] Manga $manga
                            ): Response
   {
    if(! $mangatheque->getMangas()->contains($manga)) {
                throw $this->createNotFoundException("Couldn't find such a Manga in this Mangatheque !");
        }

        // if(! $[galerie]->isPublished()) {
        //   throw $this->createAccessDeniedException("You cannot access the requested ressource!");
        //}

       return $this->render('mangatheque/mangaShow.html.twig', [
           'manga' => $manga,
           'mangatheque' => $mangatheque
       ]);
   }

}
