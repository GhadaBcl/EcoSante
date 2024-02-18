<?php

namespace App\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Reponse;
use App\Entity\Reclamation;
use App\Form\ReponseType;
use App\Repository\ReclamationRepository;
use App\Repository\ReponseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReponseController extends AbstractController
{
    #[Route('/reponse', name: 'app_reponse')]
    public function index(): Response
    {
        return $this->render('reponse/index.html.twig', [
            'controller_name' => 'ReponseController',
        ]);
    }


    #[Route('/addreponse', name: 'addreponse')]
    public function addreponse(Request $request, EntityManagerInterface $entityManager, ReclamationRepository $reclamationRepository): Response
    {
        // Récupérer l'ID de la réclamation à partir de la requête
        $reclamationId = $request->query->get('reclamation_id');
    
        // Récupérer la réclamation correspondante à partir de l'ID
        $reclamation = $reclamationRepository->find($reclamationId);
    
        // Créer une nouvelle instance de Reponse
        $reponse = new Reponse();
    
        // Créer le formulaire en utilisant la classe ReponseType
        $form = $this->createForm(ReponseType::class, $reponse);
    
        // Gérer la soumission du formulaire
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Associer la réclamation à la réponse
            $reponse->setReclamation($reclamation);
    
            // Persistez la réponse dans la base de données
            $entityManager->persist($reponse);
            $entityManager->flush();
    
            // Mettre à jour l'état de la réclamation en "traitée"
            $reclamation->setEtat('traitée');
            $entityManager->persist($reclamation);
            $entityManager->flush();
    
    
            return $this->redirectToRoute('admin'); // Rediriger vers la page de réponses après l'ajout
            
        }
    
        return $this->render('reponse/addreponse.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    

    
    

}
