@extends('layouts.app')

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
                <th>Data</th>
                <th>Itens</th>
                <th>Total</th>
                <th>Status</th>
                <th>Entregador</th>
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
            @foreach($orders as $order)
            <tr>
                <td>#{{ $order->id }}</td>
                <td>{{ $order->client->user->name }}</td>
                <td>{{ $order->created_at }}</td>
                <td>
                    @foreach($order->items as $item)
                        <li>{{ $item->product->name }}</li>
                    @endforeach
                </td>
                <td>R$ {{ $order->total }}</td>
                <td>{{ $order->status }}</td>
                <td>{{ ($order->user_deliveryman)? $order->user_deliveryman->name : '-' }}</td>
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