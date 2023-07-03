<?php


namespace App\Controller\Api;

use App\Entity\Book;
use App\Entity\Author;
use Doctrine\ORM\EntityManager;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiBookController extends AbstractController
{
    #[Route('/api/books', name: 'cmpt_api_getBooks', methods: ['GET'])]
    // #[IsGranted('ROLE_ADMIN', message: 'Vous n\'avez pas les droits suffisants pour créer un livre')]
    public function getAllBooks(BookRepository $bookRepository, SerializerInterface $serializer, Request $request): JsonResponse
    {

        $page = $request->get('page', 1);
        $limit = $request->get('limit', 3);

        $bookList = $bookRepository->findAllWithPagination($page, $limit);
        $jsonBookList = $serializer->serialize($bookList, 'json', ['groups' => 'getBooks']);

        return  new JsonResponse($jsonBookList, Response::HTTP_OK, [], true);
    }

    #[Route('/api/books/{id}', name: 'cmpt_api_getBook', methods: ['GET'])]
    public function getDetailsBook(Book $book, SerializerInterface $serializer): JsonResponse
    {
        $jsonBookDetails = $serializer->serialize($book, 'json', ['groups' => 'getBooks']);

        return new JsonResponse($jsonBookDetails, Response::HTTP_OK, [], true);
    }


    #[Route('/api/books', name: 'cmpt_api_creatBook', methods: ['POST'])]
    public function createBook(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, UrlGeneratorInterface $urlGenerator,  ValidatorInterface $validator): JsonResponse
    {

        $book =  $serializer->deserialize($request->getContent(), Book::class, 'json');

        // On vérifie les erreurs
        $errors = $validator->validate($book);

        if ($errors->count() > 0) {
            return new JsonResponse($serializer->serialize($errors, 'json'), JsonResponse::HTTP_BAD_REQUEST, [], true);
        }

        $book->setAuthor($em->getRepository(Author::class)->find($request->toArray()["authorId"]));

        $em->persist($book);
        $em->flush();

        $bookCreated = $serializer->serialize($book, 'json', ['groups' => 'getBooks']);
        $location = $urlGenerator->generate('cmpt_api_getBook', ['id' => $book->getId()]);

        return new JsonResponse($bookCreated, Response::HTTP_CREATED, ['location' => $location], true);
    }


    #[Route('/api/books/{id}', name: 'cmpt_api_editBook', methods: ['PUT'])]
    public function updateBook(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, Book $currentBook): JsonResponse
    {

        $book =  $serializer->deserialize($request->getContent(), Book::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $currentBook]);
        $book->setAuthor($em->getRepository(Author::class)->find($request->toArray()["authorId"]));

        $em->persist($book);
        $em->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }



    #[Route('/api/books/{id}', name: 'cmpt_api_deleteBook', methods: ['DELETE'])]
    public function deleteBook(Book $book, EntityManagerInterface $em): JsonResponse
    {
        $em->remove($book);
        $em->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
