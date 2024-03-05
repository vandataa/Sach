<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;
    protected $table = "activity_log";
    protected $fillable= [
        'id',
        'description',
        'subject_type ',
        'event',
        'subject_id ',
        'causer_type ',
        'causer_id ',
        'properties',

    ];

    public function subject()
{
    return $this->morphTo();
}
    public function user()
    {
        return $this->belongsTo(User::class, 'causer_id');
    }
    
}