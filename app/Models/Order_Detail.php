<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_Detail extends Model
{
    use HasFactory;
    protected $fillable = [
        'book_quantity',
        'book_id',
        'order_id',
        'created_at',
        'updated_at',
    ];
    protected $table= 'order_details';
     public function book() {
        return $this->belongsTo(Book::class);
        
     }
     public function order() {
        return $this->belongsTo(Order::class,'order_id');
        
     }


}