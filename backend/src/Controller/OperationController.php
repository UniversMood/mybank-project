<?php

namespace App\Controller;

use App\Entity\Operation;
use App\Entity\User;
use App\Entity\Category;
use App\Repository\OperationRepository;
use App\Repository\UserRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/operations')]
class OperationController extends AbstractController
{
    #[Route('', name: 'operation_index', methods: ['GET'])]
    public function index(OperationRepository $operationRepository): JsonResponse
    {
        $operations = $operationRepository->findAll();
        $data = [];
        
        foreach ($operations as $operation) {
            $data[] = [
                'id' => $operation->getId(),
                'label' => $operation->getLabel(),
                'amount' => $operation->getAmount(),
                'date' => $operation->getDate()->format('Y-m-d'),
                'category' => $operation->getCategory()->getTitle(),
                'user' => $operation->getUser()->getFirstName()
            ];
        }
        
        return $this->json($data);
    }

    #[Route('', name: 'operation_create', methods: ['POST'])]
    public function create(
        Request $request, 
        EntityManagerInterface $entityManager,
        UserRepository $userRepository,
        CategoryRepository $categoryRepository
    ): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        
        // Pour l'instant, utilise le premier utilisateur (plus tard tu ajouteras l'authentification)
        $user = $userRepository->findOneBy([]);
        if (!$user) {
            return $this->json(['error' => 'No user found'], Response::HTTP_BAD_REQUEST);
        }

        // Récupère la catégorie par son ID
        $category = $categoryRepository->find($data['category']);
        if (!$category) {
            return $this->json(['error' => 'Category not found'], Response::HTTP_BAD_REQUEST);
        }
        
        $operation = new Operation();
        $operation->setLabel($data['label']);
        $operation->setAmount($data['amount']);
        $operation->setDate(new \DateTime($data['date']));
        $operation->setUser($user);
        $operation->setCategory($category);
        
        $entityManager->persist($operation);
        $entityManager->flush();
        
        return $this->json([
            'message' => 'Operation created',
            'id' => $operation->getId()
        ], Response::HTTP_CREATED);
    }
}