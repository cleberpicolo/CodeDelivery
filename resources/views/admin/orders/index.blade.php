@extends('layouts.app')

<?php

//        echo "<pre>";
//        print_r($orders);
//        die();

?>

@section('content')

    <div class="container">
        <h3>Pedidos</h3>

        <br>
        <br>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Entregador</th>
                <th>Itens</th>
                <th>Total</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->client->user->name }}</td>
                <td>{{ ($order->user_deliveryman)? $order->user_deliveryman->name : '-' }}</td>
                <td>
                    @foreach($order->items as $item)
                        <li>{{ $item->product->name }}</li>
                    @endforeach
                </td>
                <td>{{ $order->total }}</td>
                <td>{{ $order->status }}</td>
                <td>
                    <a href="{{ route('admin.orders.edit', ['id'=>$order->id]) }}" class="btn btn-info btn-sm">Editar</a>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>

        {!! $orders->render() !!}

    </div>

@endsection