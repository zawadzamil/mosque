<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Islamic Association</title>
    <link rel="stylesheet" href="public/display/css/display.css" type="text/css" media="all">
    <!--Tailwind CSS-->
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    <!--Font Link-->
    <link href="https://www.dafontfree.net/embed/cm9kamEtcm9kamEmZGF0YS80OS9yLzM0NzE2L1JvZGphLnR0Zg" rel="stylesheet"
          type="text/css" />

    <!--Bangla Font-->
    <link href="https://fonts.maateen.me/mukti/font.css" rel="stylesheet">


</head>

<body class="bg-gray-200">
@php

    use Rakibhstu\Banglanumber\NumberToBangla;


        function convertNumber($time)
    {
         $numto = new NumberToBangla();
        $hour =  (int)substr($time, 0, 2);
        $mini = (int)substr($time, 3, 2);
        $meridian =  substr($time, -2, 1);

        $banHour = $numto->bnNum($hour);
        $banMin = $numto->bnNum($mini);

        $banMeridian = '';
        if($meridian=='A')
            {
                $banMeridian = 'পূর্বাহ্ন';
            }
        else{
            $banMeridian = 'অপরাহ্ন';

        }

        return $banHour.':'.$banMin.' '.$banMeridian;

    }
@endphp
<!--Clock-->
<div class="clock-section">
    <div class="clock text-center">
            <span id="time" class="  font-bold  ">

            </span>
        <span id = "dateBottom" ></span>
    </div>





</div>

<!--Clock End-->







<div class="min-h-screen  item-center text-center mt-6">
    <!--Toggle Switch-->
{{--    <label class="switch mt-4">--}}
{{--        <input type="checkbox" id="togBtn">--}}
{{--        <div class="slider round">--}}
{{--            <!--ADDED HTML -->--}}
{{--            <span class="on">বাংলা</span>--}}
{{--            <span class="off">English</span>--}}
{{--            <!--END-->--}}
{{--        </div>--}}
{{--    </label>--}}
    <!--End Toggle Switch-->
    <div class="flex-1 max-w-8xl ">
        <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-2  gap-1 grid-flow-row pb-4 ">
            <!--Table Section-->
            <div class="   rounded-lg ml-12 mt-2  ">
                <!--English Table-->
                <table class="table ">
                    <tr class="bg-gray-700">

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
                <!--End English Table-->


                <!--Bangla Table-->

                <table class="table-auto  sm:w-full  " id="ban-table">
                    <thead class="bg-red-800">
                    <tr>
                        <th>নামাজ</th>
                        <th class="ml-4">আজান</th>
                        <th>জামাত</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>ফজর</td>
                        <td >{{convertNumber(date("h:i A", strtotime($schedule->fazar_start))) }}</td>
                        <td >{{convertNumber(date("h:i A", strtotime($schedule->fazar_jamat))) }}</td>
                    </tr>
                    <tr>
                        <td>জোহর</td>
                        <td >{{convertNumber(date("h:i A", strtotime($schedule->dhuhr_start))) }}</td>
                        <td >{{convertNumber(date("h:i A", strtotime($schedule->dhuhr_jamat))) }}</td>
                    </tr>
                    <tr>
                        <td>আছর</td>
                        <td >{{convertNumber(date("h:i A", strtotime($schedule->asr_start))) }}</td>
                        <td >{{convertNumber(date("h:i A", strtotime($schedule->asr_jamat))) }}</td>
                    </tr>
                    <tr>
                        <td>মাগরিব</td>
                        <td >{{convertNumber(date("h:i A", strtotime($schedule->maghrib_start))) }}</td>
                        <td >{{convertNumber(date("h:i A", strtotime($schedule->maghrib_jamat))) }}</td>
                    </tr>
                    <tr>
                        <td>এশা </td>
                        <td>{{convertNumber(date("h:i A", strtotime($schedule->isha_start))) }}</td>
                        <td >{{convertNumber(date("h:i A", strtotime($schedule->isha_jamat))) }}</td>
                    </tr>
                    <tr>
                        <td>জুম্মা</td>
                        <td>{{convertNumber(date("h:i A", strtotime($schedule->jummah_start))) }}</td>
                        <td >{{convertNumber(date("h:i A", strtotime($schedule->jummah_jamat))) }}</td>
                    </tr>
                    </tbody>

                </table>

                <!--End Bangla Table-->



            </div>
            <!--End Table Section-->

            <!--Image Slider -->
            <div class=" rounded-lg text-center px-10 ">
                <div class="imgbox ">
                    @foreach($photos as $photo)

                        <img class="mySlides"  src="public/images/{{$photo->photo}}">
                    @endforeach

                </div>

            </div>
            <!--End Image Slider -->

        </div>
        <!--Mosque Name Section-->
        <div class="  title-main text-center mb-2">
            <a href="login/index.html">
                <p> <span class="shadow-xl text-4xl arabic  px-8 rounded-lg" id="arabic">{{$mosque_name}}</span>

                </p>
            </a>
            <a href="login/index.html">
                <p> <span class="shadow-xl text-3xl bangla  px-8 rounded-lg" id="bangla">{{$mosque_name}}</span>

                </p>
            </a>
        </div>
        <!--End Mosque Name Section-->


        <!--Text Slider Section-->
        <div class="grid  grid-cols-1 slider-text shadow-2xl rounded-lg grid-flow-row   " id="slider">

            <div class="scrolling">
                <h3 >@foreach($notices as $notice)
                        ***{{$notice->notice}}***
                    @endforeach

                </h3>

            </div>

        </div>
        <!--End Text Slider Section-->

    </div>
</div>





<script src="public/display/js/app.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/locale/af.min.js" integrity="sha512-xqLRtzampIqoDxDRyklcYk0fYDa7axgiSjTmyJFuzcK8vh1NDzqVPxcjIAvjb4t04u+rKMssANhgamUSnU71Uw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.js"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
</body>

</html>
