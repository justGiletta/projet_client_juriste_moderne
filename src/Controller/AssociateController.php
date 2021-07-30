<?php

namespace App\Controller;

use App\Entity\Structure;
use App\Repository\AssociateRepository;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/associate")
 */
class AssociateController extends AbstractController
{
    /**
     * @Route("/{id}", name="associate_index", methods={"GET"})
     * @IsGranted("ROLE_USER")
     */
    public function index(AssociateRepository $associateRepository, Structure $structure): Response
    {
        return $this->render('associate/index.html.twig', [
            'associates' => $associateRepository->findBy(
                ['structure' => $structure->getId()],
            ),
        ]);
    }

    /**
     * @Route("/{id}/capital", name="capital_show", methods={"GET"})
     * @IsGranted("ROLE_USER")
     */
    public function show(AssociateRepository $associateRepository, Structure $structure): Response
    {
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

        return $this->render('associate/showCapital.html.twig', [
            'structure' => $structure,
            'associates' => $associates,
            'piechart' => $pieChart,
            'totalNumberofShare' => $totalNumberofShare,
            'suscribedCapitalTotal' => $suscribedCapitalTotal,
            'paidUpCapitalTotal' => $paidUpCapitalTotal,
            'tobePaidUpCapitalTotal' => $tobePaidUpCapitalTotal,
        ]);
    }
}
