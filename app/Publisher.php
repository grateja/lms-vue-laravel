<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Book;

class Publisher extends Model
{
    public function books(){
        return $this->hasMany(Book::class);
    }
}
