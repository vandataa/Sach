<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Order extends Model
{

    use HasFactory;
    protected $fillable = [
        'name',
        'date',
        'id_customer',
        'book_id',
        'address',
        'email',
        'phone',
        'total',
        'ship',
        'note',
        'status',
        'code_bill',
        'payment',
        'code_sale',
    ];
    public function scopeSearch($query)
    {
        if ($table_search = request()->table_search) {
            $query = $query->where('id', 'like', '%' . $table_search . '%');

        }
        return $query;
    }
    public function orderDetails()
    {
        return $this->hasMany(Order_Detail::class);
    }
}
