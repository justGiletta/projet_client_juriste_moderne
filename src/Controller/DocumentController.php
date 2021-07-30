<?php

namespace App\Controller;

use App\Entity\Document;
use App\Form\DocumentType;
use App\Repository\DocumentRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Vich\UploaderBundle\Handler\DownloadHandler;

/**
 * @Route("/document", name="document_")
 */
class DocumentController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     * @IsGranted("ROLE_USER")
     */
    public function index(DocumentRepository $documentRepository, Request $request): Response
    {
        $template = $request->query->get('ajax') ? '_list.html.twig' : 'index.html.twig';

        return $this->render(
            'document/' . $template,
            [
                'documents' => $documentRepository->findBy(['structure' => $this->getUser()->getStructure()]),
            ]
        );
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function new(Request $request): Response
    {
        $document = new Document();
        $form = $this->createForm(DocumentType::class, $document);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $document->setStructure($this->getUser()->getStructure());
            $entityManager->persist($document);
            $entityManager->flush();

            if ($request->isXmlHttpRequest()) {
                return new Response(null, 204);
            }

            return $this->redirectToRoute('document_index');
        }

        $template = $request->isXmlHttpRequest() ? '_documentform.html.twig' : 'new.html.twig';

        return $this->render(
            'document/' . $template,
            [
                'document' => $document,
                'form' => $form->createView(),
            ],
            new Response(
                null,
                $form->isSubmitted() ? 422 : 200
            )
        );
    }

    /**
     * @Route("/{id}", name="delete", methods={"POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, Document $document): Response
    {
        if ($this->isCsrfTokenValid('delete' . $document->getId(), $request->request->get('_token'))) {
            $name = $document->getDocument();
            $entityManager = $this->getDoctrine()->getManager();
            $document->setDocument('');
            $entityManager->persist($document);
            $entityManager->remove($document);
            $entityManager->flush();
            unlink($this->getParameter('upload_directory') . '/' . $name);
        }

        return $this->redirectToRoute('document_index');
    }

    /**
     * @Route("/{id}/download", name="download")
     */
    public function downloadImageAction(Document $document, DownloadHandler $downloadHandler): Response
    {
        return $downloadHandler->downloadObject($document, $fileField = 'imageFile');
    }
}
