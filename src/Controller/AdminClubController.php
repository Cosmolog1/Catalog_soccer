<?php

namespace App\Controller;

use App\Entity\Club;
use App\Form\ClubType;
use App\Repository\CategoryRepository;
use App\Repository\ClubRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class AdminClubController extends AbstractController
{
    #[Route('/admin/club', name: 'app_admin_club')]
    public function index(ClubRepository $ClubRepository): Response
    {
        $clubs = $ClubRepository->findAll();

        return $this->render('admin_club/index.html.twig', [
            'clubs' => $clubs
        ]);
    }


    #[Route('/admin/club/{id}', name: 'app_admin_club_show')]
    public function show($id, ClubRepository $ClubRepository): Response
    {
        $club = $ClubRepository->find($id);


        return $this->render('admin_club/show.html.twig', [
            'club' => $club,

        ]);
    }


    #[Route('/admin/delete_club/{id}', name: 'app_admin_club_delete')]
    public function delete($id, ClubRepository $ClubRepository, EntityManagerInterface $entityManager): Response
    {
        $club = $ClubRepository->find($id);

        $entityManager->remove($club);
        $entityManager->flush();

        return $this->redirectToRoute('app_admin_club');
    }

    #[Route('/admin/edit_club/{id}', name: 'app_admin_club_edit')]
    public function edit(
        $id,
        ClubRepository $ClubRepository,
        EntityManagerInterface $entityManager,
        Request $request,
    ): Response {

        $club = $ClubRepository->find($id);
        $form = $this->createForm(ClubType::class, $club);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($club);
            $entityManager->flush();
        }

        return $this->render("admin_club/edit.html.twig", parameters: [
            "club" => $club,
            "form" => $form->createView()
        ]);
    }


    #[Route('/admin/add_club', name: 'app_admin_club_add')]
    public function add_club(
        EntityManagerInterface $entityManager,
        Request $request
    ): Response {
        $club = new Club();
        $form = $this->createForm(ClubType::class, $club);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($club);
            $entityManager->flush();
        }



        return $this->render('admin_club/add.html.twig', [
            'controller_name' => 'AdminClubController',
            'form' => $form->createView(),

        ]);
    }
}
