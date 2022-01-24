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

class MosqueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countries = Country::all();
        if (\Auth::user()->type == 'admin')
        {
            return view('admin.mosque.add')->with('countries',$countries);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required','max:500','string'],
            'country' => ['required'],
            'city' => ['required'],

        ]);

        $mosque = Mosque::create([
            'name' =>$request->name,
            'country' =>$request->country,
            'city' =>$request->city,
            'area' =>$request->city,
            'admin_id' =>\Auth::user()->id,
        ]);
        $mosque->save();
        $mosques = Mosque::where('admin_id',\Auth::user()->id)->get();
        return redirect()->route('show-mosques')->with('Success','Your Mosque is Added Successfully!')
            ->with('mosques',$mosques);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mosque  $mosque
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $mosqueCount = Mosque::where('admin_id',\Auth::user()->id)->count();
        if($mosqueCount==0)
        {
            $countries = Country::all();
            return view('admin.mosque.add')->with('failed','Please add a mosque first')
                ->with('countries',$countries);
        }
        else{
            $mosqueId = Mosque::where('admin_id',\Auth::user()->id)->value('id');
            $mosque = Mosque::find($mosqueId);

            return view('admin.mosque.show')->with('mosque',$mosque);


        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mosque  $mosque
     * @return \Illuminate\Http\Response
     */
    public function edit(Mosque $mosque)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mosque  $mosque
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mosque $mosque)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mosque  $mosque
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mosque $mosque)
    {
        //
    }

    public function display()
    {
        $mosqueId = Mosque::where('admin_id',\Auth::user()->id)->value('id');
        $mosqueName = Mosque::where('admin_id',\Auth::user()->id)->value('name');
        $scheduleId = Schedule::where('mosque_id',$mosqueId)->value('id');

        $startId = Start::where('schedule_id',$scheduleId)->value('id');
        $adhanId = Adhan::where('schedule_id',$scheduleId)->value('id');
        $jamatId = Jamat::where('schedule_id',$scheduleId)->value('id');

        $startCount = Start::where('id',$startId)->count();
        $adhanCount = Adhan::where('id',$adhanId)->count();
        $jamatCount = Jamat::where('id',$jamatId)->count();

        $start = Start::find($startId);
        $adhan = Adhan::find($adhanId);
        $jamat = Jamat::find($jamatId);

        $schedule = Schedule::find($scheduleId);
        $notices = Notice::where('mosque_id',$mosqueId)->get();
        $photos = Gallery::where('mosque_id',$mosqueId)->get();

        return view('display')
            ->with('schedule',$schedule)
            ->with('notices',$notices)
            ->with('photos',$photos)
            ->with('mosque_name',$mosqueName)
            ->with('startCount',$startCount)
            ->with('adhanCount',$adhanCount)
            ->with('jamatCount',$jamatCount)
            ->with('start',$start)
            ->with('adhan',$adhan)
            ->with('jamat',$jamat);
    }
    public function back(){
        return redirect('/');
    }


}
