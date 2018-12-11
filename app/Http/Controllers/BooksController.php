<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use App\Publisher;
use App\PublishingPlace;

class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Book::where('title', 'like', "%$request->keyword%")
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
        // validate the request
        $this->validate($request, [
            'title' => 'required',
            'price' => 'required',
            'type_id' => 'required',
            'year_published' => 'min:1900|max:2200|numeric'
        ]);

        // check if publisher changed
        if($request->publisher_id == null && $request->publisher != null) {
            $publisher = 
                Publisher::where('name', '=', $request->publisher['name'])->first() ??
                Publisher::create(['name' => $request->publisher['name']]);
            $request['publisher_id'] = $publisher->id;
        }

        if($request->publishing_place_id == null && $request->publisher != null) {
            $place = 
                PublishingPlace::where('name', '=', $request->publishing_place['name'])->first() ??
                PublishingPlace::create(['name' => $request->publishing_place['name']]);
            
            $request['publishing_place_id'] = $place->id;
        }

        $book = Book::create(
            $request->only(['type_id', 'price', 'title', 'author', 'isbn', 'year_published', 'edition', 'volume', 'publisher_id', 'publishing_place_id', 'dewey_id'])
        );

        $book->categories()->attach($request->selected_category_ids);

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
        $book = Book::with('dewey')
            ->with('publisher')
            ->with('publishingPlace')
            ->with('categories')->find($id);
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
        $book = Book::find($id);
        
        if($book == null){
            return response()->json([
                'message' => 'The book is destroyed long time ago'
            ], 404);
        }

        // check if publisher changed
        if($request->publisher_id == null && $request->publisher != null && strlen($request->publisher['name']) > 0) {
            $publisher = 
                Publisher::where('name', '=', $request->publisher['name'])->first() ??
                Publisher::create(['name' => $request->publisher['name']]);
            $request['publisher_id'] = $publisher->id;
        }

        if($request->publishing_place_id == null && $request->publishing_place != null && strlen($request->publishing_place['name'] > 0)) {
            $place = 
                PublishingPlace::where('name', '=', $request->publishing_place['name'])->first() ??
                PublishingPlace::create(['name' => $request->publishing_place['name']]);
            
            $request['publishing_place_id'] = $place->id;
        }

        $book->update($request->only(['type_id', 'price', 'title', 'author', 'isbn', 'year_published', 'edition', 'volume', 'publisher_id', 'publishing_place_id', 'dewey_id']));

        return response()->json([
            'book' => $book
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
}
