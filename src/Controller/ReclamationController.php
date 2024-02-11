<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\Manager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Reclamation;
use App\Repository\ReclamationRepository;
use App\Form\ReclamationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReclamationController extends AbstractController
{
    #[Route('/reclamation', name: 'reclamation')]
    public function index(): Response
    {
        return $this->render('reclamation/reclamation.html.twig', [
            'controller_name' => 'ReclamationController',
        ]);
    }
    
    #[Route('/addreclamation', name: 'addreclamation')]
    public function addreclamation(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reclamation = new Reclamation();
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reclamation);
            $entityManager->flush();

            $this->addFlash('success', 'Réclamation envoyée avec succès !');

            return $this->redirectToRoute('addreclamation'); // Rediriger vers la page de réclamation après l'ajout
        }
           


        return $this->render('reclamation/addreclamation.html.twig', [
            'form' => $form->createView(),
        ]);
    }


        #[Route('/showreclamation', name: 'showreclamation')]
        public function showreclamation(ReclamationRepository $reclamationRepository): Response
        {
            $reclamations = $reclamationRepository->findAll(); // Récupérer toutes les réclamations
    
            return $this->render('reclamation/showreclamation.html.twig', [
                'reclamations' => $reclamations,
            ]);
        }


        #[Route('/updatereclamation/{id}', name: 'updatereclamation')]
        public function updatereclamation($id, ReclamationRepository $repo, Request $request, EntityManagerInterface $entityManager)
        {
            $reclamation = $repo->find($id);
            $form = $this->createForm(ReclamationType::class, $reclamation);
           // $form->add('Enregistrer', SubmitType::class);
        
            $form->handleRequest($request);
            
            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->flush();
                return $this->redirectToRoute('showreclamation', ['id' => $reclamation->getId()]);
            }
        
            return $this->render('reclamation/updatereclamation.html.twig', [
                'form' => $form->createView(),
                'id' => $id, // Passer l'identifiant de la réclamation à la vue Twig
            ]);
        }
        


        #[Route('/deletereclamation/{id}', name: 'deletereclamation')]
public function deletereclamation($id, ReclamationRepository $repo, EntityManagerInterface $entityManager)
{
    $reclamation = $repo->find($id);

    if ($reclamation !== null) {
        $entityManager->remove($reclamation);
        $entityManager->flush();
    }

    return $this->redirectToRoute('showreclamation');
}



}
