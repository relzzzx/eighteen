<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['order_id', 'status', 'proof_image', 'method'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}