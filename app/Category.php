<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Book;

class Category extends Model
{
    protected $fillable = ['name', 'description'];

    public function books(){
        return $this->belongsToMany(Book::class, 'book_categories', 'book_id', 'category_id');
    }
}
