<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\URL;


class FrontController extends Controller
{

    private $perPage = 10;

    public function index(Request $request)
    {

        if ($request->s) { // search part*********************************************************************************

            list($w1, $w2) = explode(' ', $request->s . ' ');

            $hotelsDir = [DB::table('hotels')
                ->join('countries', 'countries.id', '=', 'hotels.country_id')
                ->select('countries.*', 'hotels.id AS aid', 'hotels.hotel', 'hotels.price', 'hotels.period', 'hotels.country_id', 'hotels.photo') //isvardinti laukus kuriuos norim matyti
                ->where('countries.country', 'like', '%' . $w1 . '%') //ieskome country pavadinime
                ->where('hotels.hotel', 'like', '%' . $w2 . '%') //ieskome hotel pavadinime
                ->orWhere(fn ($query) => $query
                    ->where('countries.country', 'like', '%' . $w2 . '%')
                    ->where('hotels.hotel', 'like', '%' . $w1 . '%'))
                ->orWhere(fn ($query) => $query
                    ->where('hotels.hotel', 'like', '%' . $w2 . '%')
                    ->where('hotels.hotel', 'like', '%' . $w1 . '%'))
                ->orderBy('hotels.price', 'asc')
                ->get(), 'default'];
            $filter = 0;
        } else { // filter part-------------------------------------------------------------------------------
            if (!$request->country_id) {

                $allCount = DB::table('hotels')
                    ->select(DB::raw('count(hotels.id) AS allhotels, count(DISTINCT(hotels.hotel)) AS allNames'))
                    ->first()->allhotels;

                $page = $request->page ?? 1; // jeigu nieko nerandam tai atiduodam 1st page, nes 0 nera. 
                //sort part =====================================================================================
                $hotelsDir = match ($request->sort) {
                    // 'country-asc' => [DB::table('hotels')
                    //     ->join('countries', 'countries.id', '=', 'hotels.country_id')
                    //     ->select('countries.*', 'hotels.id AS aid', 'hotels.hotel', 'hotels.price', 'hotels.period', 'hotels.country_id', 'hotels.photo')
                    //     ->orderBy('countries.country', 'asc')
                    //     ->offset(($page - 1) * $this->perPage) // is page - 1 ir * kiek yra perpage. 
                    //     ->limit($this->perPage) // kiek rodys max = 10 
                    //     ->get(), 'country-asc'],
                    // 'country-desc' => [DB::table('hotels')
                    //     ->join('countries', 'countries.id', '=', 'hotels.country_id')
                    //     ->select('countries.*', 'hotels.id AS aid', 'hotels.hotel', 'hotels.price', 'hotels.period', 'hotels.country_id', 'hotels.photo')
                    //     ->orderBy('countries.country', 'desc')
                    //     ->offset(($page - 1) * $this->perPage)
                    //     ->limit($this->perPage)
                    //     ->get(), 'country-desc'],

                    'hotel-asc' => [DB::table('hotels') //'hotel-asc pavadinimas kuri naudojam view-box blade. 
                        ->join('countries', 'countries.id', '=', 'hotels.country_id')
                        ->select('countries.*', 'hotels.id AS aid', 'hotels.hotel', 'hotels.price', 'hotels.period', 'hotels.country_id', 'hotels.photo')
                        ->orderBy('hotels.price', 'asc') // pagal ka norim kad butu sort. 
                        ->orderBy('countries.country', 'asc') // antraeilis sort, jei norim 
                        ->offset(($page - 1) * $this->perPage)
                        ->limit($this->perPage)
                        ->get(), 'hotel-asc'],
                    'hotel-desc' => [DB::table('hotels')
                        ->join('countries', 'countries.id', '=', 'hotels.country_id')
                        ->select('countries.*', 'hotels.id AS aid', 'hotels.hotel', 'hotels.price', 'hotels.period', 'hotels.country_id', 'hotels.photo')
                        ->orderBy('hotels.price', 'desc')
                        ->orderBy('countries.country', 'asc')
                        ->offset(($page - 1) * $this->perPage)
                        ->limit($this->perPage)
                        ->get(), 'hotel-desc'],

                    default => [DB::table('hotels')
                        ->join('countries', 'countries.id', '=', 'hotels.country_id')
                        ->select('countries.*', 'hotels.id AS aid', 'hotels.hotel', 'hotels.price', 'hotels.period', 'hotels.country_id', 'hotels.photo')
                        ->offset(($page - 1) * $this->perPage)
                        ->limit($this->perPage)
                        ->get()->shuffle(), 'default']
                };
                $filter = 0;
            } else { // sort part
                $hotelsDir = match ($request->sort) {
                    // 'country-asc' => [DB::table('hotels')
                    //     ->join('countries', 'countries.id', '=', 'hotels.country_id')
                    //     ->select('countries.*', 'hotels.id AS aid', 'hotels.hotel', 'hotels.price', 'hotels.period', 'hotels.country_id', 'hotels.photo')
                    //     ->where('hotels.country_id', $request->country_id)
                    //     ->orderBy('countries.country', 'asc')
                    //     ->get(), 'country-asc'],
                    // 'country-desc' => [DB::table('hotels')
                    //     ->join('countries', 'countries.id', '=', 'hotels.country_id')
                    //     ->select('countries.*', 'hotels.id AS aid', 'hotels.hotel', 'hotels.price', 'hotels.period', 'hotels.country_id', 'hotels.photo')
                    //     ->where('hotels.country_id', $request->country_id)
                    //     ->orderBy('countries.country', 'desc')
                    //     ->get(), 'country-desc'],

                    'hotel-asc' => [DB::table('hotels')
                        ->join('countries', 'countries.id', '=', 'hotels.country_id')
                        ->select('countries.*', 'hotels.id AS aid', 'hotels.hotel', 'hotels.price', 'hotels.period', 'hotels.country_id', 'hotels.photo')
                        ->where('hotels.country_id', $request->country_id)
                        ->orderBy('hotels.price', 'asc')
                        ->orderBy('countries.country', 'asc')
                        ->get(), 'hotel-asc'],
                    'hotel-desc' => [DB::table('hotels')
                        ->join('countries', 'countries.id', '=', 'hotels.country_id')
                        ->select('countries.*', 'hotels.id AS aid', 'hotels.hotel', 'hotels.price', 'hotels.period', 'hotels.country_id', 'hotels.photo')
                        ->where('hotels.country_id', $request->country_id)
                        ->orderBy('hotels.price', 'desc')
                        ->orderBy('countries.country', 'asc')
                        ->get(), 'hotel-desc'],

                    default => [DB::table('hotels')
                        ->join('countries', 'countries.id', '=', 'hotels.country_id')
                        ->select('countries.*', 'hotels.id AS aid', 'hotels.hotel', 'hotels.price', 'hotels.period', 'hotels.country_id', 'hotels.photo')
                        ->where('hotels.country_id', $request->country_id)
                        ->get()->shuffle(), 'default']
                };
                $filter = (int) $request->country_id;
            }
        }

        //    dd($hotels);

        $query = $request->query();
        parse_str($query['query'] ?? '', $prevQuery);
        // $parsedUrl = parse_url(url()->full());
        // parse_str($parsedUrl['query'] ?? '', $prevQuery);

        return view('front.index', [
            'hotels' => $hotelsDir[0],
            'sort' => $hotelsDir[1],
            'countries' => Country::all(),
            'filter' => $filter,
            's' => $request->s ?? '',
            'allCount' => $allCount ?? 0, //kad nebutu error jei ne ten uzeinam
            'perPage' => $this->perPage ?? 0,
            'prevQuery' => $prevQuery,
            'pageNow' => $page ?? 0,
        ]);
    }
}
