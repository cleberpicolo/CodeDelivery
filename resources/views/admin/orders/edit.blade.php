@extends('layouts.app')

@section('content')

    <div class="container">
        <h2>Pedido #{{ $order->id }} - R$ {{ $order->total }}</h2>
        <h3>Client: {{ $order->client->user->name }}</h3>
        <h4>Data: {{ $order->created_at }}</h4>

        <p>
            <b>Entregar em:</b> <br>
            {{ $order->client->address }} - {{ $order->client->city }} - {{ $order->client->state }}
        </p>
        <br>

        @include('errors._check')

        {!! Form::model($order, ['route'=>['admin.orders.update', $order->id]]) !!}

        <div class="form-group">
            {!! Form::label('Status', 'Status:') !!}
            {!! Form::select('status', $states, null, ['class'=>'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('Deliveryman', 'Entregador:') !!}
            {!! Form::select('user_deliveryman_id', $deliverymen, null, ['class'=>'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::submit('Salvar', ['class'=>'btn btn-primary']) !!}
        </div>

        {!! Form::close() !!}

    </div>

@endsection