<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use App\Entity\User;
use App\Form\UserType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

     /**
	 *IsGranted("ROLE_ADMIN")
     * @Route("/admin")
     */
class AdminController extends AbstractController
{
    /**
	 *IsGranted("ROLE_ADMIN")
     * @Route("/index", name="indexadmin")
     */
    public function index(): Response
    {
          // return $this->render('admin/index.html.twig', [
         //   'controller_name' => 'AdminController',
        //]);
		
		return $this->render('admin/Templateuser.html.twig',[
           // 'users' => $users->findAll()
		   'controller_name' => 'AdminController',
        ]);
    }
	
	/**
	 *IsGranted("ROLE_ADMIN")
     * @Route("/utilisateur", name="utilisateurs")
     */
	public function  usersList(UserRepository $users)
	{
		return $this->render('admin/users.html.twig',[
            'users' => $users->findAll()
        ]);
	}
	
	/**
     * @Route("/utilisateur/modifier/{id}", name="modifieruser",methods={"GET","POST"})
     */
    public function editusers(User $user, Request $request)
    {   $form = $this->createForm(UserType::class,$user);
		$form->handleRequest($request);
		
        if ($form->isSubmitted() &&  $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
			$this->addFlash('message','Utilisateur modifier avec success!!!');
			return $this->redirectToRoute('utilisateurs');
        }
		return $this->render('admin/modifier.html.twig',[
               'userForm'=>$form->createView()]);
	}			   
    }	
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		

