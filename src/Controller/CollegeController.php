<?php

namespace App\Controller;

use App\Entity\College;
use App\Entity\Structure;
use App\Form\CollegeType;
use App\Repository\CollegeRepository;
use App\Service\Slugify;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/college")
 */
class CollegeController extends AbstractController
{
    /**
     * @Route("/{id}", name="college_index", methods={"GET"})
     * @IsGranted("ROLE_USER")
     */
    public function index(CollegeRepository $collegeRepository, Structure $structure): Response
    {
        return $this->render('college/index.html.twig', [
            'colleges' => $collegeRepository->findBy(
                ['structure' => $structure->getId()],
            ),
        ]);
    }

    /**
     * @Route("/{id}/new", name="college_new", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function new(Request $request, Slugify $slugify, Structure $structure): Response
    {
        $college = new College();
        $form = $this->createForm(CollegeType::class, $college);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $slug = $slugify->generate($college->getPrefixClassification());
            $college->setSlug($slug);
            $college->setStructure($structure);
            $entityManager->persist($college);
            $entityManager->flush();

            return $this->redirectToRoute('college_index', ['id' => $college->getStructure()->getId()]);
        }

        return $this->render('college/new.html.twig', [
            'college' => $college,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idStructure}/edit/{slug}", name="college_edit", methods={"GET","POST"})
     * @ParamConverter("structure", class="App\Entity\Structure", options={"mapping": {"idStructure": "id"}})
     * @ParamConverter("college", class="App\Entity\College", options={"mapping": {"slug": "slug"}})
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, College $college): Response
    {
        $form = $this->createForm(CollegeType::class, $college);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('college_index', ['id' => $college->getStructure()->getId()]);
        }

        return $this->render('college/edit.html.twig', [
            'college' => $college,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{slug}", name="college_delete", methods={"POST"})
     * @ParamConverter("college", class="App\Entity\College", options={"mapping": {"slug": "slug"}})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, College $college): Response
    {
        if ($this->isCsrfTokenValid('delete' . $college->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($college);
            $entityManager->flush();
        }

        return $this->redirectToRoute('college_index', ['id' => $college->getStructure()->getId()]);
    }
}
