<?php


namespace App\Controller\Api;

use App\Entity\Book;
use Doctrine\ORM\EntityManager;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiBookController extends AbstractController
{
    #[Route('/api/books', name: 'cmpt_api_getBooks', methods: ['GET'])]
    public function getAllBooks(BookRepository $bookRepository, SerializerInterface $serializer): JsonResponse
    {
        $bookList = $bookRepository->findAll();
        $jsonBookList = $serializer->serialize($bookList, 'json', ['groups' => 'getBooks']);

        return  new JsonResponse($jsonBookList, Response::HTTP_OK, [], true);
    }

    #[Route('/api/books/{id}', name: 'cmpt_api_getBook', methods: ['GET'])]
    public function getDetailsBook(Book $book, SerializerInterface $serializer): JsonResponse
    {
        $jsonBookDetails = $serializer->serialize($book, 'json', ['groups' => 'getBooks']);

        return new JsonResponse($jsonBookDetails, Response::HTTP_OK, [], true);
    }


    #[Route('/api/books', name: 'cmpt_api_deleteBook', methods: ['POST'])]
    public function createBook(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, UrlGeneratorInterface $urlGenerator): JsonResponse
    {
        $book =  $serializer->deserialize($request->getContent(), Book::class, 'json');
        $em->persist($book);
        $em->flush();

        $bookCreated = $serializer->serialize($book, 'json', ['groups' => 'getBooks']);
        $location = $urlGenerator->generate('cmpt_api_getBook', ['id' => $book->getId()]);


        return new JsonResponse($bookCreated, Response::HTTP_CREATED, ['location' => $location], true);
    }



    #[Route('/api/books/{id}', name: 'cmpt_api_deleteBook', methods: ['DELETE'])]
    public function deleteBook(Book $book, EntityManagerInterface $em): JsonResponse
    {
        $em->remove($book);
        $em->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
