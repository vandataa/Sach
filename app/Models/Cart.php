<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable= [
        'book_id',
        'user_id',
        'quantity',
        'money',
        'created_at',
        'updated_at',
    ];
    protected $table='carts';
    public function books()
    {
        return $this->belongsTo(Book::class);
    }
    public function getBy2( $userId)
    {
       return Cart::whereUserId($userId)->first();
    }

     public function firtOrCreateBy($userId)
     {

        $cart = $this->getBy2($userId);

     if (!$cart) {
        $cart->create(['user_id' => $userId]);

     }
     return $cart;
     }
     public function getBy1( $bookId, $userId)
    {
       return Cart::whereBookId($bookId)->whereUserId($userId)->first();
    }
}
