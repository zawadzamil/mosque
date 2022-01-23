<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Mosque;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
       return view('admin.mosque.gallery')->with('mosque_id',$id);
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
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:min_width=1000,min_height=700',
        ]);

        $imageName = time().rand(). '.'.$request->photo->extension();

        $request->photo->move(public_path('/images'), $imageName);


        $gallery = Gallery::create([
            'photo'=>$imageName,
            'mosque_id' =>$request->mosque_id,
        ]);
        $gallery->save();
        return redirect()->route('show-gallery')->with('Success','Photo Uploaded to the Gallery. You can Upload More ...');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $mosqueId = Mosque::where('admin_id',\Auth::user()->id)->value('id');
        $photos = Gallery::where('mosque_id',$mosqueId)->get();
        $photosCount =Gallery::where('mosque_id',$mosqueId)->count();
        return view('admin.mosque.show-gallery')
            ->with('photos',$photos)
            ->with('mosque_id',$mosqueId)
            ->with('photosCount',$photosCount);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function edit(Gallery $gallery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Gallery $gallery)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Gallery::find($id)->delete();
        return redirect()->back()->with('failed','Photo Removed From Gallery');
    }
}
