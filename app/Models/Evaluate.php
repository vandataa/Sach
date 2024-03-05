<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Evaluate extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = ['user_id', 'orderDetail_id','book_id' ,'comment', 'rating'];
    protected $table = 'evaluate';
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderDetail()
    {
        return $this->belongsTo(Order_Detail::class);
    }
    public function books()
    {
        return $this->belongsTo(Book::class);
    }
}