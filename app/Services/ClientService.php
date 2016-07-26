<?php
/**
 * Created by PhpStorm.
 * User: clebe
 * Date: 22/07/2016
 * Time: 13:57
 */

namespace CodeDelivery\Services;


use CodeDelivery\Repositories\ClientRepository;
use CodeDelivery\Repositories\UserRepository;

class ClientService
{

    /**
     * @var ClientRepository
     */
    private $clientRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(ClientRepository $clientRepository, UserRepository $userRepository)
    {
        $this->clientRepository = $clientRepository;
        $this->userRepository = $userRepository;
    }

    public function update(array $data, $id)
    {
        $this->clientRepository->update($data, $id);

        $userID = $this->clientRepository->find($id, ['user_id'])->user_id;

        $this->userRepository->update($data['user'], $userID);
    }

    public function create(array $data)
    {
        $data['user']['password'] = bcrypt(str_random(10));

        $user = $this->userRepository->create($data['user']);
        $data['user_id'] = $user->id;

        $this->clientRepository->create($data);
    }

    public function delete($id)
    {
        $client = $this->clientRepository->find($id);
        $user = $client->user;

        $client->delete();
        $user->delete();
    }

}