<?php

namespace App\Controller;

use App\Entity\Pret;
use App\Form\PretType;
use App\Repository\PretRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Etudiant;
use App\Form\EtudiantType;
use App\Repository\EtudiantRepository;



use App\Entity\DeclarRemboursement;
use App\Form\DeclarRemboursementType;
use App\Repository\DeclarRemboursementRepository;
use Symfony\Component\Security\Core\User\UserInterface;

use App\Entity\Reclamation;
use App\Form\ReclamationType;
use App\Repository\CotisationRepository;
use App\Repository\ReclamationRepository;
use DateInterval;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;









/**
 * IsGranted("ROLE_ETUDIANT")
 */
class PretController extends AbstractController
{
    /**
     *IsGranted("ROLE_ADMIN")
     * @Route("/admin/pret/", name="pret_index", methods={"GET"})
     */
    public function index(PretRepository $pretRepository, EtudiantRepository $etudiantRepository): Response
    {
        $prets = $pretRepository->findAll();
        return $this->render('pret/index.html.twig', [
            'prets' => $prets,
        ]);
    }

    /**
     * @Route("/pret/{id}/new", name="pret_new", methods={"GET","POST"})
     */
    public function new(Request $request, Etudiant $etudiant, CotisationRepository $cotisationRepository, ReclamationRepository $reclamationRepository, DeclarRemboursementRepository $declarRemboursementRepository, PretRepository $pretRepository): Response
    {
        $pret = new Pret();
        $form = $this->createForm(PretType::class, $pret);
        $form->handleRequest($request);

        $aicha = $request->get("connexion");
        $mahamadou = $request->get("id");

        if ($form->isSubmitted() && $form->isValid()) {
            if ($aicha - 2065 == $mahamadou) {
                $pret->setStatut("non traité");
                //$date = new \DateTime('@' . strtotime('now'));
                $date = new \DateTime('now');
                $pret->setDate($date);
                $dateEcheance = new \DateTime('now');
                $duree = $request->request->get('duree');
                $interval = new \DateInterval('P' . $duree . 'M');
                $echeance = $dateEcheance->add($interval);

                $pret->setEcheance($echeance);
                $pret->setEtudiant($etudiant);
                $pret->setPeriode(1);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($pret);
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

        return $this->render('pret/new.html.twig', [
            'pret' => $pret,
            'form' => $form->createView(),
        ]);
    }

    /**
     *IsGranted("ROLE_ADMIN")
     * @Route("/admin/pret/{id}", name="pret_show", methods={"GET"})
     */
    public function show(Pret $pret): Response
    {
        return $this->render('pret/show.html.twig', [
            'pret' => $pret,
        ]);
    }

    /**
     *IsGranted("ROLE_ADMIN")
     * @Route("/admin/pret/{id}/edit", name="pret_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Pret $pret): Response
    {
        /* $form = $this->createForm(PretType::class, $pret);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('pret_index');
        }

        return $this->render('pret/edit.html.twig', [
            'pret' => $pret,
            'form' => $form->createView(),
        ]); */
        $pret->setStatut("Traité");
        $this->getDoctrine()->getManager()->persist($pret);
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('pret_index');
    }

    /**
     *IsGranted("ROLE_ADMIN")
     * @Route("/admin/pret/delete/{id}/delete", name="pret_delete")
     */
    public function delete(Request $request, Pret $pret): Response
    {
        /*  if ($this->isCsrfTokenValid('delete' . $pret->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($pret);
            $entityManager->flush();
        } */
        $this->getDoctrine()->getManager()->remove($pret);
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('pret_index');
    }
}
