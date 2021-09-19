<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ligne extends Model
{
    use HasFactory;
    protected $table = 'ligne_calendrier';
    protected $primaryKey   = 'Id_calendrier';
    public $timestamps = false;
}
