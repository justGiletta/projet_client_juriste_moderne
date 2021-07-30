<?php

namespace App\Controller\Admin;

use App\Entity\Structure;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("ROLE_SUPERADMIN")
 */
class StructureCrudController extends AbstractCrudController
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public static function getEntityFqcn(): string
    {
        return Structure::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        $details = Action::new('detail', 'Détails')
            ->linkToRoute('structure_index', function (Structure $structure): array {
                return [
                    'id' => $structure->getId(),
                ];
            });
        return $actions
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setLabel('Ajouter');
            })
            ->add(Crud::PAGE_INDEX, $details, function (Action $action) {
                return $action->setLabel('Détails');
            })
        ;
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', '<h2 class="text-center" style="font-weight: bold;">Liste des structures</h2>')
            ->setPageTitle('new', '<h2 class="text-center" style="font-weight: bold;">Ajouter une structure</h2>')
            ->setPageTitle('edit', '<h2 class="text-center" style="font-weight: bold;">Modifier une structure</h2>')
            ->setPageTitle('detail', '<h2 class="text-center" style="font-weight: bold;">Détails de la structure</h2>')
            ;
    }
    public function configureFields(string $pageName): iterable
    {
        $name = TextField::new('name', 'Nom de la structure');
        $siren = IntegerField::new('siren');
        $tradeAndCompanyRegister = TextField::new('tradeAndCompanyRegister', 'Registre du commerce et des sociétés');
        $registeredCapital = MoneyField::new('registeredCapital', 'Capital social')
            ->setCurrency('EUR');
        $companyForm = TextField::new('companyForm', 'Forme');
        $mainRepresentative = AssociationField::new('mainRepresentative', '1er représentant');
        $secondRepresentative = AssociationField::new('secondRepresentative', '2ème représentant');
        $email = EmailField::new('email', 'Email');
        $telephone = TelephoneField::new('telephone', 'Telephone1');
        $telephone2 = TelephoneField::new('telephone2', 'Telephone2');
        if (Crud::PAGE_INDEX === $pageName || Crud::PAGE_DETAIL === $pageName) {
            return [$name, $siren, $tradeAndCompanyRegister, $registeredCapital, $companyForm,];
        } elseif (Crud::PAGE_NEW === $pageName || Crud::PAGE_EDIT === $pageName) {
            return [$name, $siren, $tradeAndCompanyRegister, $registeredCapital, $companyForm, $mainRepresentative,
                $secondRepresentative, $email, $telephone, $telephone2,
            ];
        }
    }
}
