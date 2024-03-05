<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tinhtp extends Model
{
    use HasFactory;
    protected $table = 'tinhtp';
    protected $fillable= [
        'id',
        'name',
        'type',
        'created_at',
        'updated_at',
    ];
}
