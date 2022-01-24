<?php

namespace App\Http\Controllers;

use App\Models\Adhan;
use App\Models\City;
use App\Models\Country;
use App\Models\Jamat;
use App\Models\Mosque;
use App\Models\Schedule;
use App\Models\Start;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $cityId = Mosque::where('id',$id)->value('city');
        $country_id = Mosque::where('id',$id)->value('country');
        $lat = City::where('id',$cityId)->value('latitude');
        $long = City::where('id',$cityId)->value('longitude');

        $country = Country::find($country_id);

        $offset = $country->timezones;

        $offset = str_replace("[", "", $offset);
        $offset = str_replace("]", "", $offset);

        $offset = json_decode($offset, true);

        $timezoneOffset = $offset['gmtOffsetName'];
        $timezoneOffset = str_replace("UTC", "", $timezoneOffset);
        $timezoneOffset = str_replace(":", ".", $timezoneOffset);
        $timezoneOffset = str_replace("+", "", $timezoneOffset);
        $timezone = (float)$timezoneOffset;


        return view('admin.mosque.schedule')->with('mosque_id',$id)
            ->with('lat',$lat)
            ->with('long',$long)
            ->with('timezone',$timezone);

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
        $start_selected = false;
        $adhan_selected = false;
        $jamat_selected = false;


// Validate All Start times if start is selected
        if($request->has('start'))
        {
            $request->validate([
                'fazar_start' => ['required'],
                'dhuhr_start' => ['required'],
                'asr_start' => ['required'],
                'maghrib_start' => ['required'],
                'isha_start' => ['required'],
                'jummah_start' => ['required'],
                'addedTimeStart' =>['required','min:0','max:100']

            ]);
            $start_selected = true;

        }

        // Validate All Adhan times if Adhan is selected
        if($request->has('adhan'))
        {
            $request->validate([
                'faraz_adhan' => ['required'],
                'dhuhr_adhan' => ['required'],
                'asr_adhan' => ['required'],
                'maghrib_adhan' => ['required'],
                'isha_adhan' => ['required'],
                'jummah_adhan' => ['required'],
                'addedTimeAdhan' =>['required','min:0','max:100']

            ]);
            $adhan_selected  = true;

        }

        // Validate All Jamat times if Jamat is selected
        if($request->has('jamat'))
        {
            $request->validate([
                'faraz_jamat' => ['required'],
                'dhuhr_jamat' => ['required'],
                'asr_jamat' => ['required'],
                'maghrib_jamat' => ['required'],
                'isha_jamat' => ['required'],
                'jummah_jamat' => ['required'],
                'addedTimeJamat' =>['required','min:0','max:100']

            ]);
            $jamat_selected  = true;

        }




        $schedule = Schedule::create([


            'mosque_id'=>$request->mosque_id,
            'start' =>$start_selected,
            'adhan'=>$adhan_selected,
            'jamat'=>$jamat_selected,
        ]);
        $schedule->save();

        if($request->has('start'))
        {
            $start = Start::create([
                'schedule_id' =>$schedule->id,
                'fazar' =>$request->fazar_start,
                'dhuhr' =>$request->dhuhr_start,
                'asr' =>$request->asr_start,
                'maghrib' =>date( "h:i A", strtotime($request->maghrib_start)+(60*$request->addedTimeStart) ),
                'isha' =>$request->isha_start,
                'jummah' =>$request->jummah_start,
            ]);
            $start->save();
        }

        if($request->has('adhan'))
        {
            $adhan = Adhan::create([
                'schedule_id' =>$schedule->id,
                'fazar' =>$request->faraz_adhan,
                'dhuhr' =>$request->dhuhr_adhan,
                'asr' =>$request->asr_adhan,
                'maghrib' =>date( "h:i A", strtotime($request->maghrib_adhan)+(60*$request->addedTimeAdhan) ),
                'isha' =>$request->isha_adhan,
                'jummah' =>$request->jummah_adhan,
            ]);
            $adhan->save();
        }


        if($request->has('jamat'))
        {
            $jamat = Jamat::create([
                'schedule_id' =>$schedule->id,
                'fazar' =>$request->fazar_jamat,
                'dhuhr' =>$request->dhuhr_jamat,
                'asr' =>$request->asr_jamat,
                'maghrib' =>date( "h:i A", strtotime($request->maghrib_jamat)+(60*$request->addedTimeJamat) ),
                'isha' =>$request->isha_jamat,
                'jummah' =>$request->jummah_jamat,
            ]);
            $jamat->save();
        }
        return redirect()->route('show-schedule')->with('Success','Schedule is added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $mosqueId = Mosque::where('admin_id',\Auth::user()->id)->value('id');
        $scheduleId = Schedule::where('mosque_id',$mosqueId)->value('id');

        $startId = Start::where('schedule_id',$scheduleId)->value('id');
        $adhanId = Adhan::where('schedule_id',$scheduleId)->value('id');
        $jamatId = Jamat::where('schedule_id',$scheduleId)->value('id');

        $startCount = Start::where('id',$startId)->count();
        $adhanCount = Adhan::where('id',$adhanId)->count();
        $jamatCount = Jamat::where('id',$jamatId)->count();
        $scheduleCount = Schedule::where('mosque_id',$mosqueId)->count();

        $start = Start::find($startId);
        $adhan = Adhan::find($adhanId);
        $jamat = Jamat::find($jamatId);
        $schedule = Schedule::find($scheduleId);



        return  view('admin.mosque.show-schedule')->with('schedule',$schedule)
            ->with('count',$scheduleCount)
            ->with('startCount',$startCount)
            ->with('adhanCount',$adhanCount)
            ->with('jamatCount',$jamatCount)
            ->with('start',$start)
            ->with('adhan',$adhan)
            ->with('jamat',$jamat);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $mosqueId = Mosque::where('admin_id',\Auth::user()->id)->value('id');
        $scheduleId = Schedule::where('mosque_id',$mosqueId)->value('id');
        $scheduleCount = Schedule::where('mosque_id',$mosqueId)->count();
        $schedule = Schedule::find($scheduleId);

        $startId = Start::where('schedule_id',$scheduleId)->value('id');
        $start = Start::find($startId);
        $startCount = Start::where('id',$startId)->count();

        $adhanId = Adhan::where('schedule_id',$scheduleId)->value('id');
        $adhan = Adhan::find($adhanId);
        $adhanCount = Adhan::where('id',$adhanId)->count();

        $jamatId = Jamat::where('schedule_id',$scheduleId)->value('id');
        $jamat = Jamat::find($jamatId);
        $jamatCount = Jamat::where('id',$jamatId)->count();

        $cityId = Mosque::where('id',$mosqueId)->value('city');
        $lat = City::where('id',$cityId)->value('latitude');
        $long = City::where('id',$cityId)->value('longitude');

       $countryId = Mosque::where('id',$mosqueId)->value('country');
       $country = Country::find($countryId);
       $offset = $country->timezones;

        $offset = str_replace("[", "", $offset);
        $offset = str_replace("]", "", $offset);

        $offset = json_decode($offset, true);

        $timezoneOffset = $offset['gmtOffsetName'];
        $timezoneOffset = str_replace("UTC", "", $timezoneOffset);
        $timezoneOffset = str_replace(":", ".", $timezoneOffset);
        $timezoneOffset = str_replace("+", "", $timezoneOffset);
        $timezone = (float)$timezoneOffset;






        return view('admin.mosque.edit-schedule')->with('schedule',$schedule)
            ->with('mosque_id',$mosqueId)
            ->with('schedule_id',$scheduleId)
            ->with('start',$start)
            ->with('adhan',$adhan)
            ->with('jamat',$jamat)
            ->with('startCount',$startCount)
            ->with('adhanCount',$adhanCount)
            ->with('jamatCount',$jamatCount)
            ->with('lat',$lat)
            ->with('long',$long)
            ->with('timezone',$timezone)
            ;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

       $startId = Start::where('schedule_id',$id)->value('id');
       $adhanId = Adhan::where('schedule_id',$id)->value('id');
       $jamatId = Jamat::where('schedule_id',$id)->value('id');

       $starCount = Start::where('id',$startId)->count();
       $adhanCount = Adhan::where('id',$adhanId)->count();
       $jamatCount = Jamat::where('id',$jamatId)->count();


       $start = Start::find($startId);
       $adhan = Adhan::find($adhanId);
       $jamat = Jamat::find($jamatId);

        // Validate All Start times if start is selected
        if($request->has('start'))
        {
            $request->validate([
                'fazar_start' => ['required'],
                'dhuhr_start' => ['required'],
                'asr_start' => ['required'],
                'maghrib_start' => ['required'],
                'isha_start' => ['required'],
                'jummah_start' => ['required'],
                'addedTimeStart' => ['required','min:0','max:100'],

            ]);
            if($starCount >0)
            {
                $start->fazar = $request->input('fazar_start');
                $start->dhuhr = $request->input('dhuhr_start');
                $start->asr = $request->input('asr_start');
                $start->maghrib = date( "h:i A", strtotime($request->input('maghrib_start'))+(60*$request->input('addedTimeStart')) );
                $start->isha = $request->input('isha_start');
                $start->jummah = $request->input('jummah_start');

                $start->update();

            }
          else{

              $start = Start::create([
                  'schedule_id' =>$id,
                  'fazar' =>$request->fazar_start,
                  'dhuhr' =>$request->dhuhr_start,
                  'asr' =>$request->asr_start,
                  'maghrib' =>date( "h:i A", strtotime($request->maghrib_start)+(60*$request->addedTimeStart) ),
                  'isha' =>$request->isha_start,
                  'jummah' =>$request->jummah_start,
              ]);
              $start->save();

          }


        }

        // Validate All Adhan times if Adhan is selected
        if($request->has('adhan'))
        {
            $request->validate([
                'faraz_adhan' => ['required'],
                'dhuhr_adhan' => ['required'],
                'asr_adhan' => ['required'],
                'maghrib_adhan' => ['required'],
                'isha_adhan' => ['required'],
                'jummah_adhan' => ['required'],
                'addedTimeAdhan' => ['required','min:0','max:100'],

            ]);
            if ($adhanCount>0)
            {
                $adhan->fazar = $request->input('faraz_adhan');
                $adhan->dhuhr = $request->input('dhuhr_adhan');
                $adhan->asr = $request->input('asr_adhan');
                $adhan->maghrib = date( "h:i A", strtotime($request->input('maghrib_adhan'))+(60*$request->input('addedTimeAdhan')) );
                $adhan->isha = $request->input('isha_adhan');
                $adhan->jummah = $request->input('jummah_adhan');

                $adhan->update();
            }

            else{
                $adhan = Adhan::create([
                    'schedule_id' =>$id,
                    'fazar' =>$request->fazar_start,
                    'dhuhr' =>$request->dhuhr_start,
                    'asr' =>$request->asr_start,
                    'maghrib' =>date( "h:i A", strtotime($request->maghrib_adhan)+(60*$request->addedTimeAdhan) ),
                    'isha' =>$request->isha_start,
                    'jummah' =>$request->jummah_start,
                ]);
                $adhan->save();

            }



        }

        // Validate All Jamat times if Jamat is selected
        if($request->has('jamat'))
        {
            $request->validate([
                'faraz_jamat' => ['required'],
                'dhuhr_jamat' => ['required'],
                'asr_jamat' => ['required'],
                'maghrib_jamat' => ['required'],
                'isha_jamat' => ['required'],
                'jummah_jamat' => ['required'],
                'addedTimeJamat' => ['required','min:0','max:100'],

            ]);
            if($jamatCount>0)
            {
                $jamat->fazar = $request->input('faraz_jamat');
                $jamat->dhuhr = $request->input('dhuhr_jamat');
                $jamat->asr = $request->input('asr_jamat');
                $jamat->maghrib = date( "h:i A", strtotime($request->input('maghrib_jamat'))+(60*$request->input('addedTimeJamat')) );
                $jamat->isha = $request->input('isha_jamat');
                $jamat->jummah = $request->input('jummah_jamat');

                $jamat->update();
            }
          else{

              $jamat = Jamat::create([
                  'schedule_id' =>$id,
                  'fazar' =>$request->fazar_start,
                  'dhuhr' =>$request->dhuhr_start,
                  'asr' =>$request->asr_start,
                  'maghrib' =>date( "h:i A", strtotime($request->maghrib_jamat)+(60*$request->addedTimeJamat) ),
                  'isha' =>$request->isha_start,
                  'jummah' =>$request->jummah_start,
              ]);
              $jamat->save();

          }


        }


        return redirect()->route('show-schedule')->with('Success','Schedule Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(Schedule $schedule)
    {
        //
    }
}
