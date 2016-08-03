<?php

namespace CodeDelivery\Http\Controllers\Api;

use Auth;
use CodeDelivery\Http\Controllers\Controller;
use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\ProductRepository;
use CodeDelivery\Repositories\UserRepository;
use CodeDelivery\Services\OrderService;
use Illuminate\Foundation\Http\Middleware\Authorize;
use Illuminate\Http\Request;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class AuthController extends Controller
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * AuthController constructor.
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $id = Authorizer::getResourceOwnerId();
        $userAuthenticated = $this->userRepository->with('client')->find($id);

        return $userAuthenticated;
    }

}
