<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Book;

class SpecificBook extends Model
{
    protected $fillable = ['unique_id','book_id', 'availability', 'condition_id'];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function condition(){
        return $this->belongsTo(BookCondition::class);
    }

    public static function generateUniqueID(){
        $val = rand(100000000, 999999999);
        if(!SpecificBook::where(['unique_id' => $val])->first()){
            return $val;
        }

        return SpecificBook::generateUniqueID();
    }
}
