@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">My Shopping Cart</div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                            <div class="form-group">
                                @if(count($items) > 0)
                                    <table class="table-bordered table-hover table">
                                        <tr>
                                            <th></th>
                                            <th>Product</th>
                                            <th class="text-right">Quantity</th>
                                            <th class="text-right">Price</th>
                                            <th class="text-right">Total</th>
                                            <th></th>
                                        </tr>
                                        @php
                                            $total = 0;
                                        @endphp

                                        @foreach($items as $item)
                                            @php
                                                $total += $item->total;
                                            @endphp
                                            <tr>
                                                <td><img src="../images/{!! $item->products->image !!}"
                                                         style="height: 80px;"></td>
                                                <td>{!! $item->products->name !!}</td>
                                                <td class="text-right">{!! $item->quantity !!}</td>
                                                <td class="text-right">{!! $item->currencies->symbol !!} {!! $item->price !!}</td>
                                                <td class="text-right">{!! $item->currencies->symbol !!} {!! $item->total !!}</td>
                                                <td>
                                                    <form class="form" role="form" method="DELETE"
                                                          action="{{ route('shoppingcart.destroy', $item->id) }}">
                                                        {{ csrf_field() }}
                                                        <button type="submit" class='btn btn-xs btn-danger'>Remove
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <th class="text-right" colspan="4">Total</th>
                                            <th class="text-right">{!! $items[0]->currencies->symbol !!} {!! number_format($total, 2) !!}</th>
                                            <td>
                                                <a href="{!! route('shoppingcart.buy') !!}" class='btn btn-success'>
                                                    Buy
                                                </a>
                                            </td>
                                        </tr>

                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
