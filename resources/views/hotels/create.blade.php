@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h1>hotel Create</h1>
                </div>
                <div class="card-body">
                    <form action="{{route('hotels-store')}}" method="post" enctype="multipart/form-data">

                        <div class="form-group">
                            <label>hotel name</label>
                            <input class="form-control" type="text" name="hotel" />
                        </div>
                        <div class="form-group">
                            <label>Price</label>
                            <input class="form-control" type="text" name="price" />
                        </div>
                        <div class="form-group">
                            <label>Period</label>
                            <select class="form-control" type="text" name="period">

                                <option>-select-</option>
                                <option>January</option>
                                <option>February</option>
                                <option>March</option>
                                <option>April</option>
                                <option>May</option>
                                <option>June</option>
                                <option>JUly</option>
                            </select>
                            {{-- <input class="form-control" type="text" name="period" /> --}}
                        </div>
                        <div class="form-group">
                            <label>Where?</label>
                            <select class="form-control" name="country_id">
                                @foreach($countries as $country)
                                <option value="{{$country->id}}">{{$country->country}}</option>
                                @endforeach
                            </select>
                            <div class="m-2">
                                <a class="magic--link" href="">
                                    see 
                                </a>

                            </div>
                        </div>
                        <div class="form-group">
                            <label>Image</label>
                            <input class="form-control" type="file" name="photo" />
                        </div>

                        @csrf
                        @method('post')
                        <button class="btn btn-outline-success mt-4" type="submit">I found hotel!</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
