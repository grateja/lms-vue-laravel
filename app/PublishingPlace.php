<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Book;

class PublishingPlace extends Model
{
    protected $fillable = ['name', 'description'];
    
    public function books(){
        return $this->hasMany(Book::class);
    }
}
