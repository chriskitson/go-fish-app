<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Basket extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'date',
        'venue_id',
        'ticket_id',
        'qty',
        'user_id'
    ];

    protected $table = 'basket';
    protected $primaryKey = 'id';
}
