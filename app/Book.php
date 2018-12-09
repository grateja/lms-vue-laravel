<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Publisher;
use App\PublishingPlace;

class Book extends Model
{
    protected $fillable = ['type_id', 'price', 'title', 'author', 'isbn', 'year_published', 'edition', 'volume', 'publisher_id', 'publishing_place_id', 'dewey_id'];
    protected $guarded = [];

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
