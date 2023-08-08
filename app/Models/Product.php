<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'quantity', 'is_active', 'user_id', 'order_number', 'uom', 'user_id'];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function reorders()
    {
        return $this->hasMany(ReOrder::class);
    }
}
