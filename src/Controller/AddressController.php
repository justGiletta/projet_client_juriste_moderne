<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\Structure;
use App\Form\AddressType;
use App\Repository\AddressRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/address")
 * @IsGranted("ROLE_USER")
 */
class AddressController extends AbstractController
{
    /**
     * @Route("/{id}", name="address_index", methods={"GET"})
     * @ParamConverter("structure", class="App\Entity\Structure", options={"mapping": {"id": "id"}})
     */
    public function index(AddressRepository $addressRepository, Structure $structure): Response
    {
        $addresses = $structure->getAddresses();

        return $this->render('address/index.html.twig', [
            'addresses' => $addresses,
        ]);
    }

    /**
     * @Route("/{id}/new", name="address_new", methods={"GET","POST"})
     * @ParamConverter("structure", class="App\Entity\Structure", options={"mapping": {"id": "id"}})
     * @IsGranted("ROLE_ADMIN")
     */
    public function new(Request $request, Structure $structure): Response
    {
        $address = new Address();
        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $address->addStructure($structure);

            $entityManager->persist($address);
            $entityManager->flush();

            return $this->redirectToRoute('address_index', ['id' => $structure->getId()]);
        }

        return $this->render('address/new.html.twig', [
            'address' => $address,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idStructure}/edit-address/{idAddress}", name="address_edit", methods={"GET","POST"})
     * @ParamConverter("structure", class="App\Entity\Structure", options={"mapping": {"idStructure": "id"}})
     * @ParamConverter("address", class="App\Entity\Address", options={"mapping": {"idAddress": "id"}})
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, Address $address, Structure $structure): Response
    {
        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('address_index', ['id' => $structure->getId()]);
        }

        return $this->render('address/edit.html.twig', [
            'address' => $address,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idStructure}/delete-address/{idAddress}", name="address_delete", methods={"POST"})
     * @ParamConverter("structure", class="App\Entity\Structure", options={"mapping": {"idStructure": "id"}})
     * @ParamConverter("address", class="App\Entity\Address", options={"mapping": {"idAddress": "id"}})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, Address $address, Structure $structure): Response
    {
        if ($this->isCsrfTokenValid('delete' . $address->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($address);
            $entityManager->flush();
        }

        return $this->redirectToRoute('address_index', ['id' => $structure->getId()]);
    }
}
