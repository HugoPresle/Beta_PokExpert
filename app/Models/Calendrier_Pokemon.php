<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calendrier_Pokemon extends Model
{
    use HasFactory;
    protected $table = 'calendrier_pokemon';
    protected $primaryKey  = 'Id';
    public $timestamps = false;
}
