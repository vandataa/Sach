<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Customer extends Model
{
    use HasFactory, LogsActivity;
    protected $table = 'users';
    protected $fillable = [
        'id', 'username',    'name',    'email',    'email_verified_at',    'password',    'address',    'phone',    'role',    'remember_token',    'created_at',    'updated_at'
    ];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(
            [
                'id', 'username',    'name',    'email',    'email_verified_at',    'password',    'address',    'phone',    'role',    'remember_token',    'created_at',    'updated_at'
            ]
        )->logOnlyDirty();
    }
}
