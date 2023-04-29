<?php

namespace App\Controller;

use App\Entity\Projet;
use App\Form\ProjetType;
use App\Form\SearchPType;
use App\Repository\ProjetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Dompdf\Dompdf;
use Dompdf\Options;
use phpDocumentor\Reflection\Project;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/projet')]
class ProjetController extends AbstractController
{
    #[Route('', name: 'app_projet_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $projets = $entityManager
            ->getRepository(Projet::class)
            ->findAll();
        $res = new ArrayCollection($projets);
        echo $res;
        return $this->render('projet/index.html.twig', [
            'projets' => $projets,
        ]);
    }

    #[Route('/front', name: 'app_projet_indexF', methods: ['GET'])]
    public function indexF(EntityManagerInterface $entityManager): Response
    {
        $projets = $entityManager
            ->getRepository(Projet::class)
            ->findAll();

        return $this->render('projet/indexF.html.twig', [
            'projet' => $projets,
        ]);
    }


    #[Route('-new', name: 'app_projet_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $projet = new Projet();
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($projet);
            $entityManager->flush();
            $this->addFlash('message','Ajoute Project  ');
            return $this->redirectToRoute('app_projet_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('projet/new.html.twig', [
            'projet' => $projet,
            'form' => $form,
        ]);
        
    }

    #[Route('-{idprojet}', name: 'app_projet_show', methods: ['GET'])]
    public function show(Projet $projet): Response
    {
        return $this->render('projet/show.html.twig', [
            'projet' => $projet,
        ]);
    }

    #[Route('-{idprojet}-edit', name: 'app_projet_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Projet $projet, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_projet_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('projet/edit.html.twig', [
            'projet' => $projet,
            'form' => $form,
        ]);
    }

    #[Route('-{idprojet}', name: 'app_projet_delete', methods: ['POST'])]
    public function delete(Request $request, Projet $projet, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$projet->getIdprojet(), $request->request->get('_token'))) {
            $entityManager->remove($projet);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_projet_index', [], Response::HTTP_SEE_OTHER);
    }

/**
     * @Route("/showProjet", name="showProjet" , methods={"GET"})
     */
    public function showProjet(Request $request)
    {
        $factures = $this->getDoctrine()->getRepository(Projet::class)->findAll();
        $form = $this->createForm(SearchPType::class);
        $form->add('titreprojet');
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $titreprojet = $form['titreprojet']->getData();
            $result = $this->getDoctrine()->getRepository(Projet::class)->searchProjet($titreprojet);
            return $this->render('projet/show.html.twig', array("showProjets" => $result, "formProjet" => $form->createView()));

        }
        return $this->render('projet/show.html.twig', array("showProjets" => $factures, "formProjet" => $form->createView()));
    }
       /**
     * @Route("/pdfprojet", name="PDFProjet", methods={"GET"})
     */
    public function PDFProjet(ProjetRepository $projetRepository): Response
    {
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        $dompdf = new Dompdf($pdfOptions);
        $html = $this->render('projet/ProjetPdf.html.twig', [
            'showProjets' => $projetRepository->findAll(),
        ]);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();
        $dompdf->stream("Projetpdf.pdf", [
            "projets" => true
        ]);
    }
    
}
