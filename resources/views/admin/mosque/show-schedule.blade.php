
@extends('admin.layout')
@section('body_parts')
    <div class="row" style="margin-bottom: 40%; margin-top: 5%;">
        <h1 class="text-center text-4xl ">Schedule</h1>
        @if (\Session::has('Success'))
            <div class="alert alert-success">
                <ul>
                    <li style="color: #126604;text-align: center;">{!! \Session::get('Success') !!}</li>
                </ul>
            </div>
        @endif
{{--        <a href="{{url('add-notice',$mosque_id)}}"><p class="text-info underline bold">Add New>></p></a>--}}
        <div class="container text-center sm:mt-2 lg:mt-4 text-lg  w-11/12">
           <div class="row lg:ml-12 sm:ml-2">
               <div class="col-md-2">

               </div>
               <div class="col-md-6  bg-gray-500 shadow-xl rounded-lg ">
                   @if($count >0)
                   <table class="table ">
                       <tr>
                           <th>Prayer</th>
                           @if($startCount>0)
                           <th>Start</th>
                           @endif
                           @if($adhanCount>0)
                           <th>Azan</th>
                           @endif
                           @if($jamatCount>0)
                           <th>Jamat</th>
                               @endif
                       </tr>
                       <tr>
                           <td >Fazar</td>
                           @if($startCount>0)
                           <td>{{date("h:i A", strtotime($start->fazar))}}</td>
                           @endif

                           @if($adhanCount>0)
                           <td>{{date("h:i A", strtotime($adhan->fazar))}}</td>
                               @endif

                           @if($jamatCount>0)
                           <td>{{date("h:i A", strtotime($jamat->fazar))}}</td>
                               @endif

                       </tr>
                       <tr>
                           <td>Dhuhr</td>
                           @if($startCount>0)
                           <td>{{date("h:i A", strtotime($start->dhuhr))}}</td>
                           @endif

                           @if($adhanCount>0)
                           <td>{{date("h:i A", strtotime($adhan->dhuhr))}}</td>
                           @endif

                           @if($jamatCount>0)
                           <td>{{date("h:i A", strtotime($jamat->dhuhr))}}</td>
                           @endif

                       </tr>

                       <tr>
                           <td>Asr</td>
                           @if($startCount>0)
                               <td>{{date("h:i A", strtotime($start->asr))}}</td>
                           @endif

                           @if($adhanCount>0)
                               <td>{{date("h:i A", strtotime($adhan->asr))}}</td>
                           @endif

                           @if($jamatCount>0)
                               <td>{{date("h:i A", strtotime($jamat->asr))}}</td>
                           @endif
                       </tr>

                       <tr>
                           <td>Maghrib</td>
                           @if($startCount>0)
                               <td>{{date("h:i A", strtotime($start->maghrib))}}</td>
                           @endif

                           @if($adhanCount>0)
                               <td>{{date("h:i A", strtotime($adhan->maghrib))}}</td>
                           @endif

                           @if($jamatCount>0)
                               <td>{{date("h:i A", strtotime($jamat->maghrib))}}</td>
                           @endif
                       </tr>

                       <tr>
                           <td>Isha</td>
                           @if($startCount>0)
                               <td>{{date("h:i A", strtotime($start->isha))}}</td>
                           @endif

                           @if($adhanCount>0)
                               <td>{{date("h:i A", strtotime($adhan->isha))}}</td>
                           @endif

                           @if($jamatCount>0)
                               <td>{{date("h:i A", strtotime($jamat->isha))}}</td>
                           @endif
                       </tr>

                       <tr>
                           <td>Jummah</td>
                           @if($startCount>0)
                               <td>{{date("h:i A", strtotime($start->jummah))}}</td>
                           @endif

                           @if($adhanCount>0)
                               <td>{{date("h:i A", strtotime($adhan->jummah))}}</td>
                           @endif

                           @if($jamatCount>0)
                               <td>{{date("h:i A", strtotime($jamat->jummah))}}</td>
                           @endif
                       </tr>

                   </table>
                       @else
                   <h1 class="text-2xl  text-danger "> No Schedule Added Yet! <span class="text-info"> <a href="{{url('add-schedule',\App\Models\Mosque::where('admin_id',Auth::user()->id)->value('id'))}}">Add Now?</a></span></h1>
                       @endif

               </div>

               <div class="col-md-2"></div>
           </div>
            @if($count>0)
           <a href="{{url('edit-schedule')}}"> <button class="btn btn-github mt-4 ">Edit Schedule</button> </a>
            @endif

        </div>
    </div>
    <script src="https://cdn.tailwindcss.com"></script>

@endsection

