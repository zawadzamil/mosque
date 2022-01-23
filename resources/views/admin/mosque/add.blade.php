
@extends('admin.layout')
@section('body_parts')
    <div class="row" style="margin-bottom: 40%; margin-top: 5%;">
        <h1 class="text-center text-4xl">Add Mosque</h1>
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
                    <li style="color: #661614;text-align: center;">{!! \Session::get('failed') !!}</li>
                </ul>
            </div>
        @endif
        <form class="form-control text-center mt-4 sm:mt-1" action="{{url('addMosquetoDb')}} " method="POST">
            @csrf
{{--            Error Message--}}
            <x-auth-validation-errors class="mb-4" :errors="$errors" />
            <div class="form-group">
                <div class="nameSection">
                    <!-- Input Name -->
                    <label for="name" class="font-weight-bold">Name</label>

                    <input type="text" name="name" id="name" class="w-3/4 ml-4 h-12 rounded-lg p-md-3 px-sm-4 shadow-xl bg-cyan-100" placeholder="Enter Mosque Name" required>

                    {{--                End Input Name--}}
                </div>


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
                {{--              End  Input City--}}


                {{--                Input Area--}}


{{--                <div class="dropdown " style="display: inline" >--}}
{{--                    --}}{{--                Dhaka--}}
{{--                    <select name="area" id="districtSel" class="p-3 mt-4 w-25 ml-2  shadow-xl rounded-lg " required >--}}
{{--                        <option  value="" selected disabled>Choose Your Area</option>--}}



{{--                    </select>--}}



{{--                </div>--}}





                {{--              End  Input Area--}}

                <!--Button -->



            </div>
            <button class="btn bg-red-500 hover:bg-sky-700 text-light mt-4  btn-block" type="submit">Submit</button>
        </form>

    </div>

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

        });
    </script>
@endsection

