<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Publisher extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable =[
        'name',
        'slug',
    ];
    protected $table ='publisher';
    public function books()
    {
        return $this->hasMany(Book::class, 'id_publisher');

    }
    
    public function scopeSearch($query) {
        if($table_search= request()->table_search) {
            $query = $query->where('name', 'like','%'.$table_search.'%');

        }
    }
    public static function getListPublisher()
    {
        return Publisher::select('id','name','slug')
                       ->distinct()
                       ->orderBy('name')
                       ->get();
    }
}