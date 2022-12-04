<?php

namespace Scout\Book\UI\Api\Book;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Scout\Book\Application\TurnOn\TurnOnBookCommand;
use Shared\Infrastructure\Http\Response\SuccessResponse;
use Shared\Infrastructure\Http\Route;

#[Route(url: '/books/{id}/turn-on', method: 'PUT')]
class TurnOnBookAction extends Controller
{
    public function __invoke(int $id): JsonResponse
    {
        $this->dispatchSync(new TurnOnBookCommand($id));
        return new SuccessResponse("Livro ativado com sucesso");
    }
}
