
@extends('admin.layout')
@section('body_parts')
    @php
    $photoCount = \App\Models\Gallery::where('mosque_id',$mosque_id)->count();
    @endphp
    <div class="row" style="margin-bottom: 40%; margin-top: 5%;">
        <h1 class="text-center text-4xl ">Gallery</h1>
        <a href="{{url('add-gallery',$mosque_id)}}"><p class="text-lg  text-info">Add New>></p> </a>
    @if (\Session::has('Success'))
            <div class="alert alert-success">
                <ul>
                    <li style="color: #126604;text-align: center;">{!! \Session::get('Success') !!}</li>
                </ul>
            </div>
        @endif
        @if (\Session::has('failed'))
            <div class="alert alert-danger">
                <ul>
                    <li style="color: #580a05;text-align: center;">{!! \Session::get('failed') !!}</li>
                </ul>
            </div>
        @endif


        <div class="container text-center sm:mt-2 lg:mt-4 text-lg  w-11/12">

           <h1 class="text-xl">All Photos </h1>
            @if($photoCount == 0)
                <h1 class="text-xl mt-4">Sorry! No Photo Uploaded Yet. <span class="text-info hover:text-danger"><a href="{{url('add-gallery',$mosque_id)}}">Upload Now?</a></span> </h1>
            @endif
            <div class="container text-center w-11/12 mt-4">
                <div class="row ml-4  d-flex justify-content-center">
                    @foreach($photos as $photo)
                    <div class="col-md-3 w-2/2 h-32 mb-6 ml-2 ">
                        <img src="public/images/{{$photo->photo}}" class="shadow-primary" alt="" style=" width: 100%; margin: 0px;
        max-height: 100%;
        display: block;"> <a href="{{url('removePhoto',$photo->id)}}"><i class="fa fa-trash "></i></a>
                    </div>
                    @endforeach


                </div>
            </div>


        </div>

    </div>
    <script src="https://cdn.tailwindcss.com"></script>

@endsection

