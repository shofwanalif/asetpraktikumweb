<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookResource;
use App\Models\Book;

class BookWebController extends Controller
{
    public function index()
    {
        // 1. Retrieve data from the book, just like in the BookController (API)
        $paginated = Book::with('member')->paginate(10);

        // 2. Convert to the same format as the API response
        $result = BookResource::collection($paginated)->response()->getData(true);

        // 3. Get the parts to be sent to the view
        $books = $result['data'];
        $meta = $result['meta'];
        $links = $result['links'];

        return view('books.index', compact('books', 'meta', 'links'));
    }
}
