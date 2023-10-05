<?php

namespace App\Http\Controllers\API;

use App\Enum\Services\StatusOrder;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest\StoreOrderRequest;
use App\Http\Requests\OrderRequest\UpdateOrderStatusRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderItem;
use App\Notifications\OrderStatusChanged;
use App\Repositories\OrderRepository;

class OrderController extends Controller
{

    public function __construct(protected OrderRepository $orderRepository)
    {
    }

    /**
     * Display a paginated list of orders.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = $this->orderRepository->paginateOrders(10);
        return OrderResource::collection($orders);
    }

    /**
     * Create a new order.
     *
     * @param  StoreOrderRequest  $request
     * @return \Illuminate\Http\Response
     */

    public function store(StoreOrderRequest $request)
    {
        $validatedData = $request->validated();

        $order = $this->orderRepository->createOrder([
            'user_id' => $validatedData['user_id'],
            'total_amount' => $validatedData['total_amount'],
            'status' => $validatedData['status'],
        ]);

        foreach ($validatedData['items'] as $itemData) {
            $orderItem = new OrderItem([
                'order_id' => $order->id,
                'product_id' => $itemData['product_id'],
                'option_id' => $itemData['option_id'],
                'quantity' => $itemData['quantity'],
            ]);
            $orderItem->save();        }

        $order->user->notify(new OrderStatusChanged($order->status));

        return new OrderResource($order);
    }
    /**
     * Show the specified order.
     *
     * @param  Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return new OrderResource($order);
    }

    /**
     * Update the status of an order.
     *
     * @param  UpdateOrderStatusRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(UpdateOrderStatusRequest $request, $id)
    {
        $order = $this->orderRepository->findOrderById($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $newStatus = StatusOrder::from($request->input('status'));

        if (!$newStatus) {
            return response()->json(['message' => 'Invalid status'], 400);
        }

        $this->orderRepository->updateOrder($order, ['status' => $newStatus->value]);

        $order->user->notify(new OrderStatusChanged($order->status));

        return new OrderResource($order);
    }
    /**
     * Cancel an order.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cancel($id)
    {
        $order = $this->orderRepository->findOrderById($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $this->orderRepository->deleteOrder($order);

        $order->user->notify(new OrderStatusChanged($order->status));

        return response()->json(['message' => 'Order canceled']);
    }
}
