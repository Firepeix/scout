<?php

namespace Scout\Book\UI\Api\Actions\Book;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Scout\Book\Application\Read\ReadBookCommand;

class ReadBookAction extends Controller
{
    public function __invoke(int $id): JsonResponse
    {
        $this->dispatchSync(new ReadBookCommand($id));
        return new JsonResponse(['success' => true]);
    }
}
