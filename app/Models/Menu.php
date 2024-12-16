<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'user_id'];

    // Relasi ke model User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function booth()
{
    return $this->belongsTo(Booth::class, 'booth_id');
}
}