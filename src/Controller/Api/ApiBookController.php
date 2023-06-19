<?php


namespace App\Controller\Api;

use App\Entity\Book;
use App\Repository\BookRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiBookController extends AbstractController
{
    #[Route('/api/books', name: 'cmpt_api_getbooks', methods: ['GET'])]
    public function getAllBooks(BookRepository $bookRepository, SerializerInterface $serializer): JsonResponse
    {
        $bookList = $bookRepository->findAll();
        $jsonBookList = $serializer->serialize($bookList, 'json');

        return  new JsonResponse($jsonBookList, Response::HTTP_OK, [], true);
    }

    #[Route('/api/books/{id}', name: 'cmpt_api_getbooks', methods: ['GET'])]
    public function getDetailsBokk(Book $book, SerializerInterface $serializer): JsonResponse
    {

        $jsonBookDetails = $serializer->serialize($book, 'json');
        return new JsonResponse($jsonBookDetails, Response::HTTP_OK, [], true);
    }
}
