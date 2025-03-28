<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Cache;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title= $request->input('title');
        $books= Book::when($title, function ($query, $title) {
            return $query->title($title);
        })

        ->get();

        $books=match($filter){  
            'popular_last_month' => $books->popularLastMonth(),
            'popular_last_6months' => $books->popularLast6Month(),
            'highest_rated_last_month' => $books->highestRatedLastMonth(),
            'highest_rated_last_6months' => $books->highestRatedLast6Month(),
            default => $books->latest()
        };

        // $books = $books->get();

       $cacheKey = 'books:' . $title . ':' . $filter;
        $books = Cache::remember($cacheKey, 3600, fn() => $books-get());

        return view('books.index', ['books' => $books]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        $cacheKey = 'book:' . $book->id;
        $book = cache::remember($cacheKey, 3600, fn() => $book);
        
        return view ('books.show',
         [
         
         'book' => $book->load([
            'reviews' => fn($query) => $query->latest()
         ])
         
         ]
        
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
