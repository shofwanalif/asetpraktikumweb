<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Http\Requests\StoreBookRequest;
use App\Http\Resources\BookResource;
use Illuminate\Support\Facades\Storage;
use Throwable;

// Controller ini sudah LENGKAP - tidak perlu diubah.
// Gunakan sebagai referensi format penulisan Controller CRUD standar.

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with('member')->paginate(10);
        return BookResource::collection($books);
    }

    // Route Model Binding: Laravel otomatis mencari Book berdasarkan ID di URL
    public function show(Book $book)
    {
        return new BookResource($book->load('member'));
    }

    public function store(StoreBookRequest $request)
    {
        $data = $request->safe()->except('file_path');
        $storedPath = null;

        if ($request->hasFile('file_path')) {
            $storedPath = $request->file('file_path')->store('books', 'public');
            $data['file_path'] = $storedPath;
        }

        try {
            $book = Book::create($data);
        } catch (Throwable $exception) {
            if ($storedPath) {
                Storage::disk('public')->delete($storedPath);
            }

            throw $exception;
        }

        return (new BookResource($book))->response()->setStatusCode(201);
    }

    public function update(StoreBookRequest $request, Book $book)
    {
        $data = $request->safe()->except('file_path');
        $oldPath = $book->file_path;
        $newPath = null;

        if ($request->hasFile('file_path')) {
            $newPath = $request->file('file_path')->store('books', 'public');
            $data['file_path'] = $newPath;
        }

        try {
            $book->update($data);
        } catch (Throwable $exception) {
            if ($newPath) {
                Storage::disk('public')->delete($newPath);
            }

            throw $exception;
        }

        if ($newPath && $oldPath) {
            Storage::disk('public')->delete($oldPath);
        }

        return new BookResource($book);
    }

    public function destroy(Book $book)
    {
        $filePath = $book->file_path;
        $book->delete();

        if ($filePath) {
            Storage::disk('public')->delete($filePath);
        }

        return response()->json(['message' => 'Buku berhasil dihapus']);
    }
}
