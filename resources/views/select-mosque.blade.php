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

    <title>Select Mosque</title>
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



        <div class="col-lg-6 col-sm-4 text-xl text-light text-center   ">
            <form class="form-control text-center  mt-4 sm:mt-1" action="{{url('user-select-mosque')}} " method="POST">
                @csrf
                {{--            Error Message--}}

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



                    <div class="dropdown " style="display: block">
                        <select name="mosque_id" id="mosque" class="p-3 mt-4 w-full ml-2  shadow-xl rounded-lg " required >





                        </select>

                    </div>


                </div>
                <button class="btn bg-red-500 hover:bg-sky-700 text-light mt-4  btn-block" type="submit">Submit</button>

            </form>


        </div>





    </div>
</div>















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
        $('#city').on('change',function () {
            var cityId = this.value;

            $('#mosque').html('');
            $.ajax({
                url: '{{ route('getMosque') }}?city='+cityId,
                type: 'get',
                success: function (res) {
                    $('#mosque').html('<option value="">Select Mosque</option>');
                    console.log("Getting Mosques");
                    $.each(res, function (key, value) {

                        $('#mosque').append('<option value="' + value
                            .id + '">' + value.name + '</option>');
                    });
                }


            });

        })

    });
</script>


<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
