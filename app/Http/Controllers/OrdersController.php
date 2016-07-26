<?php

namespace CodeDelivery\Http\Controllers;

use CodeDelivery\Http\Requests\AdminOrderRequest;
use CodeDelivery\Repositories\OrderItemRepository;
use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\UserRepository;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;

use CodeDelivery\Http\Requests;

class OrdersController extends Controller
{
    /**
     * @var OrderRepository
     */
    private $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function index()
    {
        $orders = $this->orderRepository->orderBy('id')->paginate(5);

        return view('admin.orders.index', compact('orders'));
    }

    public function edit($id, UserRepository $userRepository)
    {
        $order = $this->orderRepository->find($id);
        $deliverymen = $userRepository->getDeliverymen();
        $states = [0=>'Pendente', 1=>'Processando', 2=>'Entregue', 3=>'Cancelado'];

        return view('admin.orders.edit', compact('order', 'deliverymen', 'states'));
    }

    public function update(AdminOrderRequest $request, $id)
    {
        $data = $request->all();
        $this->orderRepository->update($data, $id);

        return redirect()->route('admin.orders.index');
    }
}
