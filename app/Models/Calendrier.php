<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calendrier extends Model
{
    use HasFactory;
    protected $table = 'calendrier';
    protected $primaryKey   = 'Id';
    public $timestamps = false;
}
