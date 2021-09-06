<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'session',
        'qty',
        'total',
        'booking_fee',
        'ticket_fee',
        'confirmed',
        'transaction'
    ];

    protected $table = 'transactions';
    protected $primaryKey = 'id';
}