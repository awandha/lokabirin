<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $fillable = ['name', 'description', 'price', 'is_available'];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
