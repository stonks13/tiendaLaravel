@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8" style="display: flex; align-items: center; justify-content: center;">
                <div class="card">
                    <div class="card-header" style="font-size: 36px; text-align: center">{{ __('OBJETOS') }}</div>
                    <div class="card-body" style="list-style: none;">
                        @foreach ($products as $product)
                            <li>{{$product->nombre}}</li>
                            <img src="data:image/jpeg;base64,{!! stream_get_contents($product->image) !!}"/>
                            <li>{{$product->precio}}</li>
                            <p class="btn-holder" style="text-align: center; background-color: cornflowerblue;
                            border-radius: 20px; font-size: 20px"><a href="{{ url('add-to-cart/'.$product->id) }}" class="btn btn-warning btn-block text-center" role="button">AÑADIR</a> </p>
                        @endforeach
                    </div>
                </div> </div> </div> </div>@endsection

<div class="card-header">
    <form method="get" action="/products">
        <input name="price" type="text"/>
        <input value="Busca" type="submit"/>
    </form>
</div>
{{ $products->links() }}


