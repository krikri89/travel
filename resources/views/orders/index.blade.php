@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @forelse($orders as $order)
            <div class="card mt-3">
                <div class="card-header">Order from: {{$order->cartConnectUser->name}}</div>

                <div class="card-body">
                    <ul class="list-group">
                        @forelse($order->hotels as $hotel)
                        <li class="list-group-item">
                            <div class="color-box2">
                                <i>{{$hotel->hotelConnectCountry->hotel}}</i>
                                <h2>{{$hotel->hotel}}: <small>{{$hotel->count}} units</small></h2>
                            </div>
                        </li>
                        @endforeach
                        <li class="list-group-item">
                            <div class="controls mt-2">
                                <form class="delete form" action="{{route('orders-status', $order)}}" method="post">
                                    @csrf
                                    @method('put')
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label>What status?</label>
                                                    <select class="form-control" name="status">
                                                        @foreach($statuses as $key => $status)
                                                        <option value="{{$key}}" @if($key==$order->status) selected @endif>{{$status}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <button type="submit" class="btn btn-outline-info m-4">Set status</button>
                                            </div>
                                            {{-- <div class="col-3"> --}}
                                            {{-- <a class="btn btn-outline-success m-4" href="{{route('orders-pdf', $order)}}">Get PDF</a> --}}
                                            {{-- </div> --}}
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>
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
