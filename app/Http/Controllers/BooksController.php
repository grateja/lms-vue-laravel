<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Book;
use App\Publisher;
use App\PublishingPlace;
use App\Category;
class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Book::with('books')
            ->where('title', 'like', "%$request->keyword%")
            ->orWhere('author', 'like', "%$request->keyword%")
            ->orWhere('isbn', 'like', "%$request->keyword%")
            ->orWhere('type_id', 'like', "%$request->keyword%")
            ->paginate(10);
        return response()->json([
            'data' => $data
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return DB::transaction(function () use ($request) {
            // validate the request
            $this->validate($request, [
                'title' => 'required',
                'price' => 'required',
                'year_published' => 'min:1900|max:2200|numeric'
            ]);

            if($request->type_id == null) {
                $request['type_id'] = Book::generateTypeID();
            }

            $book = Book::create(
                $request->only(['type_id', 'price', 'title', 'author', 'isbn', 'year_published', 'edition', 'volume', 'publisher_id', 'publishing_place_id', 'dewey_id'])
            );

            $book->attachPublisher($request->publisher_name);
            $book->attachPublishingPlace($request->publishing_place_name);
            $book->attachCategories(collect($request->categories));
            $book->createBooks($request->number_of_copies);

            return response()->json([
                'book' => $book
            ], 200);
        });
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book = Book::with('books.condition')
            ->with('dewey')
            ->with('publisher')
            ->with('publishingPlace')
            ->with('categories')
            ->find($id);
        if($book == null) {
            return response()->json(['Book doesn`t exist'], 404);
        }

        return response()->json([
            'book' => $book
        ], 200);
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
        $this->validate($request, [
            'title' => 'required',
            'price' => 'required',
            'year_published' => 'min:1900|max:2200|numeric'
        ]);

        if($request->type_id == null) {
            $request['type_id'] = Book::generateTypeID();
        }

        $book = Book::find($id);
        
        if($book == null){
            return response()->json([
                'message' => 'The book is destroyed long time ago'
            ], 404);
        }

        return DB::transaction(function () use ($request, $book){
            $book->update($request->only(['type_id', 'price', 'title', 'author', 'isbn', 'year_published', 'edition', 'volume', 'dewey_id']));
    
            $book->attachPublisher($request->publisher_name);
            $book->attachPublishingPlace($request->publishing_place_name);
            $book->attachCategories(collect($request->categories));

    
            return response()->json([
                'book' => $book
            ], 200);
        });

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = Book::find($id);
        if($book == null) {
            return response()->json([
                'message' => 'The book is already destroyed a long, long, long time ago.'
            ], 404);
        }

        $book->delete();

        return response()->json([
            'message' => 'Item deleted successfully!'
        ], 200);
    }

    public function generateTypeID(){
        return Book::generateTypeID();
    }
}
