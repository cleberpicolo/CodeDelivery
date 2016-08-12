<?php

namespace CodeDelivery\Transformers;

use CodeDelivery\Models\OrderItem;
use League\Fractal\TransformerAbstract;
use CodeDelivery\Models\Order;

/**
 * Class OrderTransformer
 * @package namespace CodeDelivery\Transformers;
 */
class OrderTransformer extends TransformerAbstract
{
    //protected $defaultIncludes = ['cupom', 'items'];
    protected $availableIncludes = ['cupom', 'items', 'client', 'deliveryman'];

    /**
     * Transform the \Order entity
     * @param \Order $model
     *
     * @return array
     */
    public function transform(Order $model)
    {
        return [
            'id'         => (int) $model->id,
            'total'      => (float) $model->total,
            'status'     => (int) $model->status,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }

    //Many to One -> Cupom
    public function includeCupom(Order $model)
    {
        if(!$model->cupom) return null;
        return $this->item($model->cupom, new CupomTransformer());
    }

    //One to Many -> OrderItem
    public function includeItems(Order $model)
    {
        return $this->collection($model->items, new OrderItemTransformer());
    }

    public function includeClient(Order $model)
    {
        return $this->item($model->client, new ClientTransformer());
    }

    public function includeDeliveryman(Order $model)
    {
        if(!$model->user_deliveryman) return null;
        return $this->item($model->user_deliveryman, new DeliverymanTransformer());
    }
}
