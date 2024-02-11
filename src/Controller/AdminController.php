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

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin')]
    public function index(ReclamationRepository $reclamationRepository): Response
    {
        // Récupérer toutes les réclamations depuis le repository
        $reclamations = $reclamationRepository->findAll();

        // Passer les réclamations au template Twig
        return $this->render('admin/admin.html.twig', [
            'reclamations' => $reclamations,
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
    



}
