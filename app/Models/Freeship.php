<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Freeship extends Model
{
    use HasFactory;
    protected $table = 'freeship';
    protected $fillable= [
        'id',
        'price',
        'id_tp',
        'id_qh',
        'id_xa',
        'created_at',
        'updated_at',
    ];
    public function city(){
        return $this->belongsTo(Tinhtp::class,'id_tp');
    }
    public function province(){
        return $this->belongsTo(Quanhuyen::class,'id_qh');
    }
    public function wards(){
        return $this->belongsTo(Xaphuong::class,'id_xa');
    }
}
