<?php

namespace App\Http\Controllers;

use App\Models\Adhan;
use App\Models\City;
use App\Models\Country;
use App\Models\Gallery;
use App\Models\Jamat;
use App\Models\Mosque;
use App\Models\Notice;
use App\Models\Schedule;
use App\Models\Start;
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
        $validCountries = Mosque::all()->unique('country');

        return view('select-mosque')->with('mosques',$mosques)
            ->with('countries',$countries)
            ->with('validCountries',$validCountries);

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
    public function getValidMosque(Request $request)
    {
        $mosques = Mosque::where('country',$request->country)->get();


        if (count($mosques) > 0) {

            return response()->json($mosques);
        }

    }

    public function userSelectLocation(Request $request){
        $country_id = $request->country;
        $city_id = $request->city;

        $country = Country::find($country_id);
        $city = City::find($city_id);

        $lat = City::where('id',$city_id)->value('latitude');
        $long = City::where('id',$city_id)->value('longitude');


        $offset = $country->timezones;

        $offset = str_replace("[", "", $offset);
        $offset = str_replace("]", "", $offset);

        $offset = json_decode($offset, true);

        $timezoneOffset = $offset['gmtOffsetName'];
        $timezoneOffset = str_replace("UTC", "", $timezoneOffset);
        $timezoneOffset = str_replace(":", ".", $timezoneOffset);
        $timezoneOffset = str_replace("+", "", $timezoneOffset);
        $timezone = (float)$timezoneOffset;





        return view('userSelected-location-display')
            ->with('lat',$lat)
            ->with('long',$long)
            ->with('timezone',$timezone)
            ->with('country',$country)
            ->with('city',$city);



    }

    public function userSelectMosque(Request $request){
        $mosque_name = Mosque::where('id',$request->mosque_id)->value('name');
        $scheduleId = Schedule::where('mosque_id',$request->mosque_id)->value('id');
        $scheduleCount = Schedule::where('mosque_id',$request->mosque_id)->count();
        $schedule = Schedule::find($scheduleId);
        $notices = Notice::where('mosque_id',$request->mosque_id)->get();
        $noticesCount = Notice::where('mosque_id',$request->mosque_id)->count();
        $photos = Gallery::where('mosque_id',$request->mosque_id)->get();
        $photosCount = Gallery::where('mosque_id',$request->mosque_id)->count();

        $startId = Start::where('schedule_id',$scheduleId)->value('id');
        $adhanId = Adhan::where('schedule_id',$scheduleId)->value('id');
        $jamatId = Jamat::where('schedule_id',$scheduleId)->value('id');

        $startCount = Start::where('id',$startId)->count();
        $adhanCount = Adhan::where('id',$adhanId)->count();
        $jamatCount = Jamat::where('id',$jamatId)->count();

        $start = Start::find($startId);
        $adhan = Adhan::find($adhanId);
        $jamat = Jamat::find($jamatId);

        if($scheduleCount<1 || $noticesCount<1 || $photosCount<1)
        {
            return redirect()->back()->with('failed','Seleccted Mosques Resources are not Added Yet. Please Select Different Mosque');
        }

        return view('userSelected-mosque-display')->with('mosque_name',$mosque_name)
            ->with('schedule',$schedule)
            ->with('notices',$notices)
            ->with('photos',$photos)
            ->with('startCount',$startCount)
            ->with('adhanCount',$adhanCount)
            ->with('jamatCount',$jamatCount)
            ->with('start',$start)
            ->with('adhan',$adhan)
            ->with('jamat',$jamat);


    }
}
