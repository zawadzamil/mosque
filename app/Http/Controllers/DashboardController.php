<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use App\Models\Mosque;
use Illuminate\Http\Request;
use Stevebauman\Location\Facades\Location;

class DashboardController extends Controller
{
    public function home()
    {



        return view('dashboardHandeler');
    }
    public function select()
    {
        $mosques = Mosque::all();
        $countries = Country::all();
        return view('select-mosque')->with('mosques',$mosques)
            ->with('countries',$countries);

    }

    public function getCities(Request $request)
    {
        $cities = City::where('country_id', $request->country_id)
            ->get();


        if (count($cities) > 0) {

            return response()->json($cities);
        }

    }
    public function getMosque(Request $request)
    {
        $mosques = Mosque::where('city',$request->city)->get();


        if (count($mosques) > 0) {

            return response()->json($mosques);
        }

    }
}
