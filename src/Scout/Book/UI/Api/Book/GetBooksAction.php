<?php


namespace Scout\Book\UI\Api\Book;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Scout\Book\Application\Get\GetBooksCommand;
use Shared\Infrastructure\Http\Response\ListResponse;
use Shared\Infrastructure\Http\Route;

#[Route(url: '/books', method: 'GET')]
class GetBooksAction extends Controller
{
    public function __invoke(Request $request): ListResponse
    {
        $includeIgnored = $request->get("includeIgnored") === 'true';
        $response = $this->dispatchSync(new GetBooksCommand(null, null, $includeIgnored));
        return new ListResponse($response->getBooks());
    }
}
