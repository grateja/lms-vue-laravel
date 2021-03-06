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
        return $request;
        $book = Book::with(['books' => function($query) use ($request){
                $query->where('unique_id', 'like', "%$request->keyword%");
            }])->find($request->bid);
        // $books = $book->books->where('unique_id', 'like', "%$request->keyword%")->get();

        // $book = Book::find()

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
        $book = Book::find($id);

        $books = $book->books()->with('condition')->where('unique_id', 'like', "%$request->keyword%")->paginate(10);

        // $book = Book::with(['books' => function($query) use ($request){
        //     return $query->where('unique_id', 'like', "%$request->keyword%")->with('condition')->paginate(10);
        // }])->find($id);
        // $books = $book->books->where('unique_id', 'like', "%$request->keyword%")->get();

        return response()->json([
            'data' => [
                'book' => $book,
                'books' => $books
            ]
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
        $book = SpecificBook::find($id);

        $book->update($request->only(['unique_id', 'condition_id']));

        if($request->apply_all_condition) {
            SpecificBook::where(['book_id' => $book->book_id])
                ->update(['condition_id' => $request->condition_id]);
        }

        return response()->json([
            'book' => $book->fresh('condition')
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = SpecificBook::find($id);
        $book->delete();
        return response()->json([
            'data' => 'Deleted successfully'
        ], 200);
    }
}
