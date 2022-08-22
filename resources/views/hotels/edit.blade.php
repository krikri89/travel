@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h1>hotel Edit</h1>
                </div>
                <div class="card-body">
                    <form action="{{route('hotels-update', $hotel)}}" method="post" enctype="multipart/form-data">

                        <div class="form-group">
                            <label>hotel name</label>
                        </div>
                        <input class="form-control" type="text" name="hotel" value="{{$hotel->name}}" />
                </div>
                <div class="form-group">
                    <label>What country?</label>
                    <select class="form-control" name="country_id">
                        @foreach($countries as $country)
                        <option value="{{$country->id}}" @if($country->id == $hotel->country_id)selected @endif>{{$country->country}}</option>
                        @endforeach
                    </select>
                </div>

                @if($hotel->photo)
                <div class="image-box">
                    <img src="{{$hotel->photo}}">
                </div>
                @endif

                <div class="form-group">
                    <label>New image</label>
                    <input class="form-control" type="file" name="photo" />
                </div>

                @csrf
                @method('put')
                <button class="btn btn-outline-success mt-4" type="submit">Ja, update</button>
                </form>
                @if($hotel->photo)
                <form action="{{route('hotels-delete-pic', $hotel)}}" method="post">
                    @csrf
                    @method('put')
                    <button class="btn btn-outline-danger mt-4" type="submit">Delete pic</button>
                </form>
                @endif

            </div>
        </div>
    </div>
</div>
</div>
@endsection
