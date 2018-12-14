<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Book;

class SpecificBook extends Model
{
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function condition(){
        return $this->belongsTo(BookCondition::class);
    }
}
