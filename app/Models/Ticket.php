<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'venue_id',
        'name',
        'description',
        'cost'
    ];

    protected $table = 'tickets';
    protected $primaryKey = 'id';


}
