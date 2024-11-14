<?php

namespace App\Controller;

use App\Entity\Member;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\MemberRepository;

class MembreController extends AbstractController
{
    #[Route('/member', name: 'app_membre')]
    public function index(MemberRepository $MemberRepository): Response
    {
        return $this->render('membre/index.html.twig', [
            'controller_name' => 'MembreController',
            'members'=> $MemberRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_member_show', methods: ['GET'])]
    public function show(Member $member): Response
    {
        return $this->render('membre/show.html.twig', [
            'member' => $member,
        ]);
    }

}
