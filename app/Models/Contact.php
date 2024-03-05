<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Contact extends Model
{
    use HasFactory,LogsActivity;
    protected $table = 'contact';
    protected $fillable = [
        'name', 'email', 'subject','message'
    ];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(
            [
                'name', 'email', 'subject','message'
            ]
        )->logOnlyDirty();
    }
}
