<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'account',
        'address',
        'description',
        'place_id',
        'distance',
        'deleted',
        'open_sunday',
        'open_monday',
        'open_tuesday',
        'open_wednesday',
        'open_thursday',
        'open_friday',
        'open_saturday'
    ];

    protected $table = 'venues';
    protected $primaryKey = 'id';


}
