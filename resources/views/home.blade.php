@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">
            @foreach($products as $product)
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">{!! $product->name !!}</div>
                        <div class="panel-wrapper collapse in">
                            <div class="panel-body">
                                <div class="form-group">
                                    <p style="text-align: center">
                                        <a href="{!! route('product', [$product->slug]) !!}">
                                            <img src="images/{!! $product->image !!}"
                                                 style="height: 150px;">
                                        </a>
                                    </p>

                                    <p style="text-align: center">
                                        @if(empty(session('selected_currency')))
                                            {!! $product->prices[0]->currencies->symbol !!} {!! $product->prices[0]->price !!}
                                        @else
                                            {!! $product->prices[session('selected_currency') - 1]->currencies->symbol !!} {!! $product->prices[session('selected_currency') - 1]->price !!}
                                        @endif
                                    </p>

                                    <form class="form" role="form" method="POST"
                                          action="{{ route('shoppingcart.store') }}">
                                        {{ csrf_field() }}
                                        <p style="text-align: center">
                                            <input type="hidden" name="product_id" value="{!! $product->id !!}">
                                            <button type="submit" value="Add To Cart" class='btn btn-success'>Add To
                                                Cart
                                            </button>
                                        </p>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
