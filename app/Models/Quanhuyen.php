<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quanhuyen extends Model
{
    use HasFactory;
    protected $table = 'quanhuyen';
    protected $fillable= [
        'id',
        'name',
        'type',
        'id_tp',
        'created_at',
        'updated_at',
    ];
}
