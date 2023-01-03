<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'order_id'
    ];

    public function orderDetails()
    {
        return $this->belongsTo(OrderDetails::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
