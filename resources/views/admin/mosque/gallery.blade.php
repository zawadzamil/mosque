
@extends('admin.mosque.layout_from_here')
@section('body_parts')
    @php
        $photoCount = \App\Models\Gallery::where('mosque_id',$mosque_id)->count();
    @endphp
    <div class="row" style="margin-bottom: 40%; margin-top: 5%;">
        <h1 class="text-center text-4xl">Add Photo Gallery </h1>
        @if (\Session::has('Success'))
            <div class="alert alert-success">
                <ul>
                    <li style="color: #126604;text-align: center;">{!! \Session::get('Success') !!}</li>
                </ul>
            </div>
        @endif
        @if($photoCount>=10)


        <h1 class="text-center text-2xl mt-8 text-danger">Your Maximum limit(10) of Image Upload is Over. Please Delete Some or Contact System Administrator</h1>
            <h1 class="text-center text-2xl mt-4 text-info"><a href="{{url('show-gallery')}}">View Gallery>></a></h1>
        @else
        <x-auth-validation-errors class="mb-4 text-center mt-4" :errors="$errors" />
        <form class="form text-center mt-4 sm:mt-1" action="{{url('addToGallery')}} " method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-control">
                <p class="text-lg">You Can Choose {{10-$photoCount}} More Photos to Add on Gallery <span class="text-info">NB: Your image must have resolution above 1000*700</span></p>
                <input type="file" name="photo" class="lg:w-4/12 w-4/6 p-4 text-lg text-center mt-2  shadow-primary rounded-lg">
                <input type="hidden" name="mosque_id" value="{{$mosque_id}}">



            </div>
            <button class="btn bg-red-500 hover:bg-sky-700 text-light mt-4  btn-block" type="submit">Upload</button>
        </form>
            @endif


    </div>
    <script src="https://cdn.tailwindcss.com"></script>

@endsection

