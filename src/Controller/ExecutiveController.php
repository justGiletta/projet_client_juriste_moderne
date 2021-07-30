<?php

namespace App\Controller;

use App\Entity\Executive;
use App\Entity\Structure;
use App\Form\ExecutiveType;
use App\Repository\ExecutiveRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/executive")
 */
class ExecutiveController extends AbstractController
{
    /**
     * @Route("/{id}", name="executive_index", methods={"GET"})
     * @IsGranted("ROLE_USER")
     */
    public function index(ExecutiveRepository $executiveRepository, Structure $structure): Response
    {
        return $this->render('executive/index.html.twig', [
            'executives' => $executiveRepository->findBy(
                ['structure' => $structure->getId()],
            ),
        ]);
    }
}
