<?php

namespace App\Controller;

use App\Entity\Recette;
use App\Form\RecetteForm;
use App\Repository\RecetteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/recette')]
final class RecetteController extends AbstractController
{
    // 📌 LISTE + FILTRE
    #[Route('', name: 'app_recette_index', methods: ['GET'])]
    public function index(
        Request $request,
        RecetteRepository $recetteRepository
    ): Response {
        $fiche = $request->query->get('fiche');

        $recettes = $recetteRepository->findByName($fiche);

        return $this->render('recette/index.html.twig', [
            'recettes' => $recettes,
            'fiche' => $fiche,
        ]);
    }

    // 📌 CRÉATION RECETTE + UPLOAD IMAGE
    #[Route('/new', name: 'app_recette_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        SluggerInterface $slugger
    ): Response {
        $recette = new Recette();
        $form = $this->createForm(RecetteForm::class, $recette);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $imageFile = $form->get('avatar1')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo(
                    $imageFile->getClientOriginalName(),
                    PATHINFO_FILENAME
                );

                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    throw new \RuntimeException("Erreur lors de l'upload de l'image");
                }

                $recette->setAvatar1($newFilename);
            }

            $entityManager->persist($recette);
            $entityManager->flush();

            return $this->redirectToRoute('app_recette_index');
        }

        return $this->render('recette/new.html.twig', [
            'recette' => $recette,
            'form' => $form->createView(),
        ]);
    }

    // 📌 AFFICHER UNE RECETTE
    #[Route('/{id}', name: 'app_recette_show', methods: ['GET'])]
    public function show(Recette $recette): Response
    {
        return $this->render('recette/show.html.twig', [
            'recette' => $recette,
        ]);
    }

    // 📌 MODIFIER
    #[Route('/{id}/edit', name: 'app_recette_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        Recette $recette,
        EntityManagerInterface $entityManager
    ): Response {
        $form = $this->createForm(RecetteForm::class, $recette);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_recette_index');
        }

        return $this->render('recette/edit.html.twig', [
            'recette' => $recette,
            'form' => $form->createView(),
        ]);
    }

    // 📌 SUPPRIMER
    #[Route('/{id}', name: 'app_recette_delete', methods: ['POST'])]
    public function delete(
        Request $request,
        Recette $recette,
        EntityManagerInterface $entityManager
    ): Response {
        if ($this->isCsrfTokenValid(
            'delete'.$recette->getId(),
            $request->request->get('_token')
        )) {
            $entityManager->remove($recette);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_recette_index');
    }
}


    