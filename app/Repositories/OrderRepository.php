<?php

namespace App\Repositories;

use App\Models\Order;

class OrderRepository
{
    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function createOrder(array $data)
    {
        return $this->order->create($data);
    }

    public function updateOrder(Order $order, array $data)
    {
        $order->update($data);
        return $order;
    }

    public function deleteOrder(Order $order)
    {
        $order->delete();
    }

    public function findOrderById($id)
    {
        return $this->order->find($id);
    }

    public function paginateOrders($perPage = 10)
    {
        return $this->order->paginate($perPage);
    }
}


