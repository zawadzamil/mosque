<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="public/display/css/show.css" type="text/css">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>PTD-Prayer Time Display</title>
</head>
<body style="background-image: url('public/display/assets/images/bg1.jpg');background-repeat: no-repeat; -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;">

<div class="container  mt-16">
    @if (\Session::has('failed'))
        <div class="alert alert-danger">
            <ul>
                <li style="color: #66100a;text-align: center;">{!! \Session::get('failed') !!}</li>
            </ul>
        </div>
    @endif
    <div class="row text-center relative justify-content-center inline flex">
        <h1 class="text-3xl font-bold text-light">Select  Location or Mosque</h1>
{{--        Checker--}}
        <div class="selector mt-4 bg-dark w-full h-full flex justify-content-center text-center" >
            <label class="text-white text-2xl lg:px-12 sm:px-2 p-4 inline" for="startCheck">Schedule By Location
                <input type="checkbox" class="text-purple-600 form-checkbox h-4 w-4  rounded-xl " name ="locatoin"  id="locationCheck">
            </label>


            <label class="text-white text-2xl lg:px-12 sm:px-2 p-4 inline" for="startCheck">Schedule By Mosques
                <input type="checkbox" class="text-purple-600 form-checkbox h-4 w-4  rounded-xl " name ="mosque"  id="mosqueCheck">
            </label>


        </div>


{{--                    Select By Location Div--}}
        <div id="location" class="col-lg-6 col-sm-4 text-xl text-light text-center   " style="display: none">
            <form class="form-control text-center  mt-4 sm:mt-1" action="{{url('user-select-location')}} " method="POST">
                @csrf


                <div class="form-group ">


                    {{--                Input Country--}}
                    <div class="dropdown " style="display: inline">
                        <select name="country" id="country" class="p-3 mt-4 w-15 sm:w-2/4  shadow-xl rounded-lg" required >
                            <option  value="" selected disabled>Choose Your Country</option>
                            @foreach($countries as $country)

                                <option value="{{$country->id}}">{{$country->name}}</option>

                            @endforeach


                        </select>

                    </div>
                    {{--              End  Input Country--}}




                    {{--                Input City--}}
                    <div class="dropdown " style="display: inline">
                        <select name="city" id="city" class="p-3 mt-4 w-25 ml-2  shadow-xl rounded-lg " required >





                        </select>

                    </div>


{{--                    Input Mosques--}}






                </div>
                <button class="btn bg-red-500 hover:bg-sky-700 text-light mt-4  btn-block" type="submit">Submit</button>

            </form>


        </div>

{{--                        Selecet by Mosque Div--}}
        <div id="mosqueDiv" class="col-lg-6 col-sm-4 text-xl text-light text-center   " style="display: none">
            <form class="form-control text-center  mt-4 sm:mt-1" action="{{url('user-select-mosque')}} " method="POST">
                @csrf


                <div class="form-group ">


                    {{--                Input Country--}}
                    <div class="dropdown ">
                        <select name="country" id="countryS" class="p-3 mt-4 w-15 sm:w-2/4  shadow-xl rounded-lg" required >
                            <option  value="" selected disabled>Choose Your Country</option>
                            @foreach($validCountries as $vc)

                                <option value="{{$vc->country}}">{{\App\Models\Country::where('id',$vc->country)->value('name')}}</option>

                            @endforeach


                        </select>

                    </div>

                    <div class="dropdown " >
                        <select name="mosque_id" id="mosque" class="p-3  mt-4 lg:w-full sm:w-2/4  shadow-xl rounded-lg" required >
                            <option  value="" selected disabled>Choose Your Mosque</option>
                            @foreach($validCountries as $vc)
                                <option value="{{$vc->id}}">{{$vc->name}}</option>

                            @endforeach

                        </select>

                    </div>
                    {{--              End  Input Country--}}











                </div>
                <button class="btn bg-red-500 hover:bg-sky-700 text-light mt-4  btn-block" type="submit">Submit</button>

            </form>


        </div>






    </div>
</div>


<script >
    const locationCheck = document.getElementById('locationCheck');
    const mosqueCheck = document.getElementById('mosqueCheck');
    const locationDiv = document.getElementById('location');
    const mosqueDiv = document.getElementById('mosqueDiv');

    locationCheck.addEventListener('change',function (event) {
    if(event.currentTarget.checked){
        console.log('Checked Location!')
        mosqueCheck.checked = false
        locationDiv.style.display = 'block'
        mosqueDiv.style.display = 'none'

    }
    });
    mosqueCheck.addEventListener('change',function (event) {
        if(event.currentTarget.checked){
            console.log('Checked Mosque!')
            locationCheck.checked = false
            locationDiv.style.display = 'none'
            mosqueDiv.style.display = 'block'

        }
    });
</script>




{{--Tailwind--}}

<script src="https://cdn.tailwindcss.com"></script>

{{--    <script src="{{asset('public/js/country.js')}}"></script>--}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#country').on('change', function () {
            var countryId = this.value;

            $('#city').html('');
            $.ajax({
                url: '{{ route('getCities') }}?country_id='+countryId,
                type: 'get',
                success: function (res) {
                    $('#city').html('<option value="">Select City</option>');
                    console.log("Getting");
                    $.each(res, function (key, value) {

                        $('#city').append('<option value="' + value
                            .id + '">' + value.name + '</option>');
                    });
                }
            });
        });
        {{--$('#city').on('change',function () {--}}
        {{--    var cityId = this.value;--}}

        {{--    $('#mosque').html('');--}}
        {{--    $.ajax({--}}
        {{--        url: '{{ route('getMosque') }}?city='+cityId,--}}
        {{--        type: 'get',--}}
        {{--        success: function (res) {--}}
        {{--            $('#mosque').html('<option value="">Select Mosque</option>');--}}
        {{--            console.log("Getting Mosques");--}}
        {{--            $.each(res, function (key, value) {--}}

        {{--                $('#mosque').append('<option value="' + value--}}
        {{--                    .id + '">' + value.name + '</option>');--}}
        {{--            });--}}
        {{--        }--}}


        {{--    });--}}

        {{--})--}}

    });


    $(document).ready(function () {
        $('#countryS').on('change', function () {
            var countryId = this.value;

            $('#mosque').html('');
            $.ajax({
                url: '{{ route('getValidMosque') }}?country='+countryId,
                type: 'get',
                success: function (res) {
                    $('#mosque').html('<option value="">Select Mosque</option>');
                    console.log("Getting Mosques..");
                    $.each(res, function (key, value) {

                        $('#mosque').append('<option value="' + value
                            .id + '">' + value.name + '</option>');
                    });
                }
            });
        });
        {{--$('#city').on('change',function () {--}}
        {{--    var cityId = this.value;--}}

        {{--    $('#mosque').html('');--}}
        {{--    $.ajax({--}}
        {{--        url: '{{ route('getMosque') }}?city='+cityId,--}}
        {{--        type: 'get',--}}
        {{--        success: function (res) {--}}
        {{--            $('#mosque').html('<option value="">Select Mosque</option>');--}}
        {{--            console.log("Getting Mosques");--}}
        {{--            $.each(res, function (key, value) {--}}

        {{--                $('#mosque').append('<option value="' + value--}}
        {{--                    .id + '">' + value.name + '</option>');--}}
        {{--            });--}}
        {{--        }--}}


        {{--    });--}}

        {{--})--}}

    });
</script>


<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
