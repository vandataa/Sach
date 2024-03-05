<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
class Author extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable= [
        'name_author',
        'author_image',
        'info',
        'created_at',
        'updated_at',
    ];
    protected $table = 'authors';
    public function books()
    {
        return $this->hasMany(Book::class);

    }
    public static function getListAuthor()
    {
        return Author::select('id','name_author','author_image','info')
                       ->distinct()
                       ->orderBy('name_author')
                       ->get();

    }
    public function scopeSearch($query) {
        if($table_search= request()->table_search) {
            $query = $query->where('name_author', 'like','%'.$table_search.'%');

        }
    }
}
