
@extends('admin.mosque.layout_from_here')
@section('body_parts')
    @php
    $scheduleCount = \App\Models\Schedule::where('mosque_id',$mosque_id)->count();

    @endphp
    <div class="row" style="margin-bottom: 40%; margin-top: 5%;">
        <h1 class="text-center text-4xl">Add Schedule of Your Mosque </h1>
        @if (\Session::has('Success'))
            <div class="alert alert-success">
                <ul>
                    <li style="color: #126604;text-align: center;">{!! \Session::get('Success') !!}</li>
                </ul>
            </div>
        @endif
        @if($scheduleCount>=1)
            <h1 class="text-2xl mt-4 text-danger text-center" >Schedule is Already Added! <a href="{{url('edit-schedule')}}" class="underline text-dark">Edit Now?</a></h1>
        @else
            <form action="{{url('addSchedule')}}" method="POST">
                @csrf
                <x-auth-validation-errors class="mb-4" :errors="$errors" />
{{--                Select Checkbox--}}
      <div class="option text-center mt-4 bg-gray-700">
          <label class="text-white text-2xl lg:px-12 sm:px-2 inline" for="startCheck">Start
          <input type="checkbox" class="text-purple-600 form-checkbox h-4 w-4 rounded-xl " name ="start"  id="startCheck">
          </label>

          <label class="text-white text-2xl lg:px-12 sm:px-2  inline" for="adhanCheck">Adhan
              <input type="checkbox" class="text-purple-600 form-checkbox h-4 w-4 rounded-xl " name ="adhan"  id="adhanCheck">
          </label>

          <label class="text-white text-2xl lg:px-12 sm:px-2 inline" for="jamatCheck">Jamat
              <input type="checkbox" class="text-purple-600 form-checkbox h-4 w-4 rounded-xl " name ="jamat"  id="jamatCheck">
          </label>
      </div>

            {{--            End Select Checkbox--}}



{{--                            Input Divs--}}



            <div class="inputfIELD text-center justify-content-center flex flex-col md:flex-row mt-4 " >
                {{--                   Start Time--}}

                <div class="inputs  w-11/12 h-full  justify-content-center flex text-center mb-2 block" id="start">
                    <div class="bg-red-200  w-11/12 h-full shadow-dark">
                        <h1 class="text-center text-xl">Start Time</h1>
                        <table class="p-2 w-full text-center " style=" border-collapse:separate;border-spacing:0 15px;">
                            <tr >
                                <td>
                                    <label for="fazar">Fazar</label>
                                    <input type="time" name="fazar_start" id="fazar_start" class="p-2 ml-4 bg-cyan-300 shadow-xl rounded-lg ">
                                </td>
                            </tr>


                            <tr>
                                <td>
                                    <label for="dhuhr">Dhuhr</label>
                                    <input type="time" name="dhuhr_start" id="dhuhr_start" class="p-2 ml-4 bg-cyan-300 shadow-xl rounded-lg ">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="asr">Asr</label>
                                    <input type="time" name="asr_start" id="asr_start" class="p-2 ml-8 bg-cyan-300 shadow-xl rounded-lg ">
                                </td>
                            </tr>


                            <tr>
                                <td>
                                    <label for="maghrib">Maghrib</label>
                                    <input type="time" name="maghrib_start" id="maghrib_start" class="p-2 ml-1 bg-cyan-300 shadow-xl rounded-lg ">
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <label for="isha">Isha</label>
                                    <input type="time" name="isha_start" id="isha_start" class="p-2 ml-6 bg-cyan-300 shadow-xl rounded-lg ">
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <label for="jummah_start">Jummah</label>
                                    <input type="time" name="jummah_start" id="jummah_start" class="p-2 ml-1 bg-cyan-300 shadow-xl rounded-lg ">
                                </td>
                            </tr>



                        </table>

                    </div>
                </div>


                {{--                        Adhan Time--}}

                <div class="inputs  w-11/12 h-full  justify-content-center flex text-center block mb-2" id="adhan">
                    <div class="bg-red-200  w-11/12 h-full shadow-dark">
                        <h1 class="text-center text-xl">Adhan Time</h1>
                        <table class="p-2 w-full text-center " style=" border-collapse:separate;border-spacing:0 15px;">
                            <tr >
                                <td>
                                    <label for="faraz_adhan">Faraz</label>
                                    <input type="time" name="faraz_adhan" id="faraz_adhan" class="p-2 ml-4 bg-cyan-300 shadow-xl rounded-lg ">
                                </td>
                            </tr>


                            <tr>
                                <td>
                                    <label for="dhuhr_adhan">Dhuhr</label>
                                    <input type="time" name="dhuhr_adhan" id="dhuhr_adhan" class="p-2 ml-4 bg-cyan-300 shadow-xl rounded-lg ">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="asr_adhan">Asr</label>
                                    <input type="time" name="asr_adhan" id="asr_adhan" class="p-2 ml-8 bg-cyan-300 shadow-xl rounded-lg ">
                                </td>
                            </tr>


                            <tr>
                                <td>
                                    <label for="maghrib_adhan">Maghrib</label>
                                    <input type="time" name="maghrib_adhan" id="maghrib_adhan" class="p-2 ml-1 bg-cyan-300 shadow-xl rounded-lg ">
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <label for="isha_adhan">Isha</label>
                                    <input type="time" name="isha_adhan" id="isha_adhan" class="p-2 ml-6 bg-cyan-300 shadow-xl rounded-lg ">
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <label for="jummah_adhan">Jummah</label>
                                    <input type="time" name="jummah_adhan" id="jummah_adhan" class="p-2 ml-1 bg-cyan-300 shadow-xl rounded-lg ">
                                </td>
                            </tr>










                        </table>

                    </div>
                </div>



{{--                Jamat Time--}}
                <div class="inputs  w-11/12 h-full justify-content-center flex text-center mb-2" id="jamat" >


                    <div class="bg-red-200  w-11/12 h-full shadow-dark">
                        <h1 class="text-center text-xl">Jamat Time</h1>
                        <table class="p-2 w-full text-center " style=" border-collapse:separate;border-spacing:0 15px;">
                            <tr >
                                <td>
                                    <label for="faraz_jamat">Faraz</label>
                                    <input type="time" name="faraz_jamat" id="faraz_jamat" class="p-2 ml-4 bg-cyan-300 shadow-xl rounded-lg ">
                                </td>
                            </tr>


                            <tr>
                                <td>
                                    <label for="dhuhr_jamat">Dhuhr</label>
                                    <input type="time" name="dhuhr_jamat" id="dhuhr_jamat" class="p-2 ml-4 bg-cyan-300 shadow-xl rounded-lg ">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="asr_jamat">Asr</label>
                                    <input type="time" name="asr_jamat" id="asr_jamat" class="p-2 ml-8 bg-cyan-300 shadow-xl rounded-lg ">
                                </td>
                            </tr>


                            <tr>
                                <td>
                                    <label for="maghrib_jamat">Maghrib</label>
                                    <input type="time" name="maghrib_jamat" id="maghrib_jamat" class="p-2 ml-1 bg-cyan-300 shadow-xl rounded-lg ">
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <label for="isha_jamat">Isha</label>
                                    <input type="time" name="isha_jamat" id="isha_jamat" class="p-2 ml-6 bg-cyan-300 shadow-xl rounded-lg ">
                                </td>
                            </tr>



                         <tr>
                                <td>
                                    <label for="jummah_jamat">Jummah</label>
                                    <input type="time" name="jummah_jamat" id="jummah_jamat" class="p-2 ml-1 bg-cyan-300 shadow-xl rounded-lg ">
                                </td>
                            </tr>




                        </table>

                    </div>

                </div>

<input type="hidden" value="{{$mosque_id}}" name="mosque_id">

            </div>
                <div class="buttonDiv text-center mt-6">
                    <button class="btn btn-github w-6/12  " type="submit" id="add">Add Schedule</button>

                </div>



            {{--                     End Input Divs--}}

{{--            Submit Button--}}


    </form>
            @endif

    </div>

    <script >
        const startCheck = document.getElementById('startCheck');
        const adhanCheck = document.getElementById('adhanCheck');
        const jamatCheck = document.getElementById('jamatCheck');


// Divs
        const startDiv = document.getElementById('start');
        const adhanDiv = document.getElementById('adhan');
        const jamatDiv = document.getElementById('jamat');

        const addButton = document.getElementById('add');


        startDiv.style.display = 'none';
        adhanDiv.style.display = 'none';
        jamatDiv.style.display = 'none';

        console.log('Working!');

let count = 0;
addButton.style.display = 'none'
        startCheck.addEventListener('change',function (event) {
           if(event.currentTarget.checked)
           {
               startDiv.style.display = 'block'
               count =count+1;

           }
           else{
               startDiv.style.display = 'none'
               count =count-1;
           }
            // Add Schedule Button Display When Any of Start/Adhan/Jamat is selected
            if(count ==0)
            {
                addButton.style.display = 'none'
                console.log('Count is   0')
            }
            else{
                addButton.style.display = 'inline'
                console.log('Count is greater than 0')
            }

        });

        adhanCheck.addEventListener('change',function (event) {
           if(event.currentTarget.checked)
           {
               adhanDiv.style.display = 'block'
               count =count+1;
           }
           else{
               adhanDiv.style.display = 'none'
               count =count-1;
           }


            // Add Schedule Button Display When Any of Start/Adhan/Jamat is selected

            if(count ==0)
            {
                addButton.style.display = 'none'
                console.log('Count is   0')
            }
            else{
                addButton.style.display = 'inline'
                console.log('Count is greater than 0')
            }

        });

        jamatCheck.addEventListener('change',function (event) {
           if(event.currentTarget.checked)
           {
               jamatDiv.style.display = 'block'
               count =count+1;
           }
           else{
               jamatDiv.style.display = 'none'
               count =count-1;
           }


            // Add Schedule Button Display When Any of Start/Adhan/Jamat is selected
            if(count ==0)
            {
                addButton.style.display = 'none'
                console.log('Count is   0')
            }
            else{
                addButton.style.display = 'inline'
                console.log('Count is greater than 0')
            }

        });





    </script>

    <script src="https://cdn.tailwindcss.com"></script>

@endsection
<style>

</style>

