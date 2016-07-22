<?php

use CodeDelivery\Models\Client;
use CodeDelivery\Models\Order;
use CodeDelivery\Models\OrderItem;
use CodeDelivery\Models\Product;
use Illuminate\Database\Seeder;

class OrderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clients = Client::all();

        foreach ($clients as $client){

            factory(Order::class, rand(1, 5))->make()->each(function ($o) use($client){

                $o->client_id = $client->id;
                $o->save();

                for($i=0; $i<rand(1,2); $i++){
                    $orderItem = factory(OrderItem::class)->make();
                    $product = Product::find(rand(1, 50));
                    $orderItem->product()->associate($product);
                    $o->items()->save($orderItem);
                }

            });

        }
    }
}
