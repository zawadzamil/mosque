<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PTD-Prayer Time Display</title>
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

//Function TO calculate English Time. For the future
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
<!--     <label class="switch mt-4">-->
<!--            <input type="checkbox" id="togBtn">-->
<!--               <div class="slider round">-->
<!--
                   <span class="on">বাংলা</span>-->
<!--                      <span class="off">English</span>-->
<!--
                    </div>-->
<!--           </label>-->
    <!--End Toggle Switch-->
{{--  Full Screen And Choice Button--}}
    <div class="sign">
        <a href="{{url('select-mosques')}}">
            <button class='w-60 bg-gray-700 text-white p-1  rounded-lg' style="position: relative"> Choose Location/ Mosques</button>
        </a>

        <button class='w-16 bg-yellow-800 text-white p-1  rounded-lg ' id="fullScreen" style="position: relative">[ ]</button>
        <button class='w-16 bg-orange-800 text-white p-1 rounded-lg ' id="exitFScreeen" style="position: relative">> <</button>

    </div>
    <div class="flex-1 max-w-8xl ">
        <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-2  gap-1 grid-flow-row pb-4 ">
            <!--Table Section-->
            <div class="   rounded-lg ml-12 mt-2  ">
                <!--English Table-->
                <table class="table-auto  sm:w-full text-cente  " id="eng-table" style="text-align: center;">
                    <thead class="bg-gray-800 ">
                    <tr>
                        <th >Prayer</th>
                        <th>Start</th>

                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Fazar</td>
                        <td id="f_start">06:25 AM</td>

                    </tr>
                    <tr>
                        <td>Dhuhr</td>
                        <td id="d_start">11:34 AM</td>

                    </tr>
                    <tr>
                        <td>Asr</td>
                        <td id="a_start">03:30 PM</td>

                    </tr>
                    <tr>
                        <td>Maghrib</td>
                        <td id="m_start">05:15 PM</td>

                    </tr>
                    <tr>
                        <td>Isha</td>
                        <td id="i_start">06:20 PM</td>

                    </tr>

                    </tbody>

                </table>
                <!--End English Table-->





            </div>
            <!--End Table Section-->

            <!--Image Slider -->
            <div class=" rounded-lg text-center px-10 ">
                <div class="imgbox ">
                    <img class="mySlides"  src="public/display/assets/images/m1.jpg">
                    <img class="mySlides"  src="public/display/assets/images/m2.jpg">
                    <img class="mySlides"  src="public/display/assets/images/m3.jpg">
                    <img class="mySlides"  src="public/display/assets/images/m4.jpg">
                    <img class="mySlides"  src="public/display/assets/images/m5.jpg">

                </div>

            </div>
            <!--End Image Slider -->

        </div>
        <!--Mosque Name Section-->
        <div class="  title-main text-center mb-2">
            <a href="">
                <p> <span class="shadow-xl text-4xl arabic  px-8 rounded-lg" id="name">{{$city->name}}, {{$country->name}}</span>

                </p>
            </a>

        </div>
        <!--End Mosque Name Section-->


        <!--Text Slider Section-->
        <div class="grid  grid-cols-1 slider-text shadow-2xl rounded-lg grid-flow-row   " id="slider">

            <div class="scrolling" >
                <h3 >Imagine sleeping without praying isha and waking up in your grave.



                </h3>

            </div>

        </div>
        <!--End Text Slider Section-->


    </div>
</div>
<input type="hidden" id="lat" value="{{$lat}}">
<input type="hidden" id="long" value="{{$long}}">
<input type="hidden" id="timezone" value="{{$timezone}}">



<script >
    // Full Screen
    const  fullScreenButton = document.getElementById('fullScreen');
    const  exitFullScreenButton = document.getElementById('exitFScreeen');
    exitFullScreenButton.style.display = 'none';

    var elem = document.documentElement;
    fullScreenButton.addEventListener('click',function () {
        console.log('Working!!');
        if (elem.requestFullscreen) {
            elem.requestFullscreen();
        } else if (elem.webkitRequestFullscreen) { /* Safari */
            elem.webkitRequestFullscreen();
        } else if (elem.msRequestFullscreen) { /* IE11 */
            elem.msRequestFullscreen();
        }




    });
    exitFullScreenButton.addEventListener('click',function () {
        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if (document.webkitExitFullscreen) {
            document.webkitExitFullscreen();
        } else if (document.msExitFullscreen) {
            window.top.document.msExitFullscreen();
        }

    })
    // Exit Full Screen Event Handel
    var fulScreenCount = 0;
    document.addEventListener("fullscreenchange", function() {
        if(fulScreenCount ==0)
        {
            fullScreenButton.style.display = 'none'
            fulScreenCount =1
            exitFullScreenButton.style.display = 'inline';
        }
        else{
            fullScreenButton.style.display = 'inline';
            fulScreenCount =0
            exitFullScreenButton.style.display = 'none';
        }
    });
</script>
<script src="public/display/js/userLocationSchedule.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/locale/af.min.js" integrity="sha512-xqLRtzampIqoDxDRyklcYk0fYDa7axgiSjTmyJFuzcK8vh1NDzqVPxcjIAvjb4t04u+rKMssANhgamUSnU71Uw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.js"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
</body>

</html>
