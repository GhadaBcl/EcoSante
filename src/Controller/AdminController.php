<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\Manager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Reclamation;
use App\Entity\Reponse;
use App\Repository\ReclamationRepository;
use App\Repository\ReponseRepository;
use App\Form\ReclamationType;
use App\Form\ReponseType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin')]
    public function admin(ReclamationRepository $reclamationRepository, ReponseRepository $reponseRepository): Response {
        // Récupérer toutes les réclamations et toutes les réponses
        $reclamations = $reclamationRepository->findAll();
        $reponses = $reponseRepository->findAll();
    
        // Passer les réclamations et les réponses au template Twig
        return $this->render('admin/admin.html.twig', [
            'reclamations' => $reclamations,
            'reponses' => $reponses,
        ]);
    }

    #[Route('/deleteadmin/{id}', name: 'deleteadmin')]
    public function deleteadmin($id, ReclamationRepository $repo, EntityManagerInterface $entityManager)
    {
        $reclamation = $repo->find($id);
    
        if ($reclamation !== null) {
            $entityManager->remove($reclamation);
            $entityManager->flush();
        }
    
        return $this->redirectToRoute('admin');
    }

    #[Route('/deleteadminrep/{id}', name: 'deleteadminrep')]
    public function deleteadminrep($id, ReponseRepository $repo, EntityManagerInterface $entityManager)
    {
        $reponse = $repo->find($id);
    
        if ($reponse !== null) {
            $entityManager->remove($reponse);
            $entityManager->flush();
        }
    
        return $this->redirectToRoute('admin');
    }
    
    

    #[Route('/updateadmin/{id}', name: 'updateadmin')]
    public function updateadmin($id, ReclamationRepository $repo, Request $request, EntityManagerInterface $entityManager)
    {
        $reclamation = $repo->find($id);
        $form = $this->createForm(ReclamationType::class, $reclamation);
       // $form->add('Enregistrer', SubmitType::class);
       $form = $this->createForm(ReclamationType::class, $reclamation, [
        'is_edit' => true,
    ]);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('admin', ['id' => $reclamation->getId()]);
        }
    
        return $this->render('admin/updateadmin.html.twig', [
            'form' => $form->createView(),
            'id' => $id, // Passer l'identifiant de la réclamation à la vue Twig
        ]);
    }


    #[Route('/updateadminrep/{id}', name: 'updateadminrep')]
    public function updateadminrep($id, ReponseRepository $repo, Request $request, EntityManagerInterface $entityManager)
    {
        $reponse = $repo->find($id);
        $form = $this->createForm(ReponseType::class, $reponse, [
            'is_edit' => true,
        ]);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('admin', ['id' => $reponse->getId()]);
        }
    
        return $this->render('admin/updateadminrep.html.twig', [
            'form' => $form->createView(),
            'id' => $id, // Pass the identifier of the response to the Twig view
        ]);
    }
    


#[Route('/recherchereponse/{id}', name: 'recherchereponse')]
public function recherchereponse($id, ReponseRepository $repo): Response
{
    $reponse = $repo->find($id);

    return $this->render('admin/admin.html.twig', [
        'reponse' => $reponse,
    ]);
}


#[Route('/recherchereclamation/{id?}/{email?}', name: 'recherchereclamation')]
public function recherchereclamation(Request $request, ReclamationRepository $repo): Response
{
    $id = $request->get('id');
    $email = $request->get('email');

    if ($id !== null) {
        $reclamation = $repo->find($id);
        $reclamations = $reclamation ? [$reclamation] : [];
    } elseif ($email !== null) {
        $reclamations = $repo->findBy(['email' => $email]);
    } else {
        // Gérer le cas où aucun paramètre n'est fourni
        $reclamations = [];
    }

    return $this->render('admin/recherchereclamation.html.twig', [
        'reclamations' => $reclamations,
    ]);
}


}
