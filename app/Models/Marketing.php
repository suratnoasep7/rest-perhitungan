<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marketing extends Model
{
    use HasFactory;
    
    /**
     * filllable
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

}