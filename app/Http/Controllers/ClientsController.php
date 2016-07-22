<?php

namespace CodeDelivery\Http\Controllers;

use CodeDelivery\Http\Requests\AdminClientRequest;
use CodeDelivery\Repositories\ClientRepository;
use CodeDelivery\Repositories\UserRepository;
use Illuminate\Http\Request;

use CodeDelivery\Http\Requests;

class ClientsController extends Controller
{

    /**
     * @var ClientRepository
     */
    private $repository;

    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(ClientRepository $repository, UserRepository $userRepository)
    {
        $this->repository = $repository;
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $clients = $this->repository->orderBy('id')->paginate(5);

        return view('admin.clients.index', compact('clients'));
    }

    public function create()
    {
        return view('admin.clients.create');
    }

    public function store(AdminClientRequest $request)
    {
        $data = $request->all();

        $data['user']['password'] = bcrypt(str_random(10));

        $user = $this->userRepository->create($data['user']);
        $data['user_id'] = $user->id;

        $this->repository->create($data);

        return redirect()->route('admin.clients.index');
    }

    public function edit($id)
    {
        $client = $this->repository->with('user')->find($id);

        return view('admin.clients.edit', compact('client'));
    }

    public function update(AdminClientRequest $request, $id)
    {
        $data = $request->all();
        $client = $this->repository->update($data, $id);
        $this->userRepository->update($data['user'], $client->user->id);

        return redirect()->route('admin.clients.index');
    }

    public function destroy($id)
    {
        $client = $this->repository->find($id);
        $user = $client->user;

        $client->delete();
        $user->delete();

        return redirect()->route('admin.clients.index');
    }

}
