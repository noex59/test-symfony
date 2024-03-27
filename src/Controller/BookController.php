<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api', name: 'api_')]
class BookController extends AbstractController
{
    public function __construct(
        private SerializerInterface $serializer,
        private BookRepository $bookRepository
    ){

    }

    #[Route('/books', name: 'get_all_books', methods: ['GET'])]
    public function index(): Response
    {
        $books = $this->bookRepository->findAll();
        $booksJson = $this->serializer->serialize($books, 'json', ['groups' => 'book_group']);

        return new JsonResponse($booksJson, Response::HTTP_OK, [], true);
    }

    #[Route('/book/{id}', name: 'get_book_details', methods: ['GET'])]
    public function details(Book $book): Response
    {
        $bookDetails = $this->serializer->serialize($book, 'json', ['groups' => 'book_group']);
        return new JsonResponse($bookDetails, Response::HTTP_OK, [], true);
    }
}
