<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Counts extends Model
{
    use HasFactory;
    
    /**
     * filllable
     *
     * @var array
     */
    protected $fillable = [
        'marketing_name', 'month', 'total', 'persentage', 'nominal_persentage'
    ];

}