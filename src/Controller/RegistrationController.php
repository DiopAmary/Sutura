<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\EmailVerifier;
use App\Security\UsersAuthenticator;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;
use App\Form\EtudiantType;
use App\Repository\EtudiantRepository;
use App\Entity\Pret;
use App\Form\PretType;
use App\Repository\PretRepository;
use App\Entity\DeclarRemboursement;
use App\Form\DeclarRemboursementType;
use App\Repository\DeclarRemboursementRepository;
use App\Entity\Etudiant;
use App\Repository\CotisationRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class RegistrationController extends AbstractController
{
    private $emailVerifier;
    private $notrevariable;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    /**
	
     * @Route("/register", name="appregister")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, UsersAuthenticator $authenticator, PretRepository $pretRepository, DeclarRemboursementRepository $declarRemboursementRepository): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        $etudiant = new Etudiant();
        $form2 = $this->createForm(EtudiantType::class, $etudiant);
        $form2->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setRoles(["ROLE_ETUDIANT"]);
            $date = new \DateTime('@' . strtotime('now'));
            $etudiant->setDate($date);
            $etudiant->setAdressemail($user);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $entityManager->persist($etudiant);
            $entityManager->flush();
            $notrevariable = $etudiant->getId();
            /* return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
			* default/templatepourforme/*/
            /*return $this->render('default/templatepourforme.html.twig', [
				'etudiant' => $etudiant,
				'prets' => $pretRepository->findByEtudiant($etudiant),
				'declarations'=>$declarRemboursementRepository->findByEtudiant($etudiant)
			]);*/

            $entity = $etudiant;
            //return $this->otherAction( $request,$etudiant ,$user);
            return $this->redirectToRoute('monroutes', array(
                'connexion' => 2665 + $user->getId(),
                'id' => $user->getId(),
                'nom' => $etudiant->getNom(),
                'prenom' => $etudiant->getPrenom()
            ));
        }
        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
            'form2' => $form2->createView(),
        ]);
    }
    /**
     * @Route("/verify/email", name="app_verify_email")
     */
    public function verifyUserEmail(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $exception->getReason());

            return $this->redirectToRoute('app_register');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Your email address has been verified.');

        return $this->redirectToRoute('app_register');
    }



    /**
     * @Route("{nom}/{prenom}/{id}/compte", name="monroutes",methods={"GET","POST"})
     */
    public function moncompte(Request $request, CotisationRepository $cotisationRepository, Etudiant $etudiant, PretRepository $pretRepository, DeclarRemboursementRepository $declarRemboursementRepository)
    {
        // some other logic
        // in this case $entity equals 'some_value'
        //$realentity = $this->get("entity");
        $var =  $request->get("connexion");
        $var2 = 2021;
        $vark = $var - 2665;
        if ($etudiant->getId() == $vark)
            return $this->render('default/userInterface.html.twig', [
                'etudiant' => $etudiant,
                'cotisation' => $cotisationRepository->findByEtudiant($etudiant),
                'prets' => $pretRepository->findByEtudiant($etudiant),
                'declarations' => $declarRemboursementRepository->findByEtudiant($etudiant)
            ]);
        else
            return $this->render('base.html.twig', [
                'etudiant' => $etudiant,
                //	'user'=>$user,

            ]);
    }

    /**
     
	{
	   
	  $pret = $this->getDoctrine()
            ->getRepository(Pret::class)
           
			->findBy(['statut' => 'nontraiter']);
      
		return 4;
		
	}*/
}
