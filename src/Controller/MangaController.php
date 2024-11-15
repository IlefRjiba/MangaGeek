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
        return $this->render('manga/index.html.twig', [
            'mangas' => $mangaRepository->findAll(),
        ]);
    }

    #[Route('/new/{id}', name: 'app_manga_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, Mangashelf $mangashelf): Response
    {
        $manga = new Manga();
        $manga->setMangashelf($mangashelf);
        $form = $this->createForm(MangaType::class, $manga);
        $form->handleRequest($request);

        $valid=false;
        $submitted=$form->isSubmitted();
        dump($submitted);
        if($submitted) {
            $valid=$form->isValid();
            dump($valid);
        }

        if ($submitted && $valid) {
            // $imagefile = $manga->getImageFile();
            //  if($imagefile) {
            //          $mimetype = $imagefile->getMimeType();
            //          $manga->setContentType($mimetype);
            //  }
            $entityManager->persist($manga);
            $entityManager->flush();

            $this->addFlash('success', 'Nouveau manga ajouté');

            return $this->redirectToRoute('mangashelf_show', 
                                        ['id' => $manga->getMangashelf()->getId()], Response::HTTP_SEE_OTHER);
        }

        if(! $valid && $submitted) {
            $this->addFlash('error', 'Manga wasn\'t added');
            $errors = $form->getErrors(true);
    
            foreach($errors as $error) {
                dump($error);
    
                if($error instanceof FileUploadError) {
                    $form->addError($error);
                }
            }
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
        $form = $this->createForm(MangaType::class, $manga);
        $form->handleRequest($request);

        if ($form->isSubmitted()){ 
            
            if($form->isValid()) {
            $entityManager->flush();

            $this->addFlash('message', 'Manga updated successfully');
            return $this->redirectToRoute('app_manga_index', [], Response::HTTP_SEE_OTHER);
                                }
            
            else{
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
        if ($this->isCsrfTokenValid('delete'.$manga->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($manga);
            $entityManager->flush();
        }

        // return $this->redirectToRoute('mangashelf_show', [], Response::HTTP_SEE_OTHER);
        return $this->redirectToRoute('mangashelf_show', ['id' => $manga->getMangashelf()->getId()], Response::HTTP_SEE_OTHER);
    }
}
