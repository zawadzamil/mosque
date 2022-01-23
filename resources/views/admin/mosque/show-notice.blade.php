
@extends('admin.layout')
@section('body_parts')
    <div class="row" style="margin-bottom: 40%; margin-top: 5%;">
        <h1 class="text-center text-4xl">Notices</h1>
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
                    <li style="color: #660009;text-align: center;">{!! \Session::get('failed') !!}</li>
                </ul>
            </div>
        @endif
      <a href="{{url('add-notice',$mosque_id)}}"><p class="text-info underline bold">Add New>></p></a>
        @if($noticeCount==0)
        <h1 class="text-center text-xl mt-4">No Notice Added. <span class="text-info hover:text-danger"> <a href="{{url('add-notice',$mosque_id)}}">Add Now?</a></span></h1>
        @endif
      <div class="container text-center sm:mt-2 lg:mt-4 text-lg  w-11/12">
          @foreach($notices as $notice)
          <div class="row sm:ml-4 lg:ml-6 shadow-xl rounded-lg py-4">
              <div class="col-md-3 ">
                  Notice Id: {{$notice->id}}


              </div>

              <div class="col-md-6  text-left">
                  Notice : {{$notice->notice}}


          </div>
              <div class="col-md-1 text-info underline">
                  <a href="{{url('edit-notice',$notice->id)}}"> Edit?</a>


              </div>

              <div class="col-md-1 text-danger underline">
                  <a href="{{url('deleteNotice',$notice->id)}}"> Delete?</a>


              </div>
      </div>
              @endforeach


    </div>
    </div>
    <script src="https://cdn.tailwindcss.com"></script>

@endsection

