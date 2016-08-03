<?php

namespace CodeDelivery\Http\Controllers\Api\Client;

use Auth;
use CodeDelivery\Http\Controllers\Controller;
use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\ProductRepository;
use CodeDelivery\Repositories\UserRepository;
use CodeDelivery\Services\OrderService;
use Illuminate\Foundation\Http\Middleware\Authorize;
use Illuminate\Http\Request;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class ClientCheckoutController extends Controller
{
    /**
     * @var OrderRepository
     */
    private $orderRepository;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var ProductRepository
     */
    private $productRepository;
    /**
     * @var OrderService
     */
    private $orderService;


    /**
     * CheckoutController constructor.
     * @param OrderRepository $orderRepository
     * @param UserRepository $userRepository
     * @param ProductRepository $productRepository
     * @param OrderService $orderService
     */
    public function __construct(
        OrderRepository $orderRepository,
        UserRepository $userRepository,
        ProductRepository $productRepository,
        OrderService $orderService)
    {
        $this->userRepository = $userRepository;
        $this->productRepository = $productRepository;
        $this->orderRepository = $orderRepository;
        $this->orderService = $orderService;
    }

    public function index()
    {
        $id = Authorizer::getResourceOwnerId();
        $clientID = $this->userRepository->find($id)->client->id;
        $orders = $this->orderRepository->with('items')->scopeQuery(function ($query) use($clientID){
            return $query->where('client_id','=',$clientID);
        })->paginate();

        return $orders;
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $id = Authorizer::getResourceOwnerId();
        $clientID = $this->userRepository->find($id)->client->id;
        $data['client_id'] = $clientID;
        $o = $this->orderService->create($data);
        $o = $this->orderRepository->with('items')->find($o->id);
        return $o;
    }

    public function show($id)
    {
        $o = $this->orderRepository->with(['client','items','cupom'])->find($id);
        $o->items->each(function ($item){
            $item->product;
        });
        return $o;
    }
}
