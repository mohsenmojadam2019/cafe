<?php

namespace App\Models;

use App\Enum\Services\StatusOrder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','total_amount', 'status'];

    public function Items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
