<?php

namespace Scout\Book\UI\Api\Book;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Scout\Book\Application\Read\ReadBookCommand;
use Shared\Infrastructure\Http\Route;

#[Route(url: '/books/{id}/read', method: 'PUT')]
class ReadBookAction extends Controller
{
    public function __invoke(int $id): JsonResponse
    {
        $this->dispatchSync(new ReadBookCommand($id));
        return new JsonResponse(['success' => true]);
    }
}
