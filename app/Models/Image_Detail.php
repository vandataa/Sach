<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image_Detail extends Model
{
    use HasFactory;
    protected $fillable= [
        'image_path',
        'id_book',
        'created_at',
        'updated_at',
    ];
    protected $table='image_details';
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
  
}
