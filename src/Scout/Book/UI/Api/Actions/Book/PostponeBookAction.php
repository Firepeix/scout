<?php

namespace Scout\Book\UI\Api\Actions\Book;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Scout\Book\Application\Postpone\PostponeBookCommand;

class PostponeBookAction extends Controller
{
    public function __invoke(int $id): JsonResponse
    {
        $this->dispatchSync(new PostponeBookCommand($id));
        return new JsonResponse(['success' => true]);
    }
}
