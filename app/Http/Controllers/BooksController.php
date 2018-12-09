<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use App\Publisher;

class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $books = Book::where('title', 'like', "%$request->keyword%")
            ->orWhere('author', 'like', "%$request->keyword%")
            ->orWhere('isbn', 'like', "%$request->keyword%")
            ->orWhere('type_id', 'like', "%$request->keyword%")
            ->get();
        return response()->json([
            'books' => $books
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate the request
        $this->validate($request, [
            'title' => 'required',
            'price' => 'required',
            'type_id' => 'required',
            'year_published' => 'min:1900|max:2200|numeric'
        ]);

        // check if publisher is already in the database
        // if not, create a new one
        if(!$request->publisher_id && $request->publisher){
            $publisher = Publisher::create([
                'name' => $request->publisher
            ]);
            $request['publisher_id'] = $publisher->id;
        }

        $book = Book::create(
            $request->only(['type_id', 'price', 'title', 'author', 'isbn', 'year_published', 'edition', 'volume', 'publisher_id', 'publishing_place_id', 'dewey_id'])
        );

        return response()->json([
            'book' => $book
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
