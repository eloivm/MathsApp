<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Superadmin extends Model implements Authenticatable
{
    use HasFactory, AuthenticatableTrait;
    
    protected $table = 'superadmin';

    protected $fillable = [
        'name',
        'surname',
        'dni',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];
}
