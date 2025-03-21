<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class AdminCategoryController extends AbstractController
{
    #[Route('/admin/category', name: 'app_admin_category')]
    public function index(CategoryRepository $CategoryRepository): Response
    {
        $categories = $CategoryRepository->findAll();

        return $this->render('admin_category/index.html.twig', [
            'categories' => $categories
        ]);
    }

    #[Route('/admin/category/{id}', name: 'app_admin_category_show')]
    public function show($id, CategoryRepository $CategoryRepository): Response
    {
        $category = $CategoryRepository->find($id);

        return $this->render('admin_category/show.html.twig', [
            'category' => $category
        ]);
    }


    #[Route('/admin/delete_category/{id}', name: 'app_admin_category_delete')]
    public function delete($id, CategoryRepository $CategoryRepository, EntityManagerInterface $entityManager): Response
    {
        $category = $CategoryRepository->find($id);

        $entityManager->remove($category);
        $entityManager->flush();

        return $this->redirectToRoute('app_admin_category');
    }



    #[Route('/admin/edit_category/{id}', name: 'app_admin_category_edit')]
    public function edit(
        $id,
        CategoryRepository $CategoryRepository,
        EntityManagerInterface $entityManager,
        Request $request,
    ): Response {

        $edit = $CategoryRepository->find($id);
        $form = $this->createForm(CategoryType::class, $edit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($edit);
            $entityManager->flush();
        }

        return $this->render("admin_category/edit.html.twig", parameters: [
            "edit" => $edit,
            "form" => $form->createView()
        ]);
    }









    #[Route('/admin/add_category', name: 'app_admin_category_add')]
    public function add_categ(
        EntityManagerInterface $entityManager,
        Request $request
    ): Response {
        $categ = new Category();
        $form = $this->createForm(CategoryType::class, $categ);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($categ);
            $entityManager->flush();
        }



        return $this->render('admin_category/add.html.twig', [
            'controller_name' => 'AdminCategoryController',
            'form' => $form->createView(),

        ]);
    }
}

    





        // ]);
        // $categ = new Category();
        // $categ->setLabel("Enfants");
        // //persist sert a mettre en file d'attente ce qui va aller en base de données
        // // ATTENTION je ne peut ^pas persist dans le vide , forcement avec une entity
        // $entityManager->persist($categ);
        // // rien besoin en parametre ! il execute juste la file d'attente
        // $entityManager->flush();

        // // afficher le twig
        // return $this->render('admin/category/index.html.twig', [
        //     'controller_name' => 'CategoryController',
        // ]);
//     }
// }
