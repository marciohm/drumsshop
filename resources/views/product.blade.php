@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">{!! $product->name !!}</div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                            <div class="form-group">
                                <p style="text-align: center">
                                    <a href="{!! route('product', [$product->slug]) !!}">
                                        <img src="../images/{!! $product->image !!}"
                                             style="height: 200px;">
                                    </a>
                                </p>

                                <p style="text-align: center">
                                    @if(empty(session('selected_currency')))
                                        {!! $product->prices[0]->currencies->symbol !!} {!! $product->prices[0]->price !!}
                                    @else
                                        {!! $product->prices[session('selected_currency') - 1]->currencies->symbol !!} {!! $product->prices[session('selected_currency') - 1]->price !!}
                                    @endif
                                </p>

                                <p style="text-align: center">
                                    <a href="{!! route('product', [$product->slug]) !!}" class='btn btn-success'> Add To
                                        Cart</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
