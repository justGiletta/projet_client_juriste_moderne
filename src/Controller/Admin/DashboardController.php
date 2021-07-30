<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use App\Entity\User;
use App\Entity\Structure;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

/**
 * @IsGranted("ROLE_SUPERADMIN")
 */
class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/superadmin", name="superadmin")
     */
    public function index(): Response
    {
        $user = $this->getUser();
        $user->setStructure(null);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('<h1 class="text-end" style="font-weight: bold; font-style: italic">SUPER-ADMIN</h1>')
            ->setFaviconPath('build/images/Logos/faviconJM.png')
            ->renderContentMaximized();
    }

    public function configureCrud(): Crud
    {
        return Crud::new()
        ->renderContentMaximized()
        ->setPaginatorPageSize(30)
        ->setPaginatorRangeSize(3)
        ;
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::section('<img src="/build/images/Logos/LogoLJMBWhite.png">');
        yield MenuItem::linkToCrud('Structures', '', Structure::class);
        yield MenuItem::linkToCrud('Utilisateurs', '', User::class);
    }

    public function configureAssets(): Assets
    {
        return Assets::new()->addCssFile('build/superAdmin.css');
    }
}
