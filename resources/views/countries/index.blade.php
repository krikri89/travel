@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h1>List of countries</h1>
                    <div>
                        <a href="{{route('countries-index', ['sort'=>'asc'])}}">A-Z</a>
                        <a href="{{route('countries-index', ['sort'=>'desc'])}}">Z-A</a>
                        <a href="{{route('countries-index')}}">Reset</a>
                    </div>
                </div>

                <div class="card-body">
                    <ul class="list-group">
                        @forelse($countries as $country)
                        <li class="list-group-item">
                            <div class="item-bin">
                                <div class="item-box">
                                    <h2>{{$country->country}}</h2>
                                </div>
                                <div class="controls">
                                    <a class="btn btn-outline-secondary m-2" href="{{route('countries-show', $country->id)}}">SHOW</a>

                                    {{-- @if(Auth::user()->role > 9) --}}
                                    <a class="btn btn-outline-primary m-2" href="{{route('countries-edit', $country)}}">EDIT</a>
                                    <form class="delete" action="{{route('countries-delete', $country)}}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-outline-danger m-2" type="submit">Destroy</button>
                                    </form>
                                    {{-- @endif --}}

                                </div>
                            </div>
                        </li>
                        @empty
                        <li class="list-group-item">No countries, no life.</li>
                        @endforelse
                    </ul>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
