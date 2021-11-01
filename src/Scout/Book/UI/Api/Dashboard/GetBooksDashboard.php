<?php


namespace Scout\Book\UI\Api\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Scout\Book\Application\Get\GetBooksCommand;
use Shared\Infrastructure\Http\Route;

#[Route(url: '/', method: 'GET')]
class GetBooksDashboard extends Controller
{
    public function __invoke(): View
    {
        $response = $this->dispatchSync(new GetBooksCommand(null, null, true));
        return view('pages.home', ['books' => $response->getBooks()]);
    }
}
