<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     */
    public function index(): Response
    {   
	   
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }
	
    /**
     * @Route("/conditions-generales-d-utilisation", name="cgu")
     */
    public function cgu(): Response
    {   
        return $this->render('default/cgu.html.twig');
    }

    /**
     * @Route("/A-propos", name="a_propos")
     */
    public function aPropos(): Response
    {   
        return $this->render('default/a_propos.html.twig');
    }


     /**
     * @Route("/faire-un-don", name="faire_don")
     */
    public function faireDon(): Response
    {   
        return $this->render('default/faire_don.html.twig');
    }
	
	
	
	/**
     * @Route("/user", name="defaultii")
     */
    public function ind(): Response
    {   
	   
        return $this->render('User.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }
	
	
	
	
	
	
	
	/**
     * @Route("/usero", name="defaultili")
     */
    public function indo(): Response
    {   
        return $this->render('default/usersi.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }
	
	
	
}
