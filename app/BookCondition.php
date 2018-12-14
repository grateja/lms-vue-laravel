<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\SpecificBook;

class BookCondition extends Model
{
    public function book() {
        return $this->hasMany(SpecificBook::class);
    }
}
