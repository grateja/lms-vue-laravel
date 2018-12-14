<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\SpecificBook;
use App\Book;

class IndividualBooksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $book = Book::with(['books' => function($query) use ($request){
                $query->where('unique_id', 'like', "%$request->keyword%");
            }])->find($request->book_id);
        // $books = $book->books->where('unique_id', 'like', "%$request->keyword%")->get();

        return response()->json([
            'book' => $book
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $book = Book::with(['books' => function($query) use ($request){
            $query->where('unique_id', 'like', "%$request->keyword%");
        }])->find($id);
        // $books = $book->books->where('unique_id', 'like', "%$request->keyword%")->get();

        return response()->json([
            'book' => $book
        ], 200);
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
