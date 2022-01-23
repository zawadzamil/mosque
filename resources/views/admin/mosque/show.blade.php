
@extends('admin.layout')
@section('body_parts')
    @php
    function getCountrynameById($id)
    {
        $countryName = \App\Models\Country::where('id',$id)->value('name');
        return $countryName;
    }

    function getCitynameById($id)
    {
        $cityNmae = \App\Models\City::where('id',$id)->value('name');
        return $cityNmae;
    }
    @endphp
    <div class="row" style="margin-bottom: 40%; margin-top: 5%;">
        <h1 class="text-center text-4xl">Name of  Mosques</h1>
        @if (\Session::has('Success'))
            <div class="alert alert-success">
                <ul>
                    <li style="color: #126604;text-align: center;">{!! \Session::get('Success') !!}</li>
                </ul>
            </div>
        @endif
        <div class=" w-11/12 text-center mt-4 items-center ml-4">
            <div class="container">
                <h1>Details</h1>
                <div class="row mt-4 ">
                    <div class="col-md-3"></div>
                    <div class="col-md-6 shadow-xl rounded-lg ">
                        <ul class="p-4  text-2xl   font-['Bahnschrift_Light']">
                            <li class="">Name: <span class="font-bold">{{$mosque->name}}</span> </li>
                            <li >Country: <span class="uppercase font-bold">{{getCountrynameById($mosque->country)}}</span> </li>
                            <li >City: <span class="uppercase font-bold">{{getCitynameById($mosque->city)}}</span> </li>


                            <li>Added by: {{Auth::user()->name}}</li>
                            <li>Created at:{{$mosque->created_at}}</li>

                        </ul>
                        <a href="{{url('add-notice',$mosque->id)}}"><button class="btn btn-github inline"> Add Notice</button></a>
                        <a href="{{url('add-schedule',$mosque->id)}}"><button class="btn btn-github inline"> Add Schedule</button></a>
                        <a href="{{url('add-gallery',$mosque->id)}}"><button class="btn btn-github inline"> Add Gallery</button></a>
                    </div>
                    <div class="col-md-3"></div>


                </div>
            </div>

        </div>


</div>
    <script src="https://cdn.tailwindcss.com"></script>

@endsection

