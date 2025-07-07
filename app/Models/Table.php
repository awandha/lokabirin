<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    protected $fillable = ['table_code', 'name'];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
