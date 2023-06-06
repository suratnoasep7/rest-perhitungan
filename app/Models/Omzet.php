<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Omzet extends Model
{
    use HasFactory;
    
    /**
     * filllable
     *
     * @var array
     */
    protected $fillable = [
        'total_omzet', 'komisi'
    ];

}