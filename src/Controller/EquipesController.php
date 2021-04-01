<?php

namespace App\Controller;

use App\Entity\Equipes;
use App\Form\EquipesType;
use App\Repository\EquipesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 *IsGranted("ROLE_ADMIN")
 * @Route("/equipes")
 */
class EquipesController extends AbstractController
{
    /**
     * @Route("/", name="equipes_index", methods={"GET"})
     */
    public function index(EquipesRepository $equipesRepository): Response
    {
        return $this->render('equipes/index.html.twig', [
            'equipes' => $equipesRepository->findAll(),
        ]);
    }

    /**
	 *IsGranted("ROLE_ADMIN")
     * @Route("/new", name="equipes_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $equipe = new Equipes();
        $form = $this->createForm(EquipesType::class, $equipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($equipe);
            $entityManager->flush();

            return $this->redirectToRoute('equipes_index');
        }

        return $this->render('equipes/new.html.twig', [
            'equipe' => $equipe,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="equipes_show", methods={"GET"})
     */
    public function show(Equipes $equipe): Response
    {
        return $this->render('equipes/show.html.twig', [
            'equipe' => $equipe,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="equipes_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Equipes $equipe): Response
    {
        $form = $this->createForm(EquipesType::class, $equipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('equipes_index');
        }

        return $this->render('equipes/edit.html.twig', [
            'equipe' => $equipe,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="equipes_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Equipes $equipe): Response
    {
        if ($this->isCsrfTokenValid('delete'.$equipe->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($equipe);
            $entityManager->flush();
        }

        return $this->redirectToRoute('equipes_index');
    }
}
