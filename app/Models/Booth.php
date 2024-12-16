<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booth extends Model
{
    protected $fillable = ['name', 'description', 'user_id', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function menus()
    {
        return $this->hasMany(Menu::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function isOpen(): bool
    {
        return $this->status === 'open';
    }
}
