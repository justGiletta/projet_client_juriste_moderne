<?php

namespace App\Controller;

use App\Entity\Structure;
use App\Form\StructureType;
use App\Repository\AssociateRepository;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use Doctrine\ORM\EntityManagerInterface;
use Dompdf\Dompdf;
use Dompdf\Options;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Route("/structure")
 */
class StructureController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    private function grantAccessToSuperAdmin(UserInterface $user, Structure $structure)
    {
        if (in_array('ROLE_SUPERADMIN', $user->getRoles())) {
            $user = $this->getUser();
            $user->setStructure($structure);
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        }
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/{id}", name="structure_index", methods={"GET"})
     */
    public function index(AssociateRepository $associateRepository, Structure $structure): Response
    {
        $this->grantAccessToSuperAdmin($this->getUser(), $structure);
        $associates = $associateRepository->findBy(['structure' => $structure->getId()]);
        $pieChart = new PieChart();
        $unitValue = $structure->getShareUnitValue();
        $totalNumberofShare = 0;
        $paidUpCapitalTotal = 0;
        $suscribedCapitalTotal = 0;
        $tobePaidUpCapitalTotal = 0;
        if (!empty($associates)) {
            foreach ($associates as $associate) {
                $subscriptionDate = $associate->getSubscriptionDate();
                $repaymentDate = $associate->getRepaymentDate();

                if ($subscriptionDate && !$repaymentDate) {
                    $numberOfShare = $associate->getNumberOfShare();
                    $totalNumberofShare += $numberOfShare;

                    $subscribedCapitalAmountPaidUp = $associate->getSubscribedCapitalAmountPaidUp();
                    $paidUpCapitalTotal += $subscribedCapitalAmountPaidUp;
                }

                $suscribedCapitalTotal = $totalNumberofShare * $unitValue ;
                $tobePaidUpCapitalTotal = $suscribedCapitalTotal - $paidUpCapitalTotal ;
            };

            $pieChart->getData()->setArrayToDataTable(
                [['Capital', '€'],
                ['Libéré', $paidUpCapitalTotal],
                ['À libérer', $tobePaidUpCapitalTotal],
                ]
            );
            $pieChart->getOptions()->setHeight(250);
            $pieChart->getOptions()->setWidth(350);
            $pieChart->getOptions()->setColors(['#64B3B4', '#697988']);
            $pieChart->getOptions()->setBackgroundColor('transparent');
            $pieChart->getOptions()->getLegend()->setPosition('bottom');
            $pieChart->getOptions()->setTitle('VALEUR UNITAIRE DU TITRE : ' . $unitValue . ' €');
            $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
            $pieChart->getOptions()->getTitleTextStyle()->setColor('#212529');
            $pieChart->getOptions()->getTitleTextStyle()->setFontName('Roboto');
            $pieChart->getOptions()->getTitleTextStyle()->setFontSize(16);
        }

        return $this->render('structure/index.html.twig', [
            'structure' => $structure,
            'associates' => $associates,
            'piechart' => $pieChart,
            'totalNumberofShare' => $totalNumberofShare,
            'suscribedCapitalTotal' => $suscribedCapitalTotal,
            'paidUpCapitalTotal' => $paidUpCapitalTotal,
            'tobePaidUpCapitalTotal' => $tobePaidUpCapitalTotal,
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/detail/{id}", name="structure_show", methods={"GET"})
     */
    public function show(Structure $structure): Response
    {
        $this->grantAccessToSuperAdmin($this->getUser(), $structure);
        return $this->render('structure/showStructure.html.twig', [
            'structure' => $structure,
        ]);
    }

    /**
     * @Route("/{id}/edit-structure", name="structure_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function editStructure(Request $request, Structure $structure): Response
    {
        $this->grantAccessToSuperAdmin($this->getUser(), $structure);
        $form = $this
            ->createForm(StructureType::class, $structure)
            ->remove('email')
            ->remove('telephone')
            ->remove('telephone2')
            ->remove('addresses')
            ->remove('registeredCapital');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('structure_show', ['id' => $structure->getId()]);
        }

        return $this->render('structure/editStructure.html.twig', [
            'structure' => $structure,
            'structureForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit-contact", name="contact_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function editContact(Request $request, Structure $structure): Response
    {
        $this->grantAccessToSuperAdmin($this->getUser(), $structure);
        $form = $this
            ->createForm(StructureType::class, $structure)
                ->remove('name')
                ->remove('siren')
                ->remove('tradeAndCompanyRegister')
                ->remove('companyForm')
                ->remove('description')
                ->remove('registeredCapital')
                ->remove('mainRepresentative')
                ->remove('addresses')
                ->remove('secondRepresentative');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('structure_show', ['id' => $structure->getId()]);
        }

        return $this->render('structure/editContact.html.twig', [
            'structure' => $structure,
            'contactForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/dowload_presentation", name="structure_dowload", methods={"GET"})
     * @IsGranted("ROLE_USER")
     */
    public function dowloadPresentation(AssociateRepository $associateRepository, Structure $structure): Response
    {
        // PieCharts
        $associates = $associateRepository->findBy(['structure' => $structure->getId()]);

        $unitValue = $structure->getShareUnitValue();
        $totalNumberofShare = 0 ;
        $paidUpCapitalTotal = 0;
        foreach ($associates as $associate) {
            $subscriptionDate = $associate->getSubscriptionDate();
            $repaymentDate = $associate->getRepaymentDate();

            if ($subscriptionDate && !$repaymentDate) {
                $numberOfShare = $associate->getNumberOfShare();
                $totalNumberofShare += $numberOfShare;

                $subscribedCapitalAmountPaidUp = $associate->getSubscribedCapitalAmountPaidUp();
                $paidUpCapitalTotal += $subscribedCapitalAmountPaidUp;
            }

            $suscribedCapitalTotal = $totalNumberofShare * $unitValue ;
            $tobePaidUpCapitalTotal = $suscribedCapitalTotal - $paidUpCapitalTotal ;
        };

        $pieChart = new PieChart();
        $pieChart->getData()->setArrayToDataTable(
            [['Capital', '€'],
            ['Libéré', $paidUpCapitalTotal],
            ['À libérer', $tobePaidUpCapitalTotal],
            ]
        );
        $pieChart->getOptions()->setHeight(250);
        $pieChart->getOptions()->setWidth(350);
        $pieChart->getOptions()->setColors(['#64B3B4', '#697988']);
        $pieChart->getOptions()->setBackgroundColor('#ebebeb');
        $pieChart->getOptions()->getLegend()->setPosition('bottom');

        // Dompdf
        $options = new Options();
        $options->set('defaultFont', 'Roboto');
        $options->setIsHtml5ParserEnabled(true);
        $options->setIsRemoteEnabled(true);
        $options->set('isJavascriptEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($this->renderView('structure/download.html.twig', [
            'structure' => $structure,
            'associates' => $associates,
            'piechart' => $pieChart,
            'totalNumberofShare' => $totalNumberofShare,
            'suscribedCapitalTotal' => $suscribedCapitalTotal,
            'paidUpCapitalTotal' => $paidUpCapitalTotal,
            'tobePaidUpCapitalTotal' => $tobePaidUpCapitalTotal,
        ]));
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $html = 'dossier_presentation_' . $structure->getName() . '.pdf';
        $dompdf->stream($html, [
            'Attachement' => true,
        ]);

        return new Response();
    }
}
