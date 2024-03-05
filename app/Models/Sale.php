<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
class Sale extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        "code",
        "discount",
        "typeOfDiscount",
        "count",
        "start",
        "end",
        "status",
        "event",
    ];


    public function user()
    {
        return $this->belongsToMany(User::class,'code');
    }
    public function book()
    {
        return $this->hasMany(Book::class);
    }

    public function scopeSearch($query)
    {
        if ($table_search = request()->table_search) {
            $query = $query->where('code', 'like', '%' . $table_search . '%');
        }
        return $query;
    }
    public static function getSale($SaleID = 0)
    {
        return Sale::where('sales.id', '=' . $SaleID)
            ->select(
                'sales.id as SaleID',
                'sales.code',
                'sales.discount',
                'sales.count',
                'sales.start',
                'sales.end',
            )
            ->get()->first();
    }


}
