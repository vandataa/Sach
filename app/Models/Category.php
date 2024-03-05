<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
class Category extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable= [
        'cate_name',
        'slug',
        'created_at',
        'updated_at',
    ];
    protected $table ='categories';

    public function books()
    {
        return $this->hasMany(Book::class);

    }

    public function scopeSearch($query) {
        if($table_search= request()->table_search) {
            $query = $query->where('cate_Name', 'like','%'.$table_search.'%');

        }
    }
}
