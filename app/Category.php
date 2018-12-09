<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Book;

class Category extends Model
{
    public function books(){
        return $this->belongsToMany(Book::class, 'book_categories', 'book_id', 'category_id');
    }
}
