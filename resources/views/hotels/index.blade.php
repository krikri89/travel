@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h1>List of hotels</h1>
                    <div>
                        <a href="{{route('hotels-index', ['sort'=>'asc'])}}">A-Z</a>
                        <a href="{{route('hotels-index', ['sort'=>'desc'])}}">Z-A</a>
                        <a href="{{route('hotels-index')}}">Reset</a>
                    </div>
                </div>

                <div class="card-body">
                    <ul class="list-group">
                        @forelse($hotels as $hotel)
                        <li class="list-group-item">
                            <h4>{{$hotel->hotel}} Hotel</h4>
                            <h5>{{$hotel->hotelConnectCountry->country}}</h5>

                            <div class="item-bin">
                                <div class="item-box">
                                    <div>7days in {{$hotel->period}}</div>
                                    <div class="item-box">
                                        <div>{{$hotel->price}} EUR</div>
                                    </div>

                                </div>
                                @if($hotel->photo)
                                <div class="image-box">
                                    <img src="{{$hotel->photo}}">
                                </div>
                                @endif

                                <div class="controls">
                                    <a class="btn btn-outline-secondary m-2" href="{{route('hotels-show', $hotel->id)}}">SHOW</a>

                                    {{-- @if(Auth::user()->role > 9) --}}
                                    <a class="btn btn-outline-primary m-2" href="{{route('hotels-edit', $hotel)}}">EDIT</a>
                                    <form class="delete" action="{{route('hotels-delete', $hotel)}}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-outline-danger m-2" type="submit">Remove</button>
                                    </form>
                                    {{-- @endif --}}

                                </div>
                            </div>
                        </li>
                        @empty
                        <li class="list-group-item">No hotels, no life.</li>
                        @endforelse
                    </ul>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
