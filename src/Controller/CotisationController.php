<?php

namespace App\Controller;

use App\Entity\Cotisation;
use App\Entity\Etudiant;
use App\Form\CotisationType;
use App\Repository\CotisationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Doctrine\Persistence\ObjectManager;




use App\Entity\Pret;
use App\Form\PretType;
use App\Repository\PretRepository;
use App\Entity\DeclarRemboursement;
use App\Form\DeclarRemboursementType;
use App\Repository\DeclarRemboursementRepository;
use Symfony\Component\Security\Core\User\UserInterface;

use App\Entity\Reclamation;
use App\Form\ReclamationType;
use App\Repository\ReclamationRepository;




/**
 *@IsGranted("ROLE_USER")
 */
class CotisationController extends AbstractController
{
    /**
     *@IsGranted("ROLE_ADMIN")
     * @Route("/admin/cotisation/", name="cotisation_index", methods={"GET"})
     */
    public function index(CotisationRepository $cotisationRepository): Response
    {
        return $this->render('cotisation/index.html.twig', [
            'cotisations' => $cotisationRepository->findAll(),
        ]);
    }
    /**
     * @Route("/cotisation/{id}/new", name="cotisation_new", methods={"GET","POST"})
     */


    public function new(Request $request, Etudiant $etudiant, ReclamationRepository $reclamationRepository, CotisationRepository $cotisationRepository, DeclarRemboursementRepository $declarRemboursementRepository, PretRepository $pretRepository): Response
    {      //$date =new Date('d/m/Y');
        $date = date('Y-m-d H:i:s');
        $cotisation = new Cotisation();
        $form = $this->createForm(CotisationType::class, $cotisation);
        $form->handleRequest($request);
        $aicha = $request->get("connexion");
        $mahamadou = $request->get("id");

        if ($form->isSubmitted() && $form->isValid()) {

            if ($aicha - 2065 == $mahamadou) {
                $cotisation->setEtudiant($etudiant);
                $cotisation->setStatus("non trait??");
                $cotisation->setPeriode(1);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($cotisation);
                $date = new \DateTime('@' . strtotime('now'));
                $cotisation->setDate($date);
                //recuperer les extension des file pour les ajouter ?? la fin
                $dateFormat = $date->format('Y-m-d');
                $someNewFilename = $cotisation->getEtudiantinfo() . "_" . $cotisation->getPeriode() . "_" . $dateFormat . ".png";
                $file = $form['justificatif']->getData();
                $file->move("C:/wamp64/www/sutura/fichier_justificatif", $someNewFilename);
                $cotisation->setJustificatif($someNewFilename);
                $entityManager->flush();
                $cotisation = $cotisationRepository->findByEtudiant($etudiant);
                return $this->render('default/userInterface.html.twig', [
                    'etudiant' => $etudiant,
                    'cotisations' => $cotisation,
                    'prets' => $pretRepository->findByEtudiant($etudiant),
                    'declarations' => $declarRemboursementRepository->findByEtudiant($etudiant)
                ]);
            }
        }
        return $this->render('cotisation/new.html.twig', [
            'cotisation' => $cotisation,
            'form' => $form->createView(),
        ]);
    }

    /**
     *IsGranted("ROLE_ADMIN")
     * @Route("/admin/cotisation/{id}", name="cotisation_show", methods={"GET"})
     */
    public function show(Cotisation $cotisation): Response
    {
        return $this->render('cotisation/show.html.twig', [
            'cotisation' => $cotisation,
        ]);
    }

    /**
     *IsGranted("ROLE_ADMIN")
     * @Route("/admin/cotisation/{id}/edit", name="cotisation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Cotisation $cotisation): Response
    {
        /* $form = $this->createForm(CotisationType::class, $cotisation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cotisation_index');
        } */
        $cotisation->setStatus("Trait??");
        $this->getDoctrine()->getManager()->persist($cotisation);
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('cotisation_index');
        /* return $this->render('cotisation/edit.html.twig', [
            'cotisation' => $cotisation,
            'form' => $form->createView(),
        ]); */
    }

    /**
     *IsGranted("ROLE_ADMIN")
     * @Route("/admin/cotisation/delete/{id}    ", name="cotisation_delete")
     */
    public function delete(Request $request, Cotisation $cotisation): Response
    {
        /*  if ($this->isCsrfTokenValid('delete' . $cotisation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($cotisation);
            $entityManager->flush();
        } */
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($cotisation);
        $entityManager->flush();

        return $this->redirectToRoute('cotisation_index');
    }

    /**
     * @Route("/traiterformulaire", name="cotisationtraitement", methods={"GET","POST"})
     */
    /* public  function traitment()
	 {  
     	 $cotisation = new Cotisation();
		      
        $cotisation = new Cotisation();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($cotisation);
			$someNewFilename =$cotisation->getEtudiantinfo()."_".$cotisation->getPeriode();
			  $file = $form['justificatif']->getData();
			   $file->move("C:/wamp64/www/sutura/fichier_justificatif", $someNewFilename);
			 $cotisation->setJustificatif($someNewFilename);
			 $date = new \DateTime('@'.strtotime('now'));
			$cotisation->setDate($date);
            $entityManager->flush();
            return $this->redirectToRoute('cotisation_index');
        }
        return $this->render('cotisation/new.html.twig', [
            'cotisation' => $cotisation,
            'form' => $form->createView(),
        ]);	 
	    }
			   */
}
