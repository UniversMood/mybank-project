<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/categories')]
class CategoryController extends AbstractController
{
    #[Route('', name: 'category_index', methods: ['GET'])]
    public function index(CategoryRepository $categoryRepository): JsonResponse
    {
        $categories = $categoryRepository->findAll();
        $data = [];
        
        foreach ($categories as $category) {
            $data[] = [
                'id' => $category->getId(),
                'title' => $category->getTitle(),
                'color' => $category->getColor(),
                'user' => $category->getUser()->getFirstName()
            ];
        }
        
        return $this->json($data);
    }

    #[Route('', name: 'category_create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        
        $category = new Category();
        $category->setTitle($data['title']);
        $category->setColor($data['color'] ?? null);
        
        $entityManager->persist($category);
        $entityManager->flush();
        
        return $this->json(['message' => 'Category created'], Response::HTTP_CREATED);
    }
}