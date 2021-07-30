<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Structure;
use App\Entity\User;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use App\Service\Slugify;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/category")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/{id}", name="category_index", methods={"GET"})
     * @IsGranted("ROLE_USER")
     */
    public function index(CategoryRepository $categoryRepository, Structure $structure): Response
    {
        return $this->render('category/index.html.twig', [
            'categories' => $categoryRepository->findBy(
                ['structure' => $structure->getId()],
            ),
        ]);
    }

    /**
     * @Route("/{id}/new", name="category_new", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function new(Request $request, Slugify $slugify, Structure $structure): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $slug = $slugify->generate($category->getDescription());
            $category->setSlug($slug);
            $category->setStructure($structure);
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('category_index', ['id' => $structure->getId()]);
        }

        return $this->render('category/new.html.twig', [
            'category' => $category,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idStructure}/edit/{slug}", name="category_edit", methods={"GET","POST"})
     * @ParamConverter("structure", class="App\Entity\Structure", options={"mapping": {"idStructure": "id"}})
     * @ParamConverter("category", class="App\Entity\Category", options={"mapping": {"slug": "slug"}})
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, Category $category): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('category_index', ['id' => $category->getStructure()->getId()]);
        }

        return $this->render('category/edit.html.twig', [
            'category' => $category,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("delete/{slug}", name="category_delete", methods={"POST"})
     * @ParamConverter("category", class="App\Entity\Category", options={"mapping": {"slug": "slug"}})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, Category $category): Response
    {
        if ($this->isCsrfTokenValid('delete' . $category->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($category);
            $entityManager->flush();
        }

        return $this->redirectToRoute('category_index', ['id' => $category->getStructure()->getId()]);
    }
}
