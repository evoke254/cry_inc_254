<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppSettings extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $casts = [
        'image'     => 'string',
        'version'   => 'string',
    ];
}
