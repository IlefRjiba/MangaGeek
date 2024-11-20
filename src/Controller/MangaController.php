<?php

namespace App\Controller;

use App\Entity\Manga;
use App\Form\MangaType;
use App\Repository\MangaRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Mangashelf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/manga')]
final class MangaController extends AbstractController
{
    #[Route(name: 'app_manga_index', methods: ['GET'])]
    public function index(MangaRepository $mangaRepository): Response
    {
        $mangas = [];
        $user = $this->getUser();

        if ($user) {
            $member = $this->getUser();
            $mangas = $mangaRepository->findMemberManga($member);
        }

        return $this->render('manga/index.html.twig', [
            'mangas' => $mangas,
        ]);
    }

    #[Route('/all', name: 'app_manga_all', methods: ['GET'])]
    public function ListMangas(MangaRepository $mangaRepository): Response
    {
        $mangas = [];
        $user = $this->getUser();

        if ($user) {
            if ($this->isGranted('ROLE_ADMIN')) {
                // Admin: Fetch all mangas
                $mangas = $mangaRepository->findAll();
            } else {
                // Regular User: Fetch mangas associated with their Mangashelf
                $mangashelf = $user->getMangashelf();
                if ($mangashelf) {
                    $mangas = $mangaRepository->findBy(['mangashelf' => $mangashelf]);
                }
            }
        }

        return $this->render('manga/all.html.twig', [
            'mangas' => $mangas,
        ]);
    }

    #[Route('/new/{id}', name: 'app_manga_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, Mangashelf $mangashelf): Response
    {
        $user = $this->getUser();

        if ($mangashelf->getMembre() !== $user) {
            $this->addFlash('error', 'You do not own that Mangashelf.');
            return $this->redirectToRoute('app_member_show', ['id' => $user->getId()]);
        }

        $manga = new Manga();
        $manga->setMangashelf($mangashelf);
        $form = $this->createForm(MangaType::class, $manga);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($manga);
            $entityManager->flush();

            $this->addFlash('success', 'Manga added successfully.');

            return $this->redirectToRoute(
                'mangashelf_show',
                ['id' => $mangashelf->getId()],
                Response::HTTP_SEE_OTHER
            );
        }

        return $this->render('manga/new.html.twig', [
            'manga' => $manga,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_manga_show', methods: ['GET'])]
    public function show(Manga $manga): Response
    {
        return $this->render('manga/show.html.twig', [
            'manga' => $manga,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_manga_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Manga $manga, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if ($manga->getMangashelf()->getMembre() !== $user) {
            $this->addFlash('error', 'You do not own this Manga.');
            return $this->redirectToRoute('app_manga_show', ['id' => $manga->getId()]);
        }
        
        $form = $this->createForm(MangaType::class, $manga);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            if ($form->isValid()) {
                $entityManager->flush();

                $this->addFlash('message', 'Manga updated successfully');
                return $this->redirectToRoute('app_manga_index', [], Response::HTTP_SEE_OTHER);
            } else {
                $this->addFlash('error', 'Error in editing the manga');
            }
        }

        return $this->render('manga/edit.html.twig', [
            'manga' => $manga,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_manga_delete', methods: ['POST'])]
    public function delete(Request $request, Manga $manga, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if ($manga->getMangashelf()->getMembre() !== $user) {
            $this->addFlash('error', 'You do not own this Manga.');
            return $this->redirectToRoute('app_manga_show', ['id' => $manga->getId()]);
        }

        if ($this->isCsrfTokenValid('delete' . $manga->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($manga);
            $entityManager->flush();
        }

        return $this->redirectToRoute('mangashelf_show', ['id' => $manga->getMangashelf()->getId()], Response::HTTP_SEE_OTHER);
    }
}
