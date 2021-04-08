<?php

namespace App\Controller;

use App\Entity\DeclarRemboursement;
use App\Form\DeclarRemboursementType;
use App\Repository\DeclarRemboursementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Etudiant;
use App\Form\EtudiantType;
use App\Repository\EtudiantRepository;


use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;

use Symfony\Component\Security\Core\User\UserInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

use App\Entity\Pret;
use App\Form\PretType;

use App\Repository\PretRepository;


use App\Entity\Reclamation;
use App\Form\ReclamationType;
use App\Repository\ReclamationRepository;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;












/**
 *IsGranted("ROLE_ETUDIANT")
 */
class DeclarRemboursementController extends AbstractController
{
    /**
     *IsGranted("ROLE_ADMIN")
     * @Route("/admin/remboursement/", name="declar_remboursement_index", methods={"GET"})
     */
    public function index(DeclarRemboursementRepository $declarRemboursementRepository): Response
    {
        return $this->render('declar_remboursement/index.html.twig', [
            'declar_remboursements' => $declarRemboursementRepository->findAll(),
        ]);
    }

    /**
     * @Route("/remboursement/{id}/new", name="declar_remboursement_new", methods={"GET","POST"})
     */
    public function new(Request $request, Etudiant $etudiant, ReclamationRepository $reclamationRepository, DeclarRemboursementRepository $declarRemboursementRepository, PretRepository $pretRepository): Response
    {
        $declarRemboursement = new DeclarRemboursement();
        $form = $this->createForm(DeclarRemboursementType::class, $declarRemboursement);
        $form->handleRequest($request);
        /* $variable=true;
		 if( $form->isValid())
		 {
			 $taille= $file->getSize();
			 if( $taille > 3000000)
			 {
				 echo "taille depasser";
				 $variable=false;
			 }
		 }
		 */
        $aicha = $request->get("connexion");
        $mahamadou = $request->get("id");





        if ($form->isSubmitted() && $form->isValid()) {
            if ($aicha - 2065 == $mahamadou) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($declarRemboursement);
                $someNewFilename = $request->get("id") . "_" . $etudiant->getNom() . "_" . $etudiant->getPrenom();
                $file = $form['justificatif']->getData();
                $taille = $file->getSize();
                echo $taille;
                $date = new \DateTime('@' . strtotime('now'));
                $declarRemboursement->setDate($date);
                $declarRemboursement->setEtudiant($etudiant);
                $declarRemboursement->setPeriode(1);
                $declarRemboursement->setType("Default");
                $declarRemboursement->setStatus("non traité");

                $file->move("C:/wamp64/www/sutura/fichier_justificatif_remboursement", $someNewFilename);
                $declarRemboursement->setJustificatif($someNewFilename);


                $entityManager->flush();
                return $this->render('default/userInterface.html.twig', [
                    'etudiant' => $etudiant,
                    'prets' => $pretRepository->findByEtudiant($etudiant),
                    'declarations' => $declarRemboursementRepository->findByEtudiant($etudiant)
                ]);
            }
        }
        return $this->render('declar_remboursement/new.html.twig', [
            'declar_remboursement' => $declarRemboursement,
            'form' => $form->createView(),
        ]);
    }
    /**
     *IsGranted("ROLE_ADMIN")
     * @Route("/admin/remboursement/{id}", name="declar_remboursement_show", methods={"GET"})
     */
    public function show(DeclarRemboursement $declarRemboursement): Response
    {
        return $this->render('declar_remboursement/show.html.twig', [
            'declar_remboursement' => $declarRemboursement,
        ]);
    }

    /**
     *IsGranted("ROLE_ADMIN")
     * @Route("/admin/remboursement/{id}/edit", name="declar_remboursement_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, DeclarRemboursement $declarRemboursement): Response
    {
        /* $form = $this->createForm(DeclarRemboursementType::class, $declarRemboursement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('declar_remboursement_index');
        }

        return $this->render('declar_remboursement/edit.html.twig', [
            'declar_remboursement' => $declarRemboursement,
            'form' => $form->createView(),
        ]); */
        $declarRemboursement->setStatus("Traité");
        $this->getDoctrine()->getManager()->persist($declarRemboursement);
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('declar_remboursement_index');
    }
    /**
     *IsGranted("ROLE_ADMIN")
     * @Route("/admin/remboursement/{id}/delete", name="declar_remboursement_delete")
     */
    public function delete(Request $request, DeclarRemboursement $declarRemboursement): Response
    {
        /* if ($this->isCsrfTokenValid('delete' . $declarRemboursement->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($declarRemboursement);
            $entityManager->flush();
        } */

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($declarRemboursement);
        $entityManager->flush();

        return $this->redirectToRoute('declar_remboursement_index');
    }
}
