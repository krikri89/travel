@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @forelse($orders as $order)
            <div class="card mt-3">
                <div class="card-header">Order</div>
                <div class="card-body">

                    <div class="right m-2">
                        <small>{!!$order->time!!}</small>
                        {{$statuses[$order->status]}}
                    </div>
                    <ul class="list-group">
                        @foreach($order->hotels as $hotel)
                        <li class="list-group-item">
                            <div class="color-box2">
                                <i>{{$hotel->hotelConnectCountry->country}}</i>

                                <h2>{{$hotel->hotel}}: <small>{{$hotel->count}} units</small></h2>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @empty
            <div>No orders yet</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
