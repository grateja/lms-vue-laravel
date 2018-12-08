<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Publisher;
use App\PublishingPlace;

class Book extends Model
{
    public function publisher(){
        return $this->belongsTo(Publisher::class)
            ->select(['id', 'name', 'description']);
    }

    public function publishingPlace(){
        return $this->belongsTo(PublishingPlace::class)
            ->select(['id', 'name', 'description']);
    }

    public function dewey(){
        return $this->belongsTo(Dewey::class)
            ->select(['id', 'decimal', 'classification', 'description']);
    }
}
