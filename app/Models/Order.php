<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'booth_id', 'payment_method', 'status', 'notes'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function booth()
    {
        return $this->belongsTo(Booth::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

}
