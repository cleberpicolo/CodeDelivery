@extends('layouts.app')

@section('content')

    <div class="container">
        <h3>Editando Pedido</h3>

        @include('errors._check')

        {!! Form::model($order, ['route'=>['admin.orders.update', $order->id]]) !!}

        <div class="form-group">
            {!! Form::label('Deliveryman', 'Entregador:') !!}
            {!! Form::select('user_deliveryman_id', $users, null, ['class'=>'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('Status', 'Status:') !!}
            {!! Form::select('status', $states, null, ['class'=>'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::submit('Salvar', ['class'=>'btn btn-primary']) !!}
        </div>

        {!! Form::close() !!}

    </div>

@endsection