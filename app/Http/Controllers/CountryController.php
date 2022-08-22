<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)

    {

        $countries = match ($request->sort) {
            'asc' => Country::orderBy('country', 'asc')->get(),
            'desc' => Country::orderBy('country', 'desc')->get(),
            default => Country::all()
        };
        return view('countries.index', ['countries' => $countries]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('countries.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $country = new Country;

        $country->country = $request->country_name;
        $country->street = $request->street;
        $country->number = $request->street_number;
        $country->city = $request->city;
        $country->zip = $request->zip_code;

        $country->save();
        return redirect()->route('countries-index')->with('success', 'New country succesfully added to the list');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function show(int $countryId)
    {
        $country = Country::where('id', $countryId)->first();
        return view('countries.show', ['country' => $country]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function edit(Country $country)
    {
        return view('countries.edit', ['country' => $country]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Request  $request
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Country $country)
    {
        $country->country = $request->country_name;
        $country->street = $request->street;
        $country->number = $request->street_number;
        $country->city = $request->city;
        $country->zip = $request->zip_code;

        $country->save();
        return redirect()->route('countries-index')->with('success', 'Info updated');
    }

    //?? msg kuri praso uzpildyti title stulpeli, nes jeigu bus tuscias gausim error
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function destroy(Country $country)
    {
        if (!$country->countryHasManyHotels->count()) {

            $country->delete();
            return redirect()->route('countries-index')->with('deleted', 'Country gone');
        }

        return redirect()->back()->with('deleted', 'not possible to delete, there is a hotel there');
    }
    public function link()
    {
        abort(403);
    }
}
