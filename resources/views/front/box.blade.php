<div class="card mb-4">
    <div class="card-header">
        <h1>Sort Filter Search</h1>
    </div>
    <div class="card-body">
        <form class="delete" action="{{route('front-index')}}" method="get">
            <div class="container">
                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <label>What sort?</label>
                            <select class="form-control" name="sort">
                                <option value="dafault" @if($sort=='default' )selected @endif>Default sort</option>
                                {{-- <option value="country-asc" @if($sort=='country-asc' )selected @endif>country A-Z</option>
                                <option value="country-desc" @if($sort=='country-desc' )selected @endif>country Z-A</option> --}}
                                <option value="hotel-asc" @if($sort=='hotel-asc' )selected @endif>price fm lowest</option>
                                <option value="hotel-desc" @if($sort=='hotel-desc' )selected @endif>price fm highest</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label>What country?</label>
                            <select class="form-control" name="country_id">
                                <option value="0" @if($filter==0) selected @endif>No filter</option>
                                @foreach($countries as $country)
                                <option value="{{$country->id}}" @if($filter==$country->id) selected @endif>{{$country->country}}</option>

                                @endforeach
                            </select>
                        </div>

                    </div>

                    <div class="col-6">
                        <button class="btn btn-outline-warning m-2 mt-4" type="submit">Sort</button>
                        <a class="btn btn-outline-primary m-2 mt-4" href="{{route('front-index')}}">Clear</a>
                    </div>
                </div>
            </div>
        </form>
        <form class="delete" action="{{route('front-index')}}" method="get">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group mt-4">
                            <label>Search</label>
                            <input class="form-control" type="text" name="s" value="{{$s}}" />
                        </div>
                        <button class="btn btn-outline-success mt-2" type="submit">Search</button>
                    </div>
                </div>
            </div>
        </form>


    </div>
</div>
