
@extends('admin.mosque.layout_from_here')
@section('body_parts')
    <div class="row" style="margin-bottom: 40%; margin-top: 5%;">
        <h1 class="text-center text-4xl">Add a Notice </h1>
        @if (\Session::has('Success'))
            <div class="alert alert-success">
                <ul>
                    <li style="color: #126604;text-align: center;">{!! \Session::get('Success') !!}</li>
                </ul>
            </div>
        @endif
        <form class="form text-center mt-4 sm:mt-1" action="{{url('updateNotice',$notice->id)}} " method="POST">
            @csrf
            {{--            Error Message--}}
            <x-auth-validation-errors class="mb-4" :errors="$errors" />
            <div class="form-control">
                <p class="text-xl">Add You Notice Here</p>

                <textarea class="w-4/6 shadow-success rounded-lg bg-gray-200  mt-4 p-4"  id="notice" name="notice" maxlength="1000" required>
  {{$notice->notice}}
</textarea>
                <input type="hidden" name="mosque_id" value="{{$mosque_id}}">
            </div>
            <button class="btn bg-red-500 hover:bg-sky-700 text-light mt-4  btn-block" type="submit">Edit</button>
        </form>


    </div>
    <script src="https://cdn.tailwindcss.com"></script>

@endsection

