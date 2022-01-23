<?php

namespace App\Http\Controllers;

use App\Models\Mosque;
use App\Models\Notice;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        return  view('admin.mosque.notice')->with('mosque_id',$id);
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
            'notice' =>['required','max:1000'],
        ]);
        $notice  = Notice::create([
            'notice' =>$request->notice,
            'mosque_id' =>$request->mosque_id,
        ]);
        $notice->save();
        return redirect()->route('show-notice')->with('Success','Notice Added!');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $mosqueId = Mosque::where('admin_id',\Auth::user()->id)->value('id');
        $notices = Notice::where('mosque_id',$mosqueId)->get();
        $noticeCount = Notice::where('mosque_id',$mosqueId)->count();

        return view('admin.mosque.show-notice')->with('notices',$notices)
            ->with('noticeCount',$noticeCount)
            ->with('mosque_id',$mosqueId);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $notice = Notice::find($id);
        $mosueId = $notice->mosque_id;
        return view('admin.mosque.edit-notice')->with('notice',$notice)
            ->with('mosque_id',$mosueId);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $notice = Notice::find($id);
        $notice->notice = $request->input('notice');
        $notice->update();
        return redirect()->route('show-notice')->with('Success','Notice Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Notice::find($id)->delete();
        return redirect()->back()->with('failed','Notice Has been Removed!');
    }
}
