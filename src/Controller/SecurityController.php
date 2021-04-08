<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

use App\Entity\Etudiant;
use App\Form\EtudiantType;
use App\Repository\EtudiantRepository;
use App\Entity\Pret;
use App\Form\PretType;
use App\Repository\PretRepository;
use App\Entity\DeclarRemboursement;
use App\Form\DeclarRemboursementType;
use App\Repository\DeclarRemboursementRepository;
use Symfony\Component\Security\Core\User\UserInterface;

use App\Entity\Reclamation;
use App\Form\ReclamationType;
use App\Repository\CotisationRepository;
use App\Repository\ReclamationRepository;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;



class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils, ReclamationRepository $reclamationRepository, EtudiantRepository $etudiantRepository, DeclarRemboursementRepository $declarRemboursementRepository, PretRepository $pretRepository): Response
    {


        if ($this->getUser()) {

            $sang = $this->getUser();
            $etudianti = $etudiantRepository->findById($sang->getId());
            $etudiant;
            foreach ($etudianti as $etudianto) {
                $etudiant = $etudianto;
            }

            return $this->redirectToRoute('monroutess', array(
                'connexion' => 2665 + $sang->getId(),
                'id' => $sang->getId(),
                'nom' => $etudiant->getNom(),
                'prenom' => $etudiant->getPrenom()
            ));
        }
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }


    /**
     * @Route("{nom}/{prenom}/{id}/comptes", name="monroutess",methods={"GET","POST"})
     */
    public function moncompti(Request $request, Etudiant $etudiant, PretRepository $pretRepository, DeclarRemboursementRepository $declarRemboursementRepository, CotisationRepository $cotisationRepository)
    {
        // someotherlogic 
        // in this case $entity equals 'some_value'
        //$realentity = $this->get("entity");
        $cotisation = $cotisationRepository->findByEtudiant($etudiant);
        $var =  $request->get("connexion");
        $var2 = 2021;
        $vark = $var - 2665;
        if ($etudiant->getId() == $vark)
            return $this->render('default/userInterface.html.twig', [
                'etudiant' => $etudiant,
                'cotisations' => $cotisation,
                'prets' => $pretRepository->findByEtudiant($etudiant),
                'declarations' => $declarRemboursementRepository->findByEtudiant($etudiant)
            ]);
        else
            return $this->render('base.html.twig', [
                'etudiant' => $etudiant,
                //	'user'=>$user,

            ]);
    }
}
