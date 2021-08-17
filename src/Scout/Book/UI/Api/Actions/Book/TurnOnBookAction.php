<?php

namespace Scout\Book\UI\Api\Actions\Book;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Scout\Book\Application\TurnOn\TurnOnBookCommand;

class TurnOnBookAction extends Controller
{
    public function __invoke(int $id): JsonResponse
    {
        $this->dispatchSync(new TurnOnBookCommand($id));
        return new JsonResponse(['success' => true]);
    }
}
