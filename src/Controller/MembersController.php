<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Form\SearchMembersFormType;
use App\Service\Mail;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Worksheet;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use App\Entity\LegalPerson;
use App\Entity\NaturalPerson;
use App\Form\LegalPersonType;
use App\Form\NaturalPersonType;
use App\Repository\AssociateRepository;
use App\Repository\ExecutiveRepository;
use App\Repository\LegalPersonRepository;
use App\Repository\NaturalPersonRepository;
use App\Repository\OtherParticipantRepository;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route ("/members", name="members_")
 */
class MembersController extends AbstractController
{

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/", name="index")
     */
    public function index(
        Request $request,
        NaturalPersonRepository $naturalPersonRepository,
        LegalPersonRepository $legalPersonRepository,
        AssociateRepository $associateRepository,
        ExecutiveRepository $executiveRepository,
        OtherParticipantRepository $otherParticipantRepository,
        PaginatorInterface $paginator
    ): Response {
        $name = $this->getUser()->getStructure()->getName();
        $id = $this->getUser()->getStructure()->getId();
        $currentDate = Date('d-m-Y');
        $data = new SearchData();
        $persons = [];

        $form = $this->createForm(SearchMembersFormType::class, $data);
        $form->handleRequest($request);

        $template = $request->query->get('ajax') ? '_list.html.twig' : 'index.html.twig';

        if ($form->isSubmitted() && $form->isValid()) {
            if (!empty($form->getData()->getRoles())) {
                switch ($form->getData()->getRoles()) {
                    case 'Associé sortant':
                        $role = $associateRepository->findAssoSorSearch($form->getData(), $id);
                        $pagination = $paginator->paginate(
                            $role,
                            $request->query->getInt('page', 1),
                            10
                        );
                        return $this->render('members/' . $template, [
                            'currentDate' => $currentDate,
                            'roleAsso' => $role,
                            'pagination' => $pagination,
                            'name' => $name,
                            'form' => $form->createView()
                        ]);
                    case 'Ancien associé':
                        $role = $associateRepository->findAncienAssoSearch($form->getData(), $id);
                        $pagination = $paginator->paginate(
                            $role,
                            $request->query->getInt('page', 1),
                            10
                        );
                        return $this->render('members/' . $template, [
                            'currentDate' => $currentDate,
                            'roleAsso' => $role,
                            'pagination' => $pagination,
                            'name' => $name,
                            'form' => $form->createView()
                        ]);
                    case 'Associé':
                        $role = $associateRepository->findAssoSearch($form->getData(), $id);
                        $pagination = $paginator->paginate(
                            $role,
                            $request->query->getInt('page', 1),
                            10
                        );
                        return $this->render('members/' . $template, [
                            'currentDate' => $currentDate,
                            'roleAsso' => $role,
                            'pagination' => $pagination,
                            'name' => $name,
                            'form' => $form->createView()
                        ]);
                    case 'Exécutif':
                        $role = $executiveRepository->findExeSearch($form->getData(), $id);
                        $pagination = $paginator->paginate(
                            $role,
                            $request->query->getInt('page', 1),
                            10
                        );
                        return $this->render('members/' . $template, [
                            'currentDate' => $currentDate,
                            'roleExe' => $role,
                            'pagination' => $pagination,
                            'name' => $name,
                            'form' => $form->createView()
                        ]);
                    case 'Autres':
                        $role = $otherParticipantRepository->findOtherSearch($form->getData(), $id);
                        $pagination = $paginator->paginate(
                            $role,
                            $request->query->getInt('page', 1),
                            10
                        );
                        return $this->render('members/' . $template, [
                            'currentDate' => $currentDate,
                            'roleOther' => $role,
                            'pagination' => $pagination,
                            'name' => $name,
                            'form' => $form->createView()
                        ]);
                }
            }
            if (empty($form->getData()->getRoles()) && !empty($form->getData()->getSearch())) {
                $structureLegal = $legalPersonRepository->findSearch($form->getData(), $id);
                $structureNatural = $naturalPersonRepository->findSearch($form->getData(), $id);

                foreach ($structureNatural as $person) {
                    $persons[] = $person;
                }

                foreach ($structureLegal as $person) {
                    $persons[] = $person;
                }
                $pagination = $paginator->paginate(
                    $persons, // Requête contenant les données à paginer
                    $request->query->getInt('page', 1),
                    10 // Nombre de résultats par page
                );
                return $this->render('members/' . $template, [
                    'currentDate' => $currentDate,
                    'persons' => $persons,
                    'pagination' => $pagination,
                    'name' => $name,
                    'form' => $form->createView()
                ]);
            }
        }

        $structureNatural = $naturalPersonRepository->findByPers($id);
        $structureLegal = $legalPersonRepository->findByPers($id);

        foreach ($structureNatural as $person) {
            $persons[] = $person;
        }

        foreach ($structureLegal as $person) {
            $persons[] = $person;
        }

        $pagination = $paginator->paginate(
            $persons, // Requête contenant les données à paginer
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            10 // Nombre de résultats par page
        );
        return $this->render('members/' . $template, [
            'currentDate' => $currentDate,
            'persons' => $persons,
            'pagination' => $pagination,
            'name' => $name,
            'form' => $form->createView()
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/newlegal", name="newlegal", methods={"GET","POST"})
     */
    public function newLegal(Request $request): Response
    {
        $legalPerson = new LegalPerson();
        $form = $this
            ->createForm(
                LegalPersonType::class,
                $legalPerson,
                array('id' => $this->getUser()->getStructure()->getId())
            );


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($legalPerson);
            $legalPerson->getAssociate()->setStructure($this->getUser()->getStructure());
            $legalPerson->getExecutive()->setStructure($this->getUser()->getStructure());
            $legalPerson->setStructure($this->getUser()->getStructure());
            $entityManager->flush();

            if ($request->isXmlHttpRequest()) {
                return new Response(null, 204);
            }
            return $this->redirectToRoute('members_index');
        }

        $template = $request->isXmlHttpRequest() ? '_legalform.html.twig' : 'new.html.twig';

        return $this->render(
            'members/' . $template,
            [
                'legal_person' => $legalPerson,
                'form' => $form->createView(),
            ],
            new Response(
                null,
                $form->isSubmitted() ? 422 : 200
            )
        );
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/newnatural", name="newnatural", methods={"GET","POST"})
     */
    public function newNatural(Request $request): Response
    {
        $naturalPerson = new NaturalPerson();
        $form = $this->createForm(
            NaturalPersonType::class,
            $naturalPerson
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($naturalPerson);
            $naturalPerson->getAssociate()->setStructure($this->getUser()->getStructure());
            $naturalPerson->getExecutive()->setStructure($this->getUser()->getStructure());
            $naturalPerson->setStructureMember($this->getUser()->getStructure());
            $entityManager->flush();

            if ($request->isXmlHttpRequest()) {
                return new Response(null, 204);
            }
            return $this->redirectToRoute('members_index');
        }

        $template = $request->isXmlHttpRequest() ? '_naturalform.html.twig' : 'new.html.twig';

        return $this->render(
            'members/' . $template,
            [
                'natural_person' => $naturalPerson,
                'form' => $form->createView(),
            ],
            new Response(
                null,
                $form->isSubmitted() ? 422 : 200
            )
        );
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/{id}/shownatural", name="showNatural", methods={"GET"})
     */
    public function showNatural(NaturalPerson $naturalPerson): Response
    {
        if ($this->getUser()->getStructure() == $naturalPerson->getStructureMember()) {
            return $this->render('members/naturalshow.html.twig', [
                'naturalPerson' => $naturalPerson,
            ]);
        }
        return $this->redirectToRoute('members_index');
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/{id}/showlegal", name="showLegal", methods={"GET"})
     */
    public function showLegal(LegalPerson $legalPerson): Response
    {
        if ($this->getUser()->getStructure() == $legalPerson->getStructure()) {
            return $this->render('members/legalshow.html.twig', [
                'legalPerson' => $legalPerson,
            ]);
        }
        return $this->redirectToRoute('members_index');
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/{id}/editlegal", name="editLegal", methods={"GET","POST"})
     */
    public function editLegal(Request $request, LegalPerson $legalPerson): Response
    {
        if ($this->getUser()->getStructure() == $legalPerson->getStructure()) {
            $form = $this->createForm(
                LegalPersonType::class,
                $legalPerson,
                array('id' => $this->getUser()->getStructure()->getId())
            );
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('members_index');
            }
            return $this->render('members/editlegal.html.twig', [
                'legalPerson' => $legalPerson,
                'form' => $form->createView(),
            ]);
        }

        return $this->redirectToRoute('members_index');
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/{id}/editnatural", name="editNatural", methods={"GET","POST"})
     */
    public function editNatural(Request $request, NaturalPerson $naturalPerson): Response
    {
        if ($this->getUser()->getStructure() == $naturalPerson->getStructureMember()) {
            $form = $this->createForm(
                NaturalPersonType::class,
                $naturalPerson
            );
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->getDoctrine()->getManager()->flush();
                return $this->redirectToRoute('members_index');
            }

            return $this->render('members/editnatural.html.twig', [
                'naturalPerson' => $naturalPerson,
                'form' => $form->createView(),
            ]);
        }
        return $this->redirectToRoute('members_index');
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/{id}/deleteLegal", name="deleteLegal", methods={"GET","POST"})
     */
    public function deleteLegal(Request $request, LegalPerson $legalPerson): Response
    {
        if ($this->getUser()->getStructure() == $legalPerson->getStructure()) {
            if ($this->isCsrfTokenValid('delete' . $legalPerson->getId(), $request->request->get('_token'))) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($legalPerson);
                $entityManager->flush();
            }
        }
        return $this->redirectToRoute('members_index');
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/{id}/deleteNatural", name="deleteNatural", methods={"GET","POST"})
     */
    public function deleteNatural(Request $request, NaturalPerson $naturalPerson): Response
    {
        if ($this->getUser()->getStructure() == $naturalPerson->getStructureMember()) {
            if ($this->isCsrfTokenValid('delete' . $naturalPerson->getId(), $request->request->get('_token'))) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($naturalPerson);
                $entityManager->flush();
            }
        }
        return $this->redirectToRoute('members_index');
    }

    private function getLegalPersonData(): array
    {
        $list = [];
        $id = $this->getUser()->getStructure()->getId();
        $legalPersons = $this->entityManager->getRepository(LegalPerson::class)->findByPers($id);
        /**@var $legalPerson LegalPerson */
        foreach ($legalPersons as $legalPerson) {
            $list[] = [
                $legalPerson->getName(),
                $legalPerson->getCompanyForm(),
                $legalPerson->getEmail(),
                $legalPerson->getTelephone(),
                $legalPerson->getSiren(),
                $legalPerson->getTradeAndCompagnyRegister(),
                $legalPerson->getRegisterCapital(),
                $legalPerson->getDescription(),
                $legalPerson->getAssociate()->formatDate($legalPerson->getAssociate()->getSubscriptionDate()),
                $legalPerson->getAssociate()->formatDate($legalPerson->getAssociate()->getWithdrawalRequestDate()),
                $legalPerson->getAssociate()->convertNameTable($legalPerson->getAssociate()->getCollege()),
                $legalPerson->getExecutive()->formatDate($legalPerson->getExecutive()->getMandateStartdate()),
                $legalPerson->getExecutive()->formatDate($legalPerson->getExecutive()->getMandateEnddate()),
                $legalPerson->getOtherParticipant()->getOtherParticipantRole()
            ];
        }

        return $list;
    }

    private function getNaturalPersonData(): array
    {
        $list = [];
        $id = $this->getUser()->getStructure()->getId();
        $naturalPersons = $this->entityManager->getRepository(NaturalPerson::class)->findByPers($id);
        /**@var $naturalPerson NaturalPerson */
        foreach ($naturalPersons as $naturalPerson) {
            $list[] = [
                $naturalPerson->getGender(),
                $naturalPerson->getFirstname(),
                $naturalPerson->getLastname(),
                $naturalPerson->getDateOfBirth(),
                $naturalPerson->getPlaceOfBirth(),
                $naturalPerson->getEmail(),
                $naturalPerson->getTelephone(),
                $naturalPerson->getTelephone2(),
                $naturalPerson->getAssociate()->formatDate($naturalPerson->getAssociate()->getSubscriptionDate()),
                $naturalPerson->getAssociate()->formatDate($naturalPerson->getAssociate()->getWithdrawalRequestDate()),
                $naturalPerson->getAssociate()->convertNameTable($naturalPerson->getAssociate()->getCollege()),
                $naturalPerson->getExecutive()->formatDate($naturalPerson->getExecutive()->getMandateStartdate()),
                $naturalPerson->getExecutive()->formatDate($naturalPerson->getExecutive()->getMandateEnddate()),
                $naturalPerson->getOtherParticipant()->getOtherParticipantRole()
            ];
        }

        return $list;
    }

    /**
     * @Route("/export", name="export")
     * @IsGranted("ROLE_USER")
     */
    public function export(): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $spreadsheet = new Spreadsheet();
        /* @var $sheet Worksheet */
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Name')
            ->setCellValue('B1', 'Company')
            ->setCellValue('C1', 'Mail')
            ->setCellValue('D1', 'Telephone')
            ->setCellValue('E1', 'Siren')
            ->setCellValue('F1', 'Trade and Company Register')
            ->setCellValue('G1', 'Register Capital')
            ->setCellValue('H1', 'Description')
            ->setCellValue('I1', 'Associate - Début')
            ->setCellValue('J1', 'Associate - Fin')
            ->setCellValue('K1', 'Collège')
            ->setCellValue('L1', 'Executif - Début')
            ->setCellValue('M1', 'Executif - Fin')
            ->setCellValue('N1', 'Autre Rôle');
        $sheet = $spreadsheet->getActiveSheet()->setTitle('LegalPerson');

        $sheet->fromArray($this->getLegalPersonData(), null, 'A2', true);

        $spreadsheet->createSheet();

        $spreadsheet->setActiveSheetIndex(1)
            ->setCellValue('A1', 'Gender')
            ->setCellValue('B1', 'FirstName')
            ->setCellValue('C1', 'LastName')
            ->setCellValue('D1', 'DOB')
            ->setCellValue('E1', 'POB')
            ->setCellValue('F1', 'Mail')
            ->setCellValue('G1', 'Telephone1')
            ->setCellValue('H1', 'Telephone2')
            ->setCellValue('I1', 'Associate - Début')
            ->setCellValue('J1', 'Associate - Fin')
            ->setCellValue('K1', 'Collège')
            ->setCellValue('L1', 'Executif - Début')
            ->setCellValue('M1', 'Executif - Fin')
            ->setCellValue('N1', 'Autre Rôle');
        $sheetNaturalPerson = $spreadsheet->getActiveSheet()->setTitle('Natural Person');
        $sheetNaturalPerson->fromArray($this->getNaturalPersonData(), null, 'A2', true);

        $spreadsheet->setActiveSheetIndex(0);
        // Create your Office 2007 Excel (XLSX Format)
        $writer = new Xlsx($spreadsheet);
        // Create a Temporary file in the system
        $fileName = 'members.xlsx';
        $tempFile = tempnam(sys_get_temp_dir(), $fileName);
        // Create the excel file in the tmp directory of the system
        $writer->save($tempFile);

        // Return the excel file as an attachment
        return $this->file($tempFile, $fileName, ResponseHeaderBag::DISPOSITION_INLINE);
    }

    /**
     * @Route("/sendMail", name="sendMail", methods={"POST"})
     * @IsGranted("ROLE_USER")
     */

    public function sendMail(
        Request $request,
        NaturalPersonRepository $naturalPersonRepository,
        LegalPersonRepository $legalPersonRepository
    ) {
        $employeeOrLegalEntityIds = $request->request->get('employeeOrLegalEntityIds');

        $legalEntitiesIds = [];
        $naturalPersonsIds = [];
        $allMailsAddresses = [];


        foreach ($employeeOrLegalEntityIds as $id) {
            $idExplode = explode("_", $id);

            if ($idExplode[0] === 'np') {
                $naturalPersonsIds[] = $idExplode[1];
            }
            if ($idExplode[0] === 'le') {
                $legalEntitiesIds[] = $idExplode[1];
            }
            if ($idExplode[0] === 'anp') {
                $naturalPersonsIds[] = $idExplode[1];
            }
            if ($idExplode[0] === 'ale') {
                $legalEntitiesIds[] = $idExplode[1];;
            }
            if ($idExplode[0] === 'enp') {
                $naturalPersonsIds[] = $idExplode[1];
            }
            if ($idExplode[0] === 'ele') {
                $legalEntitiesIds[] = $idExplode[1];;
            }
            if ($idExplode[0] === 'onp') {
                $naturalPersonsIds[] = $idExplode[1];
            }
            if ($idExplode[0] === 'ole') {
                $legalEntitiesIds[] = $idExplode[1];;
            }
        }
        foreach ($naturalPersonsIds as $naturalPersonsId) {
            $naturalPerson = $naturalPersonRepository->find($naturalPersonsId);
            $allMailsAddresses[] = $naturalPerson->getEmail();
        }
        foreach ($legalEntitiesIds as $legalEntitiesId) {
            $legalEntity = $legalPersonRepository->find($legalEntitiesId);
            $allMailsAddresses[] = $legalEntity->getEmail();
        }

        foreach ($allMailsAddresses as $allMailsAddress) {
            $mail = new Mail();
            $mail->send($allMailsAddress, 'Wissam Taleb', 'TesT Mail', 'Test FINALE');
        }

        return new Response('OK');
    }
}
