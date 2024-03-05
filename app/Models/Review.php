<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
class Review extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'reviews';
    protected $fillable = [
        'content', 'id_customer', 'id_book','image'
    ];


    public function user()
    {
        return $this->belongsTo(User::class,'id_customer');
    }
    public function book()
    {
        return $this->belongsTo(Book::class, 'id_book');
    }
    public function scopeSearch($query)
    {
        if ($table_search = request()->table_search) {
            $id_book = Book::select('id')->where('title_book', '=', $table_search);
            $id_customer = User::select('id')->where('username', '=', $table_search);
            $query = $query->where('id_book', '=',  $id_book)->orWhere('id_customer', '=', $id_customer);
        }
    }
}
