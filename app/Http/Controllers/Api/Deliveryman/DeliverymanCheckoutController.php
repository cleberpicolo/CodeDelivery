<?php

namespace CodeDelivery\Http\Controllers\Api\Deliveryman;

use CodeDelivery\Events\GetLocationDeliveryman;
use CodeDelivery\Http\Controllers\Controller;
use CodeDelivery\Models\Geo;
use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\UserRepository;
use CodeDelivery\Services\OrderService;
use Illuminate\Http\Request;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class DeliverymanCheckoutController extends Controller
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
     * @var OrderService
     */
    private $orderService;

    private $with = ['items', 'cupom', 'client'];

    /**
     * CheckoutController constructor.
     * @param OrderRepository $orderRepository
     * @param UserRepository $userRepository
     * @param OrderService $orderService
     */
    public function __construct(
        OrderRepository $orderRepository,
        UserRepository $userRepository,
        OrderService $orderService)
    {
        $this->userRepository = $userRepository;
        $this->orderRepository = $orderRepository;
        $this->orderService = $orderService;
    }

    public function index()
    {
        $id = Authorizer::getResourceOwnerId();
        $orders = $this->orderRepository
            ->skipPresenter(false)
            ->with($this->with)
            ->scopeQuery(function ($query) use($id){
                return $query->where('user_deliveryman_id','=',$id);
            })->paginate();

        return $orders;
    }

    public function show($id)
    {
        $userID = Authorizer::getResourceOwnerId();
        return $this->orderRepository
            ->skipPresenter(false)
            ->getByIdAndDeliveryman($id, $userID);
    }

    public function updateStatus(Request $request, $id)
    {
        $userID = Authorizer::getResourceOwnerId();
        return $this->orderService->updateStatus($id, $userID, $request->get('status'));
    }

    public function geo(Request $request, Geo $geo, $id)
    {
        $userID = Authorizer::getResourceOwnerId();
        $order = $this->orderRepository->getByIdAndDeliveryman($id, $userID);
        $geo->lat = $request->get('lat');
        $geo->lon = $request->get('lon');

        event(new GetLocationDeliveryman($geo, $order));

        return $geo;
    }
}
