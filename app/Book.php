<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Publisher;
use App\PublishingPlace;
use App\Category;

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
            ->select(['id', 'decimal', 'classification', 'description', DB::raw('CONCAT(`decimal`, " - ", `classification`) as display')]);
    }

    public function categories(){
        return $this->belongsToMany(Category::class, 'book_categories', 'book_id', 'category_id')
            ->select(['categories.id','categories.name', 'categories.description']);
    }

    public function attachPublisher($publisher_name) {
        if($publisher_name) {
            $publisher = Publisher::firstOrCreate(
                ['name' => $publisher_name]
            );
            
            $this->update(['publisher_id' => $publisher->id]);

            return $publisher;
        }

        $this->update(['publisher_id' => null]);

        return null;
    }

    public function attachPublishingPlace($publishing_place_name) {
        if($publishing_place_name) {
            $publishing_place = PublishingPlace::firstOrCreate(
                ['name' => $publishing_place_name]
            );

            $this->update(['publishing_place_id' => $publishing_place->id]);

            return $publishing_place;
        }

        $this->update(['publishing_place_id' => null]);

        return null;
    }

    public function attachCategories($categories) {
        if(count($categories) > 0){
            
            $categories = $categories->map(function($category){
                $_category = Category::firstOrCreate(
                    ['name' => $category['name']]
                );
                return $_category->id;
            });
    
            $this->categories()->sync($categories);

        }
    }

    public static function generateTypeID() {
        $val = rand(100000000, 999999999);
        if(!Book::where(['type_id' => $val])->first()){
            return $val;
        }
        return Book::generateTypeID();
    }
}
