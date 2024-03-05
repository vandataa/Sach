<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
class Book extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'title_book',
        'original_price',
        'price',
        'book_image',
        'description',
        'quantity',
        'id_author',
        'id_cate',
        'id_publisher',
        'images',
        'status',
        'created_at',
        'updated_at',
    ];
    protected $table = 'books';
    public function category()
    {
        return $this->belongsTo(Category::class, 'id_cate');
    }

    public function author()
    {
        return $this->belongsTo(Author::class, 'id_author');
    }
    public function publisher()
    {
        return $this->belongsTo(Publisher::class, 'id_publisher');
    }
    public function orderDetails()
    {
        return $this->hasMany(Order_Detail::class,'book_id');
    }
    public function scopeSearch($query)
    {
        if ($table_search = request()->table_search) {
            $query = $query->where('title_book', 'like', '%' . $table_search . '%')->where('publish_house', 'like', '%' . $table_search . '%');
        }
        return $query;
    }


    public static function getBookInCart($bookID = 0)
    {
        return Book::where('books.id', '=' . $bookID)
            ->select(
                'books.id as bookID',
                'books.book_image',
                'books.price',
                'books.title_book'
            )
            ->get()->first();
    }
}