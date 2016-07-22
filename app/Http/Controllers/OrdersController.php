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

    /**
     * @var OrderItemRepository
     */
    private $orderItemRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(OrderRepository $orderRepository, OrderItemRepository $orderItemRepository, UserRepository $userRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->orderItemRepository = $orderItemRepository;
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $orders = $this->orderRepository->orderBy('id')->paginate(5);

        return view('admin.orders.index', compact('orders'));
    }

    public function edit($id)
    {
        $order = $this->orderRepository->find($id);
        $users = $this->userRepository->lists('name', 'id');
        $states = [0=>'Pendente', 1=>'Processando', 2=>'Entregue', 3=>'Cancelado'];

        return view('admin.orders.edit', compact('order', 'users', 'states'));
    }

    public function update(AdminOrderRequest $request, $id)
    {
        $data = $request->all();
        $this->orderRepository->update($data, $id);

        return redirect()->route('admin.orders.index');
    }
}
