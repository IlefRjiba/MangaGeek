<?php

namespace App\Controller;

use App\Entity\Mangatheque;
use App\Form\MangathequeType;
use App\Repository\MangathequeRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Member;
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
    #[Route('/all', name: 'app_mangatheque_index', methods: ['GET'])]
    public function index(MangathequeRepository $mangathequeRepository): Response
    {
        return $this->render('mangatheque/index.html.twig', [
            'mangatheques' => $mangathequeRepository->findPublicMangatheques(),
        ]);
    }

    #[Route('/mangatheque/new/{id}', name: 'app_mangatheque_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, Member $member): Response
    {
        $mangatheque = new Mangatheque();
        $mangatheque->setMember($member);

        $form = $this->createForm(MangathequeType::class, $mangatheque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($mangatheque);
            $entityManager->flush();

            // Make sure message will be displayed after redirect
            $this->addFlash('success', 'Nouvelle mangatheque ajoutée');

            return $this->redirectToRoute('app_member_show', ['id'=> $member->getId()], Response::HTTP_SEE_OTHER);
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

            $this->addFlash('warning', 'Mangatheque modifié');
            return $this->redirectToRoute('app_member_show', ['id'=>$mangatheque->getMember()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('mangatheque/edit.html.twig', [
            'mangatheque' => $mangatheque,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_mangatheque_delete', methods: ['POST'])]
    public function delete(Request $request, Mangatheque $mangatheque, EntityManagerInterface $entityManager): Response
    {
        // if ($this->isCsrfTokenValid('delete'.$mangatheque->getId(), $request->getPayload()->getString('_token')))
        if ($this->isCsrfTokenValid('delete'.$mangatheque->getId(), $request->request->get('_token'))) {
            $entityManager->remove($mangatheque);
            $entityManager->flush();
        }

        $this->addFlash('warning', 'Mangatheque supprimé');
        return $this->redirectToRoute('app_member_show', ['id'=>$mangatheque->getMember()->getId()], Response::HTTP_SEE_OTHER);
    }

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

       return $this->render('mangatheque/mangaShow.html.twig', [
           'manga' => $manga,
           'mangatheque' => $mangatheque
       ]);
   }

}
