<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartCategory extends Model
{
    protected $table = 'part_category';
    
    protected $fillable = [
        'name',
        'description',
    ];
}
