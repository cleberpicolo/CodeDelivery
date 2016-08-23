<?php

namespace CodeDelivery\Http\Controllers\Api;

use CodeDelivery\Http\Controllers\Controller;
use CodeDelivery\Repositories\CupomRepository;

class CupomController extends Controller
{
    /**
     * @var CupomRepository
     */
    private $cupomRepository;

    /**
     * ClientProductController constructor.
     * @param CupomRepository $cupomRepository
     */
    public function __construct(CupomRepository $cupomRepository)
    {
        $this->cupomRepository = $cupomRepository;
    }

    public function show($code)
    {
        return $this->cupomRepository->skipPresenter(false)->findByCode($code);
    }

}
