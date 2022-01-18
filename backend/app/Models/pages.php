<?php namespace App;

namespace App\Models\pages;

use Illuminate\Database\Eloquent\Model;

class pages extends Model
{
    protected $fillable = [
        'url',
        'name',
        'comments',
        'tags'
    ];
    
}