<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @IsGranted("ROLE_SUPERADMIN")
 */
class UserCrudController extends AbstractCrudController
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    public static function getEntityFqcn(): string
    {
        return User::class;
    }
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setLabel('Ajouter');
            })
            ->add(Crud::PAGE_INDEX, Action::DETAIL, function (Action $action) {
                return $action->setLabel('Voir détail');
            })
            ->add(Crud::PAGE_NEW, Action::NEW);
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', '<h2 class="text-center" style="font-weight: bold;">Liste des utilisateurs</h2>')
            ->setPageTitle('new', '<h2 class="text-center" style="font-weight: bold;">Ajouter un utilisateur</h2>')
            ->setPageTitle('edit', '<h2 class="text-center" style="font-weight: bold;">Modifier un utilisateur</h2>')
            ->setPageTitle(
                'detail',
                '<h2 class="text-center" style="font-weight: bold;">Détails de l\'utilisateur</h2>'
            );
    }
    public function configureFields(string $pageName): iterable
    {
        $email = EmailField::new('email', 'Email');
        $firstname = TextField::new('firstname', 'Prénom');
        $lastname = TextField::new('lastname', 'Nom');
        $roles = ChoiceField::new('roles', 'Roles')
            ->allowMultipleChoices()
            ->autocomplete()
            ->setChoices([
                'User' => 'ROLE_USER',
                'Admin' => 'ROLE_ADMIN',
                'SuperAdmin' => 'ROLE_SUPERADMIN'
            ]);
        $password = 'password';
        $structure = AssociationField::new('structure', 'Structure');
        $isVerified = BooleanField::new('isVerified', 'Email vérifié');

        if (Crud::PAGE_INDEX === $pageName || Crud::PAGE_EDIT === $pageName || Crud::PAGE_DETAIL === $pageName) {
            return [$firstname, $lastname, $email, $roles, $structure, $isVerified];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$firstname, $lastname, $email, $roles, $password, $structure, $isVerified];
        }
    }
}
