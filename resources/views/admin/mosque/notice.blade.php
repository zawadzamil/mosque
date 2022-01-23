
@extends('admin.mosque.layout_from_here')
@section('body_parts')
    @php
    $noticeCount = \App\Models\Notice::where('mosque_id',$mosque_id)->count();
    @endphp
    <div class="row" style="margin-bottom: 40%; margin-top: 5%;">
        <h1 class="text-center text-4xl">Add a Notice </h1>
        @if (\Session::has('Success'))
            <div class="alert alert-success">
                <ul>
                    <li style="color: #126604;text-align: center;">{!! \Session::get('Success') !!}</li>
                </ul>
            </div>
        @endif

        @if($noticeCount >= 10)
            <h1 class="text-center text-danger text-xl mt-8">You Cannot Add More Notices! Delete Some</h1>
            <h1 class="text-center text-info text-xl mt-4"><a href="{{url('show-notice')}}"> View Notice >></a> </h1>
        @else
        <form class="form text-center mt-4 sm:mt-1" action="{{url('addNotice')}} " method="POST">
        @csrf
            {{--            Error Message--}}
            <x-auth-validation-errors class="mb-4" :errors="$errors" />
            <div class="form-control">
               <p class="text-xl">Add You Notice Here (<span class="text-info">{{10-$noticeCount}} More Notice Can be Added!</span>)</p>

                <textarea class="w-4/6 shadow-success rounded-lg bg-gray-200  mt-4 p-4"  id="notice" name="notice" maxlength="1000" required>
   The Notice is ......
</textarea>
                <input type="hidden" name="mosque_id" value="{{$mosque_id}}">
            </div>
            <button class="btn bg-red-500 hover:bg-sky-700 text-light mt-4  btn-block" type="submit">Submit</button>
        </form>
            @endif



    </div>
    <script src="https://cdn.tailwindcss.com"></script>

@endsection

