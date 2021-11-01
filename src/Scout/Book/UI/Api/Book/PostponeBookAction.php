<?php

namespace Scout\Book\UI\Api\Book;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Scout\Book\Application\Postpone\PostponeBookCommand;
use Shared\Infrastructure\Http\Route;

#[Route(url: '/books/{id}/postpone', method: 'PUT')]
class PostponeBookAction extends Controller
{
    public function __invoke(int $id): JsonResponse
    {
        $this->dispatchSync(new PostponeBookCommand($id));
        return new JsonResponse(['success' => true]);
    }
}
