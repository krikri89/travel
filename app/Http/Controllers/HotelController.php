<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $hotels = Hotel::all();

        // $countries = Country::all()->sortByDesc('title');
        // $countries = Country::where('id', '<', 100)->orderBy('title')->get();

        $hotels = match ($request->sort) {
            'asc' => Hotel::orderBy('hotel', 'asc')->get(),
            'desc' => Hotel::orderBy('hotel', 'desc')->get(),
            default => Hotel::all()
        };
        return view('hotels.index', ['hotels' => $hotels]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::all();

        return view('hotels.create', ['countries' => $countries]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'hotel' => ['required', 'min:3', 'max:64'],
                'price' => ['required', 'integer', 'min:100'],
                // 'create_color_input' => ['required', 'regex:/^\#([0-9A-f]){6}$/i'],
            ],
            [
                'hotel.min' => 'Too short name',
                'hotel.required' => 'Come onnn..., need to fill it',
                'price.integer' => 'cash please'
            ]
        );
        if ($validator->fails()) {
            $request->flash();
            return redirect()->back()->withErrors($validator);
        }

        $hotel = new Hotel;
        if ($request->file('photo')) { // jeigu file yra

            $photo = $request->file('photo');
            $extension = $photo->getClientOriginalExtension(); // kadangi gaunam object, pasiimam extension, tan kad galetume padaryti linka
            $name = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME); //originalus vardas w/o extension. kad eitu prideti extension kuriant nauja varda
            $file = $name . '-' . rand(100000, 999999) . '.' . $extension; // generuojam file varda. Del saugumo ji pervadiname. orgin name + bruksnys + rand number + taskas + origin extend
            $photo->move(public_path() . '/images', $file); // kur norim ideti sia photo. su pavadinimu kuri sukuriam su $file
            $hotel->photo = asset('/images') . '/' . $file; // i DB photo dali lenteleje

        }

        $hotel->hotel = $request->hotel;
        $hotel->price = $request->price;
        $hotel->period = $request->period;

        $hotel->country_id = $request->country_id;

        $hotel->save();

        return redirect()->route('hotels-index')->with('success', 'Well done!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function show(int $hotelId)
    {
        $hotel = Hotel::where('id', $hotelId)->first();

        return view('hotels.show', ['hotel' => $hotel]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function edit(Hotel $hotel)
    {

        $countries = Country::all();

        return view('hotels.edit', [
            'hotel' => $hotel,
            'countries' => $countries
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Hotel $hotel)
    {
        if ($request->file('photo')) { // jeigu file yra

            // istrinam is DB
            $name = pathinfo($hotel->photo, PATHINFO_FILENAME);
            $extension = pathinfo($hotel->photo, PATHINFO_EXTENSION);
            $path = asset('/images') . '/' . $name . '.' . $extension;

            if (file_exists($path)) {
                unlink($path);
            }
            // idedam nauja

            $photo = $request->file('photo');
            $extension = $photo->getClientOriginalExtension(); // kadangi gaunam object, pasiimam extension, tan kad galetume padaryti linka
            $name = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME); //originalus vardas w/o extension. kad eitu prideti extension kuriant nauja varda
            $file = $name . '-' . rand(100000, 999999) . '.' . $extension; // generuojam file varda. Del saugumo ji pervadiname. orgin name + bruksnys + rand number + taskas + origin extend
            $photo->move(public_path() . '/images', $file); // kur norim ideti sia photo. su pavadinimu kuri sukuriam su $file
            $hotel->photo = asset('/images') . '/' . $file; // i DB photo dali lenteleje

        }
        $hotel->hotel = $request->hotel;
        $hotel->price = $request->price;
        $hotel->period = $request->period;

        $hotel->country_id = $request->country_id;

        $hotel->save();

        return redirect()->route('hotels-index')->with('success', 'You are the best!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hotel $hotel)
    {
        // istrinam is DB
        if ($hotel->photo) {
            $name = pathinfo($hotel->photo, PATHINFO_FILENAME);
            $extension = pathinfo($hotel->photo, PATHINFO_EXTENSION);
            $path = asset('/images') . '/' . $name . '.' . $extension;

            if (file_exists($path)) {
                unlink($path);
            }
        }
        $hotel->delete();

        return redirect()->route('hotels-index')->with('deleted', 'hotel is dead :(');
    }
    public function deletePic(Hotel $hotel)
    {
        // istrinam is DB
        $name = pathinfo($hotel->photo, PATHINFO_FILENAME);
        $extension = pathinfo($hotel->photo, PATHINFO_EXTENSION);
        $path = asset('/images') . '/' . $name . '.' . $extension;

        if (file_exists($path)) {
            unlink($path);
        }
        //istrinam is musu filo
        $hotel->photo = null; // pic padarom null
        $hotel->save();


        return redirect()->back()->with('deleted', 'No more pics');
    }
}
